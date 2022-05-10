@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Shopping</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
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
                                            <td>{{ $product->categories->name }}</td>
                                            <td>
                                                <a class="btn btn-info" href="{{ route('purchases.show', $product->id) }}">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <a class="btn btn-info" href="{{ route('purchases.create') }}">CARD</a>
                                </tbody>
                            </table>
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

