@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Payment history</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">
                                <th style="display: none;">ID</th>
                                <th style="display: none;">ID Product</th>
                                <th style="display: none;">ID Request</th>
                                <th style="color:#fff;">Name</th>
                                <th style="color:#fff;">Price</th>
                                <th style="color:#fff;">Amount</th>
                                <th style="color:#fff;">Total</th>
                                <th style="color:#fff;">Status</th>
                                <th style="color:#fff;">Actions</th>
                                </thead>
                                <tbody>

                                @foreach($purchases as $purchase)
                                    <tr>
                                        <td
                                            style="display: none;">{{ $purchase->id }}
                                        </td>
                                        <td
                                            style="display: none;">{{ $purchase->id_product }}
                                        </td>
                                        <td
                                            style="display: none;">{{ $purchase->id_request }}
                                        </td>
                                        <td>
                                            {{ $purchase->name }}
                                        </td>
                                        <td>
                                            {{ $purchase->price }}
                                        </td>
                                        <td>
                                            {{ $amount = $purchase->amount }}
                                        </td>
                                        <td>
                                            {{$total = $amount*$purchase->price}}
                                        </td>
                                        <td>
                                            {{ $purchase->status }}
                                        </td>
                                        <td style="display: none;">{{$reference = "15january2021"}}</td>
                                        <td style="display: none;">{{ $description = "buy" }}</td>
                                        <td>
                                            <form action="{{ route('payment.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id_purchase" value="{{ $purchase->id }}">
                                                    <input type="hidden" name="id_product" value="{{ $purchase->id_product }}">
                                                    <input type="hidden" name="name" value="{{ $purchase->name }}">
                                                    <input type="hidden" name="price" value="{{ $purchase->price }}">
                                                    <input type="hidden" name="amount" value="{{$amount}}" >
                                                    <input type="hidden" name="total" value="{{$total}}">
                                                    <input type="hidden" name="reference" value="{{$reference}}">
                                                    <input type="hidden" name="description" value="{{$description = "BUY"}}">
                                                    <input type="submit" name="btn" class="btn btn-primary" value="BUY">
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('payment.update', $purchase->id_request) }}" method="PATCH">
                                                @csrf
                                                <input type="hidden" name="id_request" value="{{ $purchase->id_request }}">
                                                <input type="submit" name="btn" class="btn btn-primary" value="UPDATE">
                                            </form>
                                        </td>
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
