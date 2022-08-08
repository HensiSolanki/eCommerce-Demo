@extends('front.layouts.app')
@section('content')
<div class="row">
    @foreach($products as $product)
        <div class="col-xs-18 col-sm-6 col-md-3">
            <div class="card mr-3" style="width: 18rem;">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                @foreach (json_decode($product->image) as $image)

                      <div class="carousel-item active">
                        <img id="Pro-Image" class="card-img-top" src="/products/{{ $image }}" alt="Card image cap" width="100" height="250">
                      </div>
                      @endforeach
                    </div>
                </div>
                {{-- <img class="card-img-top" src="{{ $product->image_thumb_url }}" alt="Card image cap"> --}}
                <div class="card-body">
                  <h5 class="card-title">{{ $product->product_name }}</h5>
                  <p class="card-text">{{ $product->description }}</p>
                  <p><strong>Price: </strong> {{ $product->price }}$</p>
                  <p class="btn-holder"><a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a> </p>
                </div>
              </div>
            {{-- <div class="thumbnail">
                <img src="{{ $product->image }}" alt="">
                <div class="caption">
                    <h4>{{ $product->name }}</h4>
                    <p>{{ $product->description }}</p>
                    <p><strong>Price: </strong> {{ $product->price }}$</p>
                    <p class="btn-holder"><a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a> </p>
                </div>
            </div> --}}
        </div>
    @endforeach
</div>


@endsection
