<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::paginate(5);
        return view('users.index', compact('data'));
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $data = User::paginate(5);
            return view('users.pagination_data', compact('data'))->render();
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string|max:20|unique:users',
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);
        if ($request->input('roles') == 'Admin') {
            $this->validate(
                $request,
                [
                    'password' => 'required|min:8|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])/
                    |same:confirm-password',
                    'roles' => 'required',
                ],
                [
                    'password.regex' =>
                        'Password should contain min of 8 chars, one Uppercase letter and digits',
                ]
            );
        }

        $this->validate(
            $request,
            [
                'password' => 'required|
                min:4|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])/
                |same:confirm-password',
                'roles' => 'required',
            ],
            [
                'password.regex' =>
                    'Password should contain min of 4 chars, one Uppercase letter and digits',
            ]
        );

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $role = Role::where('name', $request->input('roles'))->first();

        $input['is_admin'] = $role->name == 'Admin' ? true : false;
        $input['role_id'] = $role->id;

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            // 'username' => 'required|string|max:20|unique:users',
            'name' => 'required',
            'lastname' => 'required',
            // 'email' => 'required|email|unique:users,email',
        ]);
        if ($request->input('roles') == 'Admin') {
            $this->validate(
                $request,
                [
                    'password' => 'required|min:8|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])/
                    |same:confirm-password',
                    'roles' => 'required',
                ],
                [
                    'password.regex' =>
                        'Password should contain min of 8 chars, one Uppercase letter and digits',
                ]
            );
        }

        $this->validate(
            $request,
            [
                'password' => 'required|
                min:4|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])/
                |same:confirm-password',
                'roles' => 'required',
            ],
            [
                'password.regex' =>
                    'Password should contain min of 4 chars, one Uppercase letter and digits',
            ]
        );
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')
            ->where('model_id', $id)
            ->delete();

        $user->assignRole($request->input('roles'));

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json([
            'success' => 'User deleted successfully!',
        ]);
    }
}
