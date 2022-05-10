@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <div class="col">
                    <p><small><a href="{{ url()->previous() }}">Back</a></small></p>
                </div>
            </div>
        </div>
        <form action="{{ route('cart.index') }}" method="get">
            @php($count = Cart::count())
            <button type="submit" class="btn btn-primary">
                Cart <span class="badge badge-light">
                    {{$count}}
                </span>
            </button>
        </form>
        <form action="{{ route('welcome') }}" method="get">

            <button type="submit" class="btn btn-primary">
                Shopping
            </button>
        </form>
        <div class="row">
            <div class="col">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-6">
                            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner main-carousel">

                                    <div >
                                        <img src="{{$product[0]['photo']}}" class="card-img-top" alt="...">
                                    </div>

                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                                        data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                                        data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <h5 class="card-title">$ {{ $product[0]['price'] }}</h5>
                                <h5 class="card-title"> {{ $product[0]['name'] }}</h5>
                                <p class="card-text">{{ $product[0]['description'] }}</p>
                                <p class="card-text"><small class="text-muted">Available stock: {{ $product[0]['stock_number'] }}</small></p>
                                <div class="card-text mb-2">

                                    <form id="add-cart{{ $product[0]['id'] }}" action="{{ route('cart.addToCart') }}" method="get">
                                        <input type="hidden" name="productId" value="{{ $product[0]['id'] }}">
                                        <div class="input-group mb-3">
                                            <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{$product[0]['stock_number']}}">
                                            <button type="submit" class="btn btn-outline-dark">
                                                <em class="fas fa-cart-plus" ></em> Add to Cart
                                            </button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    import AddToCardt from "../../js/components/AddToCart";
    import AddToCard from "../../js/components/AddToCart";
    export default {
        components: {AddToCard, AddToCardt}
    }
</script>
