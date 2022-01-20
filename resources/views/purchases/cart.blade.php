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
                            <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">Name</th>
                                    <th style="color:#fff;">Price</th>
                                    <th style="color:#fff;">Amount</th>
                                    <th style="color:#fff;">Total</th>
                                    <th style="color:#fff;">Actions</th>
                                </thead>
                                <tbody>

                                    @foreach($product as $product)
                                        <form action="{{ route('payment.store') }}" method="POST">
                                            @csrf
                                        <tr>
                                            <td
                                                style="display: none;">{{ $product->id }}
                                                <input type="hidden" name="id_product" value="{{ $product->id }}">
                                            </td>
                                            <td>
                                                {{ $product->name }}
                                                <input type="hidden" name="name" value="{{ $product->name }}">
                                            </td>
                                            <td>
                                                {{ $product->price }}
                                                <input type="hidden" name="price" value="{{ $product->price }}">
                                            </td>
                                            <td>
                                                <input type="number" name="amount" value="{{$amount}}" >
                                            </td>


                                                <td>
                                                    {{$total = $amount*$product->price}}
                                                    <input type="hidden" name="total" value="{{$total}}">
                                                </td>
                                                <td style="display: none;">{{$reference = "15january2021"}}</td>
                                                <input type="hidden" name="reference" value="{{$reference}}">
                                                <td style="display: none;">{{ $description = "buy" }}</td>
                                                <input type="hidden" name="description" value="{{$description}}">
                                                <td>
                                                    <input type="submit" name="btn" class="btn btn-primary" value="BUY">
                                                </td>

                                        </tr>
                                    @endforeach
                                </form>
                                </tbody>
                             </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
