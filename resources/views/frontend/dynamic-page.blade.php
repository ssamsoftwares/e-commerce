{{-- @extends('layouts.main')
@section('content') --}}
<div class="container">
<div class="card  mb-xl-4">
    <div class="card-header">
        <h3 class="text-center">Dynamic page </h3>
    </div>
    <div class="card-body">
        <h4><b>Title :</b>{!! $page ? $page->title : 'Not Found Title' !!}</h4>

        {{-- <p><b>description :</b>
            <span>{!! $page ? $page->description : 'Not Found description' !!}</span>
        </p> --}}
        
        <p><b>body :</b> <br>
            <strong class="text-secondary">{!! $page ? $page->body : 'Not Found Body' !!}</strong>
        </p>
       
    </div>
</div>

</div>

{{-- @endsection --}}