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
                                    <th style="color:#fff;">Quantity</th>
                                    <th style="color:#fff;">Total</th>
                                    <th style="color:#fff;">Actions</th>
                                </thead>
                                <tbody>

                                    @foreach($products as $product)
                                        <tr>
                                            <td style="display: none;">{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td><input-total min="1" pamount="{{ request()->query('quantity') }}"></input-total></td>
                                            <td><label-total type="number" price="{{$product->price}}"></label-total></td>
                                            <td style="display: none;">{{$reference = ""}}</td>
                                            <td style="display: none;">{{ $description = "buy" }}</td>
                                            <td>
                                                <form id="pay-form{{$product->id}}" action="{{ route('payment.store') }}" method="POST">
                                                    @csrf

                                                    <div class="flex">
                                                        <input type="hidden" name="id_product" value="{{ $product->id }}" id="pay-form{{$product->id}}">
                                                        <input type="hidden" name="name" value="{{ $product->name }}" id="pay-form{{$product->id}}">
                                                        <input type="hidden" name="price" value="{{$product->price}}" id="pay-form{{$product->id}}">
                                                        <input-total min="1" pamount="{{ request()->query('quantity') }}" id="pay-form{{$product->id}}" style="display: none"></input-total>
                                                        <input type="hidden" name="reference" value="{{$reference}}" id="pay-form{{$product->id}}">
                                                        <input type="hidden" name="description" value="{{$description}}" id="pay-form{{$product->id}}">
                                                        <button type="submit" name="btn" class="btn btn-primary" form="pay-form{{$product->id}}">BUY</button>
                                                    </div>
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

<script>
    import InputTotal from "../../js/components/InputTotal";
    export default {
        components: {InputTotal}
    }
</script>
