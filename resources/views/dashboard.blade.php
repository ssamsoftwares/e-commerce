@extends('layouts.main')

@push('page-title')
    <title>{{'Dashboard'}}</title>
@endpush

@push('heading')
    {{ 'Dashboard'}}
@endpush

@section('content')

{{-- quick info --}}
<div class="row">
    <x-design.card heading="Total Category" value="{{$total['category']}}" desc="Category"/>
    <x-design.card heading="Total SubCategory"  value="{{$total['subCategory']}}" desc="SubCategory"/>
    <x-design.card heading="Total Brand"  value="{{$total['brand']}}" color="primary" desc="Brand"/>
    <x-design.card heading="Total Product"  value="{{$total['product']}}" color="primary" desc="Product"/>
    <x-design.card heading="Total Post"  value="{{$total['page']}}" color="primary" desc="Post"/>
    <x-design.card heading="Total Page"  value="{{$total['post']}}" color="primary" desc="Page" icon="mdi-account-convert"/>
    {{-- <x-design.card heading="{{date('F')}} Payout"  value="99" color="danger" desc=""/> --}}
</div>

@endsection
