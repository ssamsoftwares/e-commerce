@extends('layouts.main')
@push('page-title')
<title>{{ "Page - ". $page['title'] }}</title>
@endpush

@push('heading')
{{ 'Page Detail' }}
@endpush

@push('heading-right')

@endpush

@section('content')

{{-- investor details --}}
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <h5 class="card-header">{{ 'Page Details' }}</h5>
            <div class="card-body">
                
                <h5 class="card-title">
                    <span>Title :</span> 
                    <span>
                        {{ $page['title'] }} 
                    </span>
                </h5>
                <hr>
                <h5 class="card-title">
                    <span>Slug : </span>
                    <span>{{ $page['slug'] }}</span>
                </h5>
                <hr/>

                <h5 class="card-title">
                    <span>Image : </span>
                    @if (!empty($page['image']))
                                    <img src="{{asset($page['image'])}}" alt="Post" width="85">
                                    @else
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU" alt="Post" width="85">
                                    @endif
                </h5>
                <hr/>

                <h5 class="card-title">
                    <span>Created By : </span>
                    <span>{{ \Carbon\Carbon::parse($page->created_at)->format('d-M-Y') }}</span>

                </h5>
                <hr/>
            </div>
        </div>
    </div>


    <div class="col-lg-6">
        <div class="card">
            <h5 class="card-header">{{ 'Page Body' }}</h5>
            <div class="card-body">

                <h5 class="card-title">
                    <span>Body : </span><br>
                    <span>{{ $page['body'] }}</span>
                </h5>
                <hr>
            </div>
        </div>
    </div>

</div>

@endsection