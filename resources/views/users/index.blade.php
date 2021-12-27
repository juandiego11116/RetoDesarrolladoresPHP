@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Dashboard</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Users</h3>
                            <a class="btn btn-warning" href="{{route('users.create')}}"></a>
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                <tr style="display: none;">ID</tr>
                                <tr style="color: #fff;">First Name</tr>
                                <tr style="color: #fff;">Last Name</tr>
                                <tr style="color: #fff;">Email</tr>
                                <tr style="color: #fff;">Role</tr>
                                <tr style="color: #fff;">Actions</tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td style="display: none;">{{$user->id}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->last_name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>
                                                @if(!empty($user->getRoleNames()))
                                                    @foreach($user->getRoleNames() as $rolName)
                                                    <h5><span class="badge badge-dark">{{$rolName}}</span></h5>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-info" href="{{ route('users.edit', $user->id) }}">Edit</a>
                                            </td>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}
                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $user->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


