@extends('layouts.main')
@push('page-title')
<title>{{ "Post - ". $post['title'] }}</title>
@endpush

@push('heading')
{{ 'Post Detail' }}
@endpush

@push('heading-right')

@endpush

@section('content')

{{-- investor details --}}
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <h5 class="card-header">{{ 'Post Details' }}</h5>
            <div class="card-body">
                
                <h5 class="card-title">
                    <span>Title :</span> 
                    <span>
                        {{ $post['title'] }} 
                    </span>
                </h5>
                <hr>
                <h5 class="card-title">
                    <span>Slug : </span>
                    <span>{{ $post['slug'] }}</span>
                </h5>
                <hr/>
                <h5 class="card-title">
                    <span>Image : </span>
                    @if (!empty($post->image))
                                    <img src="{{asset($post->image)}}" alt="Post" width="85">
                                    @else
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU" alt="Post" width="85">
                                    @endif
                </h5>
                <hr/>

                <h5 class="card-title">
                    <span>Created By : </span>
                    <span>{{ \Carbon\Carbon::parse($post->created_at)->format('d-M-Y') }}</span>

                </h5>
                <hr/>
            </div>
        </div>
    </div>


    <div class="col-lg-6">
        <div class="card">
            <h5 class="card-header">{{ 'Post Description' }}</h5>
            <div class="card-body">

                <h5 class="card-title">
                    <span>Description : </span><br>
                    <span>{{ $post->description }}</span>
                </h5>
                <hr>
            </div>
        </div>
    </div>

</div>

@endsection