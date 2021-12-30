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
                        <div>
                            <form href="{{route('roles.index')}}" method="get">
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control"  name="text" placeholder="search" value="{{$text}}">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">

                            @can('create-role')
                                <a class="btn btn-warning" href="{{ route('roles.create') }}">new</a>
                            @endcan


                            <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">
                                <th style="color:#fff;">Role</th>
                                <th style="color:#fff;">Actions</th>
                                </thead>
                                <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @can('edit-role')
                                                <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                            @endcan

                                            @can('delete-role')
                                                {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="pagination justify-content-end">
                                {!! $roles->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
