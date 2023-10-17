@extends('layouts.main')

@push('page-title')
    <title>All Category</title>
@endpush

@push('heading')
    {{ 'Category' }}
@endpush

@section('content')
    @push('style')
    @endpush

    <x-status-message />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="float-right">
                    <x-search.table-search action="{{ route('category') }}" method="get" name="search"
                        value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}" btnClass="search_btn"/>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ 'Image' }}</th>
                                <th>{{ 'Category' }}</th>
                                <th>{{ 'Slug' }}</th>
                                <th>{{ 'Status' }}</th>
                                <th>{{ 'Action' }}</th>
                            </tr>
                        </thead>

                        <tbody id="CategoryData">
                            @foreach ($category as $cat)
                            <tr>
                                <td>
                                    @if (!empty($cat->image))
                                    <img src="{{asset($cat->image)}}" alt="Post" width="85">
                                    @else
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU" alt="Post" width="85">
                                    @endif
                                </td>
        
                                <td>{{$cat->category}}</td>
                                <td>{{$cat->slug}}</td>
                                <td>
                                    @if ($cat->status == 'active')
                                    <span class="badge badge-info text-info">Active</span>  
                                    @else
                                    <span class="badge badge-dark text-dark">Inactive</span>
                                    @endif
                                    </td>
                                <td>
                                    <div class="action-btns text-center" role="group">
                                        <a href="{{ route('category.edit',['category'=> $cat->id ]) }}"
                                            class="btn btn-info waves-effect waves-light edit">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                        <a href="{{ route('category.destroy',['category'=> $cat->id ]) }}"
                                            class="btn btn-danger waves-effect waves-light del"
                                            onclick="return confirm('Are you sure delete this record!')">
                                            <i class="ri-delete-bin-line"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $category->onEachSide(5)->links() }}
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@push('script')

@endpush
