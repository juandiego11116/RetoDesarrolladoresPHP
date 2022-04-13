@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <hr>

        <form action="{{ route('cart.index') }}" method="get">

            <button type="submit" class="btn btn-primary">
                 Cart
            </button>
        </form>
        @foreach ($products->chunk(4) as $chunk)
            <div class="row my-4">
                @foreach ($chunk as $product)
                    @if($product->visible == true)
                    <div class="col-3">

                        <div class="card">
                            <img src="{{$product->photo}}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">$ {{ $product->price }}</h6>
                                <p class="card-text">{{ Str::limit($product->description, 60) }}.</p>
                                <div class="btn-group btn-block w-100" role="group" aria-label="Basic example">
                                    <form id="add-cart-{{ $product->id }}" action="{{ route('cart.addToCart') }}" method="get">
                                        <input type="hidden" name="productId" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value=1>
                                        <button type="submit" class="btn btn-default" form="add-cart-{{ $product->id }}">
                                            <em class="fas fa-cart-plus"></em> Buy
                                        </button>
                                    </form>

                                   <a href="{{ route('purchases.show', ['productId' => $product->id]) }}" class="btn btn-default">
                                        <em class="fas fa-cart-plus"></em> View
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
