@extends('master')
@section('content')

	<div class="row">
		<div class="col-md-3"><h2>Users</h2></div>
		
		<div class="col-md-12" style="margin-top:20px;">
			
			<table class="table table-condensed">
			<thead>
				<tr>
					<th> Name </th>
					<th> Username </th>
					<th> E-mail</th>
				</tr>
			</thead>
			<tbody>
				@if(!count($users))
				<tr>
					<td>Data Not Found..!</td>
				</tr>
				@endif
 				@foreach($users as $user)
 				<tr>
 					<td> {{ $user->first_name }} {{ $user->last_name }}</td>
 					<td> {{ $user->username }}</td>
 					<td> {{ $user->email }}</td> 
 						
 				</tr>
 				@endforeach
 			</tbody>
			</table>
		</div>
		<div class="col-md-8 col-md-offset-4">
			{{ $users->links() }}
		</div>
	</div>

	@endsection

	