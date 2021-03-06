@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Products</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div>
                            <form href="{{route('products.index')}}" method="get">
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control"  name="text" placeholder="search" value="{{$text}}">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            @can('create-product')
                                <a class="btn btn-warning" href="{{ route('products.create') }}">New</a>
                            @endcan

                            <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">
                                <th style="display: none;">ID</th>
                                <th style="color:#fff;">Image</th>
                                <th style="color:#fff;">Name</th>
                                <th style="color:#fff;">Price</th>
                                <th style="color:#fff;">Stock Number</th>
                                <th style="color:#fff;">Category</th>
                                <th style="color:#fff;">Actions</th>
                                </thead>
                                <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td style="display: none;">{{ $product->id }}</td>
                                        <td><img src="{{$product->photo}}" width="100" height="100"></td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->stock_number }}</td>
                                        <td>{{ $product->categories->name}}</td>

                                        <td>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                @can('edit-product')
                                                    <a class="btn btn-info" href="{{ route('products.edit', $product->id) }}">Edit</a>
                                                @endcan

                                                @csrf
                                                @method('DELETE')
                                                @can('delete-product')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <!-- Ubicamos la paginacion a la derecha -->
                            <div class="pagination justify-content-end">
                                {!! $products->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
