@extends('sitepages.layout.master')
@section('title')
<title>Sản phẩm - Mỹ Phẩm Goda</title>
@endsection

@section('main')
<input type="hidden" id="sortSelected" value="{{$sortSelected}}">
<input type="hidden" id="PriceRange" value="{{$price_range}}">
<main id="maincontent" class="page-main">
    <div class="container">
        <div class="row">
            <div class="col-xs-9">
                <ol class="breadcrumb">
                    <li><a href="/" target="_self">Trang chủ</a></li>
                    <li><span>/</span></li>
                    <li class="active"><span>Tất cả sản phẩm</span></li>
                </ol>
            </div>
            <div class="col-xs-3 hidden-lg hidden-md">
                <a class="hidden-lg pull-right btn-aside-mobile" href="javascript:void(0)">Bộ lọc <i class="fa fa-angle-double-right"></i></a>
            </div>
            <div class="clearfix"></div>
            <aside class="col-md-3">
                <div class="inner-aside">
                    <div class="category">
                        <h5>Danh mục sản phẩm</h5>
                        <ul>
                            <li class="{{$category ? '' : 'active'}}">
                                <a href="{{route('product.products', ['all'])}}" title="Tất cả sản phẩm" target="_self">Tất cả sản phẩm</a>
                            </li>
                            @foreach ($categories as $_category)
                            <li class="{{$category && $category->id == $_category->id ? 'active' : ''}}">
                                <a href="{{route('product.products', [$_category->id])}}" title="{{$_category->name}}" 
                                target="_self">{{$_category->name}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="price-range">
                        <h5>Khoảng giá</h5>
                        <ul>
                            @foreach ($price_ranges as $index => $price_range) 
                                <li >
                                    <label for="filter-{{$price_range['min']."-".$price_range['max']}}">
                                    <input  type="radio" id="filter-{{$price_range['min']."-".$price_range['max']}}" 
                                    name="filter-price" value="{{$price_range['min']."-".$price_range['max']}}">
                                    <i class="fa"></i>
                                @if ($index == 0) 
                                        Giá dưới {{number_format($price_range['max'])}}đ
                                    </label>
                                </li>
                                    @continue
                                @endif
                                @if ($index == count($price_ranges) - 1) 
                                        Giá trên {{number_format($price_range['min'])}}đ
                                    </label>
                                </li>
                                    @continue
                                @endif
                                    {{number_format($price_range['min'])}}đ - {{number_format($price_range['max'])}}đ
                            @endforeach
                        </ul>
                    </div>
                </div>
            </aside>
            <div class="col-md-9 products">
                <div class="row equal">
                    <div class="col-xs-6">
                        <h4 class="home-title">{{$category ? $category->name : "Tất cả sản phẩm"}}</h4>
                    </div>
                    <div class="col-xs-6 sort-by">
                        <div class="pull-right">
                            <label class="left hidden-xs" for="sort-select">Sắp xếp: </label>
                            <select id="sort-select">
                                <option value="default-default" selected >Mặc định</option>
                                <option  value="price-asc">Giá tăng dần</option>
                                <option  value="price-desc">Giá giảm dần</option>
                                <option  value="name-asc">Từ A-Z</option>
                                <option  value="name-desc">Từ Z-A</option>
                                <option  value="created_date-asc">Cũ đến mới</option>
                                <option  value="created_date-desc">Mới đến cũ</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    @foreach ($products as $product)
                    <div class="col-xs-6 col-sm-4">
                        @include('sitepages.layout.product')
                    </div>
                    @endforeach
                </div>
                <!-- Paging -->
                {!! $products   ->links() !!}
                <!-- End paging -->
            </div>
        </div>
    </div>
</main>
@endsection