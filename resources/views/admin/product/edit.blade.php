@extends('layouts.main')

@push('page-title')
    <title>{{ __('Edit Product') }}</title>
@endpush

@push('heading')
    {{ __('Edit Product -') }} {{ $product->product_name }}
@endpush

@section('content')
    <x-status-message />

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form method="post" action="{{ route('product.update', ['product' => $product->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <h4 class="card-title mb-3">{{ __('Product Details') }}</h4>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="">Category</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ $cat->id == $product->category_id ? 'selected' : '' }}>
                                                {{ $cat->category }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="">Sub Category</label>
                                    <select name="subcategory_id" id="subcategory_id" class="form-control">
                                        @foreach ($subcategories as $subcat)
                                            <option value="{{ $subcat->id }}"
                                                {{ $subcat->id == $product->subcategory_id ? 'selected' : '' }}>
                                                {{ $subcat->sub_category }}</option>
                                        @endforeach
                                    </select>
                                    @error('subcategory_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="">Brand</label>
                                    <select name="brand_id" id="brand_id" class="form-control">
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
                                                {{ $brand->brand }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="product_name" label="Product Name" :value="$product->product_name" />
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="slug" label="Slug" :value="$product->slug" />
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="sku" label="SKU" :value="$product->sku" />
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="quantity" label="Quantity" type="number" :value="$product->quantity" />
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="price" label="Price" type="number" :value="$product->price" />
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="offer_price" label="Offer Price" type="number" :value="$product->offer_price" />
                            </div>

                            <div class="col-lg-6">
                                <x-form.select name="product_status" label="Status" :options="[
                                    'active' => 'Active',
                                    'inactive' => 'Inactive',
                                ]" :selected="$product->status" />
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <x-form.input name="image[]" label="Image" type="file" multiple />
                                @php
                                    $productImg = json_decode($product->image);
                                @endphp
                                @foreach ($productImg as $key => $val)
                                    <div id="img{{ $key }}" style="display: inline-flex;">
                                        <img src="{{ asset($val) }}" alt="{{ $val }}" width="50"
                                            height="50">
                                        <a href="javascript:void(0)" class="text-danger imgRemove"
                                            data-key="{{ $key }}" data-id="{{ $product->id }}"
                                            data-name="{{ $val }}"><i class="fa fa-times"></i></a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-form.textarea name="short_description" label="Short Description" :value="$product->short_description" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-form.textarea name="description" label="Description" :value="$product->description" />
                            </div>
                        </div>


                        <div>
                            <button class="btn btn-primary" type="submit">{{ __('Update Product') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        $(document).ready(function() {
            // alert("hii");
            $('.imgRemove').on('click', function() {
                let cmr = confirm('Are you sure delete this image.');
                if (cmr) {
                    let id = $(this).data('id')
                    let imagename = $(this).data('name')
                    let key = $(this).data('key')
                    $.ajax({
                        type: "post",
                        url: "{{route('product.updateTimeDeleteImg')}}",
                        data: {
                            'id': id,
                            'imagename': imagename
                        },
                        headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        success: function(response) {
                            if (response.msg === 'success') {
                                console.log(`#img${key}`)
                                $(`#img${key}`).remove();
                            }
                        }
                    });
                }
            })
        });
    </script>
@endpush
