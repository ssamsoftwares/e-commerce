@extends('layouts.main')

@push('page-title')
<title>{{ __('Edit Page')}}</title>
@endpush

@push('heading')
{{ 'Edit Page' }} : {{$page->title}}
@endpush

@section('content')

<x-status-message/>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <form method="post" action="{{ route('page.update',['page'=>$page->id]) }}" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="" value="{{$page->id}}">
                    @csrf
                    <h4 class="card-title mb-3">{{__('Page Details')}}</h4>      
                    
                    <div class="row">
                        <div class="col-lg-6">
                           <x-form.input name="title" label="title" :value="$page->title"/>
                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="slug" label="Slug" :value="$page->slug"/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <x-form.textarea name="body" label="Body" :value="$page->body"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Status</label>
                            <input type="text" name="status" value="{{$page->status}}" class="form-control">
                            @error('status')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            <x-form.input name="image" label="Image" type="file"/>
                        </div>
                        <div class="col-lg-2 mt-lg-4">
                            @if (! @empty($page->image))
                            <img src="{{asset($page->image)}}" alt="Category" width="85">
                            @else
                            <strong class="text-primary">No File</strong>
                            @endif
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-primary" type="submit">{{__('update Page')}}</button>
                    </div>
                </form>
           </div>
        </div>
    </div>
</div>

@endsection