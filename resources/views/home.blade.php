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
                            <div class="row">
                                <div class="col-md-4 col-xl-4">

                                    <div class="card bg-c-blue order-card">
                                        <div class="card-block">
                                            <h5>Users</h5>
                                            @php
                                                use App\Models\User;
                                               $amount_users = User::count();
                                            @endphp
                                            <h2 class="text-right"><i class="fa fa-users f-left"></i><span>{{$amount_users}}</span></h2>
                                            <p class="m-b-0 text-right"><a href="/users" class="text-white">More</a></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xl-4">
                                    <div class="card bg-c-green order-card">
                                        <div class="card-block">
                                            <h5>Roles</h5>
                                            @php
                                                use Spatie\Permission\Models\Role;
                                                 $amount_roles = Role::count();
                                            @endphp
                                            <h2 class="text-right"><i class="fa fa-user-lock f-left"></i><span>{{$amount_roles}}</span></h2>
                                            <p class="m-b-0 text-right"><a href="/roles" class="text-white">More</a></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xl-4">
                                    <div class="card bg-c-pink order-card">
                                        <div class="card-block">
                                            <h5>Products</h5>
                                            @php
                                                use App\Models\product;
                                               $amount_products = product::count();
                                            @endphp
                                            <h2 class="text-right"><i class="fa fa-layer-group f-left"></i><span>{{$amount_products}}</span></h2>
                                            <p class="m-b-0 text-right"><a href="/products" class="text-white">More</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
