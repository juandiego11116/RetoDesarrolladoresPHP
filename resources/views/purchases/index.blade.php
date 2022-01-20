@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Shopping</h3>
        </div>
        <div class="section-body">
            <div id="app" class="row">
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
                                            <form action="{{ route('purchases.create') }}" method="get">
                                                <td>
                                                    <input type="hidden" name="amount" value="{{"amount"}}">
                                                    <input type="number" name="amount" >
                                                </td>
                                                <td>
                                                    <input type="hidden" name="product" value="{{$product->id}}">
                                                    <input type="submit" name="btn" class="btn btn-info" value="ADD TO CARD">
                                                    <cart-button></cart-button>
                                                </td>
                                            </form>
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
<script>
    import CartButton from "../../components/CartButton";
    export default {
        components: {CartButton}
    }
</script>
