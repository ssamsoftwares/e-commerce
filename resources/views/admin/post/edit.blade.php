@extends('layouts.main')

@push('page-title')
<title>{{ __('Edit Post')}}</title>
@endpush

@push('heading')
{{ 'Edit Post' }} : {{$post->title}}
@endpush

@section('content')

<x-status-message/>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <form method="post" action="{{ route('post.update',['post'=>$post->id]) }}" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="" value="{{$post->id}}">
                    @csrf
                    <h4 class="card-title mb-3">{{__('Post Details')}}</h4>      
                    
                    <div class="row">
                        <div class="col-lg-6">
                           <x-form.input name="title" label="title" :value="$post->title"/>
                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="slug" label="Slug" :value="$post->slug"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <x-form.textarea name="description" label="Description" :value="$post->description"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Status</label>
                            <input type="text" name="status" value="{{$post->status}}" class="form-control">
                            @error('status')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            <x-form.input name="image" label="Image" type="file"/>
                        </div>
                        <div class="col-lg-2 mt-lg-4">
                            @if (! @empty($post->image))
                            <img src="{{asset($post->image)}}" alt="Category" width="85">
                            @else
                            <strong class="text-primary">No File</strong>
                            @endif
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-primary" type="submit">{{__('update Post')}}</button>
                    </div>
                </form>
           </div>
        </div>
    </div>
</div>

@endsection