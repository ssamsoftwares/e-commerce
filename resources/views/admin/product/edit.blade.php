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
                                    <x-form.select label="Category" name="category_id" id="category_id" chooseFileComment="--Select Category--" :options="$categories" :selected="$product->category_id" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <x-form.select label="Sub Category" chooseFileComment="--Select Sub Category--"
                                    name="subcategory_id" id="subcategory_id" :options="$subcategories" :selected="$product->subcategory_id"  />

                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <x-form.select label="Brand" chooseFileComment="--Select Brand--"
                                    name="brand_id" id="brand_id" :options="$brands" :selected="$product->brand_id" />

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
                                <x-form.radio label="Status" name="status" id="" :value="$product->status" />
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


{{-- Select Subcategory --}}
<script>
    $(document).ready(function() {
        var $categorySelect = $('#category_id');
        var $subcategorySelect = $('#subcategory_id');

        function subcategories(categoryId) {
            $.ajax({
                type: "post",
                url: '{{ route('product.getSubcategories') }}',
                data: {
                    category_id: categoryId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $subcategorySelect.empty();
                    $.each(data, function(id, subcategory) {
                        $subcategorySelect.append(new Option(subcategory, id));
                    });
                },
                error: function() {
                    alert('Error fetching subcategories.');
                }
            });
        }

        var initialCategoryId = $categorySelect.val();
        if (initialCategoryId) {
            subcategories(initialCategoryId);
        }

        // Handle category change event
        $categorySelect.on('change', function() {
            var categoryId = $(this).val();
            if (categoryId) {
                subcategories(categoryId);
            } else {
                $subcategorySelect.empty();
            }
        });
    });
</script>
@endpush
