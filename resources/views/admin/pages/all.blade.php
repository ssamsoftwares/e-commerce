@extends('layouts.main')

@push('page-title')
    <title>All Pages</title>
@endpush

@push('heading')
    {{ 'Pages' }}
@endpush

@section('content')
    @push('style')
    @endpush

    <x-status-message />

    <div class="row">
        <div class="col-12">
            <div class="card">
                {{-- <div class="float-right">
                    <x-search.table-search action="{{ route('pages') }}" method="get" name="search"
                        value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}" btnClass="search_btn"/>
                </div> --}}
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="text-center">
                            <tr>
                                <th>{{ 'Image' }}</th>
                                <th>{{ 'Title' }}</th>
                                <th>{{ 'Slug' }}</th>
                                <th>{{ 'Status' }}</th>
                                {{-- <th>{{ 'Page' }}</th> --}}
                                <th>{{ 'Action' }}</th>
                            </tr>
                        </thead>

                        <tbody id="CategoryData" class="text-center">
                            @foreach ($pages as $page)
                            <tr>
                                <td>
                                    @if (!empty($page->image))
                                    <img src="{{asset($page->image)}}" alt="Post" width="85">
                                    @else
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU" alt="Post" width="85">
                                    @endif
                                </td>

                                <td>{{$page->title}}</td>
                                <td>{{$page->slug}}</td>
                                <td>
                                    @if ($page->status == "active")
                                    <span class="badge badge-info text-info">Active</span>
                                    @else
                                    <span class="badge badge-dark text-dark">Inactive</span>
                                    @endif
                                    </td>

                                    {{-- <td class="text-center">
                                        <a href="{{ route('pages.dynamicPage', ['slug'=>$page->slug]) }}"
                                            class="btn btn-primary waves-effect waves-light view">
                                            View page
                                        </a>
                                    </td> --}}

                                <td>

                                    <div class="action-btns text-center" role="group">

                                        <a href="{{ route('page.view', ['page'=>$page->id]) }}"
                                            class="btn btn-primary waves-effect waves-light view">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <a href="{{ route('page.edit',['page'=> $page->id ]) }}"
                                            class="btn btn-info waves-effect waves-light edit">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                        <a href="{{ route('page.destroy',['page'=> $page->id ]) }}"
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
                    {{ $pages->onEachSide(5)->links() }}
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@push('script')

@endpush
