@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">CART</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('welcome') }}" method="get">
                                <button type="submit" class="btn btn-primary">
                                    Shopping
                                </button>
                            </form>

                            <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">Name</th>
                                    <th style="color:#fff;">Price</th>
                                    <th style="color:#fff;">Quantity</th>
                                    <th style="color:#fff;">Subtotal</th>
                                    <th style="color:#fff;">Actions</th>
                                </thead>
                                <tbody>

                                    @foreach($products as $product)
                                        <tr>
                                            <td style="display: none;">{{ $product->rowId }}</td>
                                            <td style="display: none;">{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td class="btn-group" role="group">

                                                <div class="input-group mb-3">

                                                    <form id="quantityDown{{$product->rowId}}" action="{{ route('cart.update.up') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="rowId" value="{{$product->rowId}}" id="quantityDown{{$product->rowId}}">
                                                        <input type="hidden" name="quantity" value="{{$product->qty - 1}}" id="quantityDown{{$product->rowId}}">
                                                        <button type="submit" name="btn" class="btn btn-outline-primary" id="quantityDown{{$product->rowId}}">-</button>
                                                    </form>
                                                    <label class="btn btn-outline-primary">{{$product->qty}}</label>
                                                    <form id="quantityUp{{$product->rowId}}" action="{{ route('cart.update.up') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="rowId" value="{{$product->rowId}}" id="quantityUp{{$product->rowId}}">
                                                        <input type="hidden" name="quantity" value="{{$product->qty + 1}}" id="quantityUp{{$product->rowId}}">
                                                        <button type="submit" name="btn" class="btn btn-outline-primary" id="quantityUp{{$product->rowId}}">+</button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td>{{$subtotals[] = $product->price * $product->qty}}</td>
                                            <td style="display: none;">{{$reference = ""}}</td>
                                            <td style="display: none;">{{ $description = "buy" }}</td>
                                            <td>
                                                <form id="delete" action="{{ route('cart.delete') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="rowId" value="{{$product->rowId}}" id="delete">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <div style="display: none;">
                                    {{$total = 0}}
                                    @foreach($subtotals as $subtotal)
                                        {{$total += $subtotal}}
                                    @endforeach
                                </div>
                                <tfoot>
                                <tr>
                                    <td colspan="3">Total</td>
                                    <td colspan="3">${{$total}}</td>
                                </tr>
                                </tfoot>
                             </table>
                            <form action="{{ route('payment.store')}}" method="POST">
                                @csrf


                                <input type="hidden" name="total" value="{{$total}}">
                                <input type="hidden" name="description" value="{{$description}}">
                                <button type="submit" class="btn btn-primary">BUY</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


