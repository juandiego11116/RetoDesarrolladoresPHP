@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Users</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div>
                            <input class="form-control"
                                   type="searh"
                                   placeholder="search"
                                   v-model="search"
                                   @keyup="users">
                        </div>
                        <div class="card-body">

                            @can('create-user')
                            <a class="btn btn-warning" href="{{route('users.create')}}">New</a>
                            @endcan
                            <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">
                                <th style="display: none;">ID</th>
                                <th style="color:#fff;">Firts Name</th>
                                <th style="color:#fff;">Last name</th>
                                <th style="color:#fff;">E-mail</th>
                                <th style="color:#fff;">Role</th>
                                <th style="color:#fff;">Actions</th>
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
                                                @can('edit-user')
                                                    <a class="btn btn-info" href="{{ route('users.edit', $user->id) }}">Edit</a>
                                                @endcan
                                                @can('delete-user')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $users->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')

    <script src="{{ asset('js/search.js') }}"></script>

@endsection


