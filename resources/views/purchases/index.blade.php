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
                                <th style="color:#fff;">Name</th>
                                <th style="color:#fff;">Price</th>
                                <th style="color:#fff;">Stock Number</th>
                                <th style="color:#fff;">Category</th>
                                <th style="color:#fff;">Amount</th>
                                <th style="color:#fff;">Actions</th>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td style="display: none;">{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->stock_number }}</td>
                                            <td>{{ $product->category }}</td>
                                            <td>
                                                <form id="purchases-form{{$product->id}}" action="{{ route('purchases.create') }}" method="get">
                                                        <div class="flex">
                                                            <input type="number" name="amount" value="{{"amount"}}" form="purchases-form{{$product->id}}">
                                                            <input type="hidden" name="product" value="{{$product->id}}" form="purchases-form{{$product->id}}">
                                                            <button type="submit" name="btn" class="btn btn-info" form="purchases-form{{$product->id}}">ADD TO CARD</button>
                                                        </div>
                                                </form>
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

