@extends('layouts.main')

@push('page-title')
    <title>{{ __('Add New Product') }}</title>
@endpush

@push('heading')
    {{ __('Add New Product') }}
@endpush

@section('content')
    <x-status-message />

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                        @csrf
                        <h4 class="card-title mb-3">{{ __('Product Details') }}</h4>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <x-form.select label="Category" chooseFileComment="--Select Category--"
                                    name="category_id" id="category_id" :options="$categories" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <x-form.select label="Sub Category" chooseFileComment="--Select Sub Category--"
                                    name="subcategory_id" id="subcategory_id" :options="$categories" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <x-form.select label="Brand" chooseFileComment="--Select Brand--"
                                    name="brand_id" id="brand_id" :options="$brands" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="product_name" label="Product Name" />
                            </div>
                        </div>


                        <div class="row">
                            {{-- <div class="col-lg-6">
                            <x-form.input name="slug" label="Slug"/>
                        </div> --}}

                            <div class="col-lg-6">
                                <x-form.input name="sku" label="SKU" />
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="quantity" label="Quantity" type="number" />
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="price" label="Price" type="number" />
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="offer_price" label="Offer Price" type="number" />
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <x-form.input name="image[]" label="Image" type="file" multiple />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-form.textarea name="short_description" label="Short Description" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-form.textarea name="description" label="Description" />
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary" type="submit">{{ __('Add Product') }}</button>
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
