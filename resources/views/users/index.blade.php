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
                            <form href="{{route('users.index')}}" method="get">
                               <div class="form-row">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control"  name="text" placeholder="search" value="{{$text}}">
                                    </div>
                               </div>
                            </form>
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
<script>
    window.addEventListener("load", function(){
        document.getElementById("text").addEventListener("keyup",function (){
           fetch(`users.search?text=${ document.getElementById("text").value}`,{
                method:'get'
           })
            .then(response =>response.text())
            .then(html =>{

                document.getElementById('result').innerHTML += html

            })

        })
    })
</script>


