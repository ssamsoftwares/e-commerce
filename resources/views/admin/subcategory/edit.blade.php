@extends('layouts.main')

@push('page-title')
<title>{{ __('Edit Sub Category')}}</title>
@endpush

@push('heading')
{{ __('Edit Sub Category') }}
@endpush

@section('content')

<x-status-message/>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{route('subCategory.update',['subcategory'=>$subcategory->id])}}" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{$subcategory->id}}">
                    @csrf
                    <h4 class="card-title mb-3">{{__('Sub Category Details')}}</h4>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <x-form.select label="Category" name="category_id" id="category_id" chooseFileComment="--Select Category--" :options="$categories" :selected="$subcategory->category_id" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <x-form.input name="sub_category" label="Sub Category" :value="$subcategory->sub_category"/>
                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="slug" label="Slug" :value="$subcategory->slug"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                           <x-form.radio label="Status" name="status" :value="$subcategory->status" />
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-primary mt-4" type="submit">{{__('Update SubCategory')}}</button>
                    </div>
                </form>
           </div>
        </div>
    </div>
</div>

@endsection
