@extends('layouts.main')

@push('page-title')
<title>{{ __('Add New Sub Category')}}</title>
@endpush

@push('heading')
{{ __('Add New Sub Category') }}
@endpush

@section('content')

<x-status-message/>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                
                <form method="post" action="{{route('subCategory.store')}}" enctype="multipart/form-data">
                    @csrf
                    <h4 class="card-title mb-3">{{__('Sub Category Details')}}</h4>      
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="">Category</label>
                               <select name="category_id" id="category_id" class="form-control">
                                @foreach ($categories as $cat)
                                <option value="{{$cat->id}}">{{$cat->category}}</option>
                                @endforeach
                               </select>
                               @error('category_id')
                                   <span class="text-danger">{{$message}}</span>
                               @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <x-form.input name="sub_category" label="Sub Category"/>
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-primary" type="submit">{{__('Add Sub Category')}}</button>
                    </div>
                </form>
           </div>
        </div>
    </div>
</div>

@endsection