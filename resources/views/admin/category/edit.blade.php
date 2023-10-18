@extends('layouts.main')

@push('page-title')
<title>{{ __('Edit Category')}}</title>
@endpush

@push('heading')
{{ 'Edit Category' }} : {{$category->category}}
@endpush

@section('content')

<x-status-message/>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <form method="post" action="{{ route('category.update',['category'=>$category->id]) }}" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="" value="{{$category->id}}">
                    @csrf
                    <h4 class="card-title mb-3">{{__('Category Details')}}</h4>

                    <div class="row">
                        <div class="col-lg-6">
                           <x-form.input name="category" label="Category" :value="$category->category"/>
                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="slug" label="Slug" :value="$category->slug"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <x-form.radio label="Status" name="status" id="" :value="$category->status" />
                        </div>

                        <div class="col-lg-4">
                            <x-form.input name="image" label="Image" type="file"/>
                        </div>
                        <div class="col-lg-2 mt-lg-4">
                            @if (! @empty($category->image))
                            <img src="{{asset($category->image)}}" alt="Category" width="85">
                            @else
                            <strong class="text-primary">No File</strong>
                            @endif
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-primary" type="submit">{{__('Update Category')}}</button>
                    </div>
                </form>
           </div>
        </div>
    </div>
</div>

@endsection
