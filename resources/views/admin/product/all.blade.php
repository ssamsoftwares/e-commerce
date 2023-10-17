@extends('layouts.main')

@push('page-title')
    <title>All Product</title>
@endpush

@push('heading')
    {{ 'Product' }}
@endpush

@section('content')
    @push('style')

    @endpush

    <x-status-message />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="float-right">
                    <x-search.table-search action="{{ route('products') }}" method="get" name="search"
                        value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}" btnClass="search_btn" />
                </div>
                <div class="card-body">
                    <a href="javascript:void(0)" class="btn btn-danger m-2 deleteAll" id="deleteAll">Delete All</a>
                    <a href="javascript:void(0)" class="btn btn-primary m-2" id="selectAll">All Select </a>
                    <a href="javascript:void(0)" class="btn btn-info m-2" id="deselectAll">All Deselect</a>

                    <div class="table-responsive">


                    <table id="products" class="table table-striped table-bordered dt-responsive nowrap product"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th width="50px"><input type="checkbox" id="master"></th>
                                <th>{{ 'Image' }}</th>
                                <th>{{ 'Product' }}</th>
                                <th>{{ 'Slug' }}</th>
                                <th>{{ 'Status' }}</th>
                                <th>{{ 'Action' }}</th>
                            </tr>
                        </thead>

                        <tbody id="CategoryData">
                            @foreach ($products as $p)
                                <tr id="tr_{{ $p->id }}">
                                    <td><input type="checkbox" class="sub_chk" data-id="{{ $p->id }}"></td>
                                    <td>
                                        @if ($p->image)
                                            @php
                                                $imagePaths = json_decode($p->image);
                                            @endphp
                                            @foreach ($imagePaths as $imagePath)
                                                <img src="{{ asset($imagePath) }}" alt="Product Image" width="30">
                                            @endforeach
                                        @else
                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU"
                                                alt="product_image" width="85">
                                        @endif

                                    </td>
                                    <td>{{ $p->product_name }}</td>
                                    <td>{{ $p->slug }}</td>

                                    <td>
                                        @if ($p->status == 'active')
                                            <span class="badge badge-info text-info">Active</span>
                                        @else
                                            <span class="badge badge-dark text-dark">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-btns text-center" role="group">

                                            <a href="{{ route('product.view', ['product' => $p->id]) }}"
                                                class="btn btn-primary waves-effect waves-light view">
                                                <i class="ri-eye-line"></i>
                                            </a>

                                            <a href="{{ route('product.edit', ['product' => $p->id]) }}"
                                                class="btn btn-info waves-effect waves-light edit">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                            <a href="{{ route('product.destroy', ['product' => $p->id]) }}"
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
                    {{ $products->onEachSide(5)->links() }}
                </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@push('script')
    <script>
        $(document).ready(function() {

            // Multiple Rows Delete Function
            $('#master').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked', false);
                }
            });

            // Select All
            $('#selectAll').click(function() {
                $(".sub_chk").prop('checked', true);
                $('#master').prop('checked', true);
            });

            // Deselect All
            $('#deselectAll').click(function() {
                $(".sub_chk").prop('checked', false);
                $('#master').prop('checked', false);
            });



            $('.deleteAll').on('click', function(e) {
                var allVals = [];

                $(".sub_chk:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });

                if (allVals.length > 0) {
                    if (confirm('Are you sure? You won\'t be able to revert this!')) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('product.deleteAll') }}",
                            data: {
                                "ids": allVals
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                console.log(response);
                                alert('Deleted! Your data has been deleted.');
                                $('#products').DataTable().draw(false);
                                // $('#products').DataTable().ajax.reload();
                                $("#master").prop('checked', false);
                                table.draw();
                            },
                            error: function(data) {
                                alert('Error: ' + data.responseText);
                            }
                        });
                    }
                } else {
                    alert('Oops... Please select at least one record!');
                }
            });


        });
    </script>
@endpush
