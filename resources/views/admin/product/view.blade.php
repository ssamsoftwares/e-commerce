@extends('layouts.main')
@push('page-title')
<title>{{ "Product - ". $product['product_name'] }}</title>
@endpush

@push('heading')
{{ 'Product Detail' }}
@endpush

@push('heading-right')

@endpush

@section('content')

{{-- Product details --}}
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <h5 class="card-header">{{ 'Page Details' }}</h5>
            <div class="card-body">

                <h5 class="card-title">
                    <span>Product :</span>
                    <span>
                        {{ $product['product_name'] }}
                    </span>
                </h5>
                <hr>
                <h5 class="card-title">
                    <span>Slug : </span>
                    <span>{{ $product['slug'] }}</span>
                </h5>
                <hr/>

                <h5 class="card-title">
                    <span>Category : </span>
                    <span>{{$product->category->category}}</span>

                </h5>
                <hr/>

                <h5 class="card-title">
                    <span>Sub Category : </span>
                    <span>{{ $product->subCategory ? $product->subCategory->sub_category : 'N/A' }}</span>

                    {{-- <span>{{$product->sub_category->sub_category}}</span> --}}

                </h5>
                <hr/>

                <h5 class="card-title">
                    <span>Brand : </span>
                    <span>{{$product->brand->brand}}</span>

                </h5>
                <hr/>


                <h5 class="card-title">
                    <span>SKU : </span>
                    <span>{{$product->sku}}</span>

                </h5>
                <hr/>


                <h5 class="card-title">
                    <span>Price : </span>
                    <span>{{$product->price}}</span>

                </h5>
                <hr/>

                <h5 class="card-title">
                    <span>Offer Price : </span>
                    <span>{{$product->offer_price}}</span>
                </h5>
                <hr/>


                <h5 class="card-title">
                    <span>Quantity : </span>
                    <span>{{$product->quantity}}</span>
                </h5>
                <hr/>

            </div>
        </div>
    </div>


    <div class="col-lg-6">
        <div class="card">
            <h5 class="card-header">{{ '' }}</h5>
            <div class="card-body">

                <h5 class="card-title">
                    <span>Short Description : </span><br>
                    <span>{{ $product['short_description'] }}</span>
                </h5>
                <hr>

                <h5 class="card-title">
                    <span>Description : </span><br>
                    <span>{{ $product['description'] }}</span>
                </h5>
                <hr>

                <h5 class="card-title">
                    <span>Image : </span>
                    @if ($product->image)
                    @php
                        $imagePaths = json_decode($product->image);
                    @endphp
                    @foreach ($imagePaths as $imagePath)
                        <img src="{{ asset($imagePath) }}" alt="Product Image" width="30">
                    @endforeach
                @else
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU" alt="product_image" width="85">
                @endif
                </h5>
                <hr/>

                <h5 class="card-title">
                    <span>Status : </span>
                    <span>{{$product->status}}</span>
                </h5>
                <hr/>

                <h5 class="card-title">
                    <span>Created By : </span>
                    <span>{{ \Carbon\Carbon::parse($product->created_at)->format('d-M-Y') }}</span>

                </h5>
                <hr/>
            </div>
        </div>
    </div>

</div>

@endsection
