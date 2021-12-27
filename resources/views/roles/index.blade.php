@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Roles</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('createRole')
                                <a class="btn btn-warning" href="{{ route('roles.create') }}">New</a>
                            @endcan
                                <table class="table table-striped mt-2">
                                    <thead style="background-color: #6777ef">
                                    <tr style="color: #fff;">Role</tr>
                                    <tr style="color: #fff;">Actions</tr>
                                    </thead>
                                    <tbody>
                                    @foreach($roles as $role)
                                        <tr>
                                            <td style="display: none;">{{$role->name}}</td>
                                            <td>
                                                @can('editRole')
                                                    <a class="btn btn-primary" href="{{route('roles.edit', $role->id)}}">Edit</a>
                                                @endcan
                                                @can()
                                                @endcan()
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
