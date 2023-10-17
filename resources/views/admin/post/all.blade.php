@extends('layouts.main')

@push('page-title')
    <title>All Post</title>
@endpush

@push('heading')
    {{ 'Post' }}
@endpush

@section('content')
    @push('style')
    @endpush

    <x-status-message />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="float-right">
                    <x-search.table-search action="{{ route('posts') }}" method="get" name="search"
                        value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}" btnClass="search_btn"/>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ 'Image' }}</th>
                                <th>{{ 'Title' }}</th>
                                <th>{{ 'Slug' }}</th>
                                <th>{{ 'Status' }}</th>
                                <th>{{ 'Action' }}</th>
                            </tr>
                        </thead>

                        <tbody id="CategoryData">
                            @foreach ($posts as $post)
                            <tr>
                                <td>
                                    @if (!empty($post->image))
                                    <img src="{{asset($post->image)}}" alt="Post" width="85">
                                    @else
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU" alt="Post" width="85">
                                    @endif
                                </td>
        
                                <td>{{$post->title}}</td>
                                <td>{{$post->slug}}</td>
                                <td>
                                    @if ($post->status == "active")
                                    <span class="badge badge-info text-info">Active</span>  
                                    @else
                                    <span class="badge badge-dark text-dark">Inactive</span>
                                    @endif
                                    </td>
                                <td>
                                    <div class="action-btns text-center" role="group">

                                        <a href="{{ route('post.view', ['post'=>$post->id]) }}"
                                            class="btn btn-primary waves-effect waves-light view">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <a href="{{ route('post.edit',['post'=> $post->id ]) }}"
                                            class="btn btn-info waves-effect waves-light edit">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                        <a href="{{ route('post.destroy',['post'=> $post->id ]) }}"
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
                    {{ $posts->onEachSide(5)->links() }}
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@push('script')

@endpush
