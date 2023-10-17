@extends('layouts.main')

@push('page-title')
<title>{{ __('Add New Post')}}</title>
@endpush

@push('heading')
{{ __('Add New Post') }}
@endpush

@section('content')

<x-status-message/>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{route('post.store')}}" enctype="multipart/form-data">
                    @csrf
                    <h4 class="card-title mb-3">{{__('Post Details')}}</h4>      
                    
                    <div class="row">
                        <div class="col-lg-12">
                           <x-form.input name="title" label="Title"/>
                        </div>
                        {{-- <div class="col-lg-6">
                            <x-form.input name="slug" label="Slug"/>
                        </div> --}}
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                           <x-form.textarea name="description" label="Description"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <x-form.input name="image" label="Image" type="file"/>
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-primary" type="submit">{{__('Add Post')}}</button>
                    </div>
                </form>
           </div>
        </div>
    </div>
</div>

@endsection