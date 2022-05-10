@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Finish transaction</h3>
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
                            <form action="{{ route('payment.history') }}" method="get">
                                <button type="submit" class="btn btn-primary">
                                    History
                                </button>
                            </form>
                            <p class="mt-4 text-center text-gray-600 font-bold"> Your transaction is: {{$purchases[0]->status}}</p>
                            <p class="mt-4 text-center text-gray-600 font-bold"> Number transaction is: {{$reference}}</p>
                            <p class="mt-4 text-center text-gray-600 font-bold"> Total paid: {{$purchases[0]->total}}</p>
                            <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">
                                <th style="display: none;">ID</th>
                                <th style="color:#fff;">Name</th>
                                <th style="color:#fff;">Price</th>
                                <th style="color:#fff;">Quantity</th>
                                <th style="color:#fff;">Sutotal</th>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td style="display: none;">{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->amount }}</td>
                                        <td>{{$subtotals[] = $product->price * $product->amount}}</td>
                                        <td style="display: none;">{{$reference = ""}}</td>
                                        <td style="display: none;">{{ $description = "buy" }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
