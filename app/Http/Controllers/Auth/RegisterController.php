<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if ($data['roles'] == 'Admin') {
            return Validator::make(
                $data,
                [
                    'username' => 'required|string|max:20|unique:users',
                    'name' => ['required', 'string', 'max:255'],
                    'lastname' => 'required',
                    'email' => [
                        'required',
                        'string',
                        'email',
                        'max:255',
                        'unique:users',
                    ],
                    'password' => 'required|min:8|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])/
                    |confirmed',
                    'roles' => 'required',
                ],
                [
                    'password.regex' =>
                        'Password should contain min of 8 chars, one Uppercase letter and digits',
                ]
            );
        }
        return Validator::make(
            $data,
            [
                'username' => 'required|string|max:20|unique:users',
                'name' => ['required', 'string', 'max:255'],
                'lastname' => 'required',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users',
                ],
                'password' => 'required|min:4|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])/
                |confirmed',
                'roles' => 'required',
            ],
            [
                'password.regex' =>
                    'Password should contain min of 4 chars, one Uppercase letter and digits',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $role = Role::where('name', $data['roles'])->first();

        $data['is_admin'] = $role->name == 'Admin' ? true : false;
        $data['role_id'] = $role->id;

        $user = User::create($data);
        $user->assignRole($data['roles']);
        return $user;
    }

    public function showRegistrationForm()
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('auth.register', compact('roles'));
    }
}
