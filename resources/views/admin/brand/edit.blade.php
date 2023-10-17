@extends('layouts.main')

@push('page-title')
<title>{{ __('Edit Brand')}}</title>
@endpush

@push('heading')
{{ 'Edit Brand' }} : {{$brand->category}}
@endpush

@section('content')

<x-status-message/>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <form method="post" action="{{ route('brand.update') }}" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="" value="{{$brand->id}}">
                    @csrf
                    <h4 class="card-title mb-3">{{__('Brand Details')}}</h4>      
                    
                    <div class="row">
                        <div class="col-lg-6">
                           <x-form.input name="brand" label="Brand" :value="$brand->brand"/>
                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="slug" label="Slug" :value="$brand->slug"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            {{-- <x-form.input name="status" label="Status" type="text"/> --}}
                            <label for="">Status</label>
                            <input type="text" name="status" value="{{$brand->status}}" class="form-control">
                            @error('status')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            <x-form.input name="image" label="Image" type="file"/>
                        </div>
                        <div class="col-lg-2 mt-lg-4">
                            @if (! @empty($brand->image))
                            <img src="{{asset($brand->image)}}" alt="Category" width="85">
                            @else
                            <strong class="text-primary">No File</strong>
                            @endif
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-primary" type="submit">{{__('update Brand')}}</button>
                    </div>
                </form>
           </div>
        </div>
    </div>
</div>

@endsection