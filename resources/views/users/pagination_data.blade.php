<table class="table table-bordered">
 <tr>
   <th>No</th>
   <th>User Name</th>
   <th>Name</th>
   <th>Last Name</th>
   @role('Admin')
   <th>Email</th>
   <th>Roles</th>
   
   <th width="280px">Action</th>
   @endrole
 </tr>
 @foreach ($data as $key => $user)
  <tr id="userid{{$user->id}}">
    <td>{{ $user->id}}</td>
    <td>{{ $user->username }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->lastname }}</td>
    @role('Admin')
      <td>{{ $user->email }}</td>
      <td>
        @if(!empty($user->getRoleNames()))
          @foreach($user->getRoleNames() as $v)
            <label class="badge badge-success">{{ $v }}</label>
          @endforeach
        @endif
      </td>
    
      <td>
        <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
        <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
        <button class="btn btn-danger deleteUser" data-id="{{ $user->id }}" >Delete</button>
        
      </td>
    @endrole
  </tr>
 @endforeach
</table>
  {!! $data->links() !!}

