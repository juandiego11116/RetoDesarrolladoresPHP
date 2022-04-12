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
                        <div>
                            <form href="{{route('purchases.index')}}" method="get">
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control"  name="text" placeholder="search" value="{{$text}}">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">
                                <th style="display: none;">ID</th>
                                <th style="display: none;">ID Product</th>
                                <th style="display: none;">ID Request</th>
                                <th style="color:#fff;">Reference</th>
                                <th style="color:#fff;">Total</th>
                                <th style="color:#fff;">Status</th>
                                <th style="color:#fff;">Actions</th>
                                <th style="color:#fff;"></th>
                                </thead>
                                <tbody>

                                @foreach($purchases as $purchase)
                                    <tr>
                                        <td
                                            style="display: none;">{{ $purchase->id }}
                                        </td>
                                        <td>
                                            {{ $purchase->reference }}
                                        </td>

                                        <td step="0.01">
                                            {{ $purchase->total }}
                                        </td>

                                        <td style="display: none;">
                                            {{ $purchase->status }}
                                            @if($purchase->status === 'APPROVED')
                                                {{$button = 'Buy again   '}}
                                            @else
                                                {{$button = 'Pay again'}}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $purchase->status }}
                                        </td>
                                        <td style="display: none;">{{$reference = "15january2021"}}</td>
                                        <td style="display: none;">{{ $description = "buy" }}</td>
                                        <td>
                                            <form action="{{ route('payment.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="text" placeholder="search" value="{{$text}}">
                                                    <input type="hidden" name="id_purchase" value="{{ $purchase->id }}">



                                                    <input type="hidden" name="reference" value="{{$reference}}">
                                                    <input type="hidden" name="description" value="{{$description}}">
                                                    <input type="submit" name="btn" class="btn btn-primary" value="{{$button}}">
                                                <input type="submit" name="btn" class="btn btn-primary" value="View">
                                            </form>

                                        </td>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $purchases->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
