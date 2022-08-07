@extends('front.layouts.app')
@section('content')
<div class="row">
    @foreach($products as $product)
        <div class="col-xs-18 col-sm-6 col-md-3">



            <div class="card mr-3" style="width: 18rem;">
                <img class="card-img-top" src="{{ $product->image }}" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title">{{ $product->category_name }}</h5>
                  <p class="card-text">{{ $product->category_slug }}</p>
                  <p class="btn-holder"><a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-warning btn-block text-center" role="button">View Poducts</a> </p>
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
