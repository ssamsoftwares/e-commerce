@extends('layouts.main')

@push('page-title')
    <title>All Brand</title>
@endpush

@push('heading')
    {{ 'Brand' }}
@endpush

@section('content')
    @push('style')
    @endpush

    <x-status-message />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="float-right">
                    <x-search.table-search action="{{ route('brands') }}" method="get" name="search"
                        value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}" btnClass="search_btn"/>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ 'Logo' }}</th>
                                <th>{{ 'Brand' }}</th>
                                <th>{{ 'Slug' }}</th>
                                <th>{{ 'Status' }}</th>
                                <th>{{ 'Action' }}</th>
                            </tr>
                        </thead>

                        <tbody id="CategoryData">
                            @foreach ($brands as $b)
                            <tr>
                                <td>
                                    @if (!empty($b->image))
                                    <img src="{{asset($b->image)}}" alt="Post" width="85">
                                    @else
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU" alt="Post" width="85">
                                    @endif
                                </td>
        
                                <td>{{$b->brand}}</td>
                                <td>{{$b->slug}}</td>
                                <td>
                                    @if ($b->status == 'active')
                                    <span class="badge badge-info text-info">Active</span>  
                                    @else
                                    <span class="badge badge-dark text-dark">Inactive</span>
                                    @endif
                                    </td>
                                <td>
                                    <a href="{{ route('brand.edit',['brand'=> $b->id ]) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="{{ route('brand.destroy',['brand'=> $b->id ]) }}" onclick="return confirm('Are you sure delete this brand')" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $brands->onEachSide(5)->links() }}
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@push('script')

@endpush
