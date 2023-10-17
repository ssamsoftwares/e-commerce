<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!-- User details -->
        <div class="user-profile text-center mt-3">
            {{-- <div class="">
                <img src="assets/images/users/avatar-1.jpg" alt="" class="avatar-md rounded-circle">
            </div> --}}
            <div class="mt-3">
                <h4 class="font-size-16 mb-1">Hello {{ ucfirst(request()->user()->name) }}</h4>
                <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i> {{ ucfirst(request()->user()->role) }}</span>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                {{-- details --}}
                {{-- <li class="menu-title">Details</li> --}}
                <li>
                    <a href="{{route('dashboard')}}" class="waves-effect">
                        {{-- <i class="ri-dashboard-line"></i> --}}
                        <i class="ri-vip-crown-2-line"></i>
                        {{-- <span class="badge rounded-pill bg-success float-end">3</span> --}}
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Category --}}
                <li class="menu-title">Categories</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Category</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('category')}}">View All</a></li>
                        <li><a href="{{route('category.add')}}">Add New</a></li>
                    </ul>
                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Sub Category</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('subCategory')}}">View All</a></li>
                        <li><a href="{{route('subCategory.add')}}">Add New</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Brand</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('brands')}}">View All</a></li>
                        <li><a href="{{route('brand.add')}}">Add New</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Product</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('products')}}">View All</a></li>
                        <li><a href="{{route('product.add')}}">Add New</a></li>
                    </ul>
                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Page</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('pages')}}">View All</a></li>
                        <li><a href="{{route('page.add')}}">Add New</a></li>
                    </ul>
                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Post</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('posts')}}">View All</a></li>
                        <li><a href="{{route('post.add')}}">Add New</a></li>
                    </ul>
                </li>


            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
