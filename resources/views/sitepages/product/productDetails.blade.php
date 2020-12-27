@extends('sitepages.layout.master')
@section('title')
<title>{{$product->name}}</title>
@endsection
@section('main')
<main id="maincontent" class="page-main">
    <div class="container">
        <div class="row">
            <div class="col-xs-9">
                <ol class="breadcrumb">
                    <li><a href="/" target="_self">Trang chủ</a></li>
                    <li><span>/</span></li>
                    <li class="active"><span>{{$category->name}}</span></li>
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
                            <li class="">
                                <a href="{{route('product.products', ['all'])}}" title="Tất cả sản phẩm" target="_self">Tất cả sản phẩm</a>
                            </li>
                            @foreach ($categories as $_category)
                            <li class="{{$category->id == $_category->id ? 'active' : ""}}">
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
                                    name="filter-price" value="{{$price_range['min']."-".$price_range['max']}}" disabled>
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
            <div class="col-md-9 product-detail">
                <div class="row product-info">
                    <div class="col-md-6">
                        <img data-zoom-image="{{asset("images/$product->featured_image")}}" class="img-responsive thumbnail main-image-thumbnail" src="{{asset("images/$product->featured_image")}}" alt="">
                        <div class="product-detail-carousel-slider">
                            <div class="owl-carousel owl-theme">
                                <div class="item thumbnail"><img src="{{asset('images/kemLamSangVungDaBikini.jpg')}}" alt=""></div>
                                <div class="item thumbnail"><img src="{{asset('images/beaumoreContourEyeCream.jpg')}}" alt=""></div>
                                <div class="item thumbnail"><img src="{{asset('images/kemChongNangBeaumore4in1.jpg')}}" alt=""></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="product-name">{{$product->name}}</h5>
                        <div class="brand">
                            <span>Nhãn hàng: </span> <span>{{$brand->name}}</span> 
                        </div>
                        <div class="product-status"> 
                            <span>Trạng thái: </span>
                            <span class="label-warning">{{$product->inventory_qty ? 'Còn hàng' : 'Hết hàng'}}</span>
                        </div>
                        <div class="product-item-price">
                            <span>Giá: </span>
                            @if ($product->discount_percentage != '0')
                            <span class="product-item-regular">{{number_format($product->price) . "₫"}}</span>
                            @endif        
                            <span class="product-item-discount">
                                {{-- Cải tiến cập nhật giá sale theo ngày giờ chỉ định --}}
                                {{number_format($product->price * (1 - $product->discount_percentage / 100)) . "₫"}}
                            </span>         
                        </div>
                    </div>
                </div>
                <div class="row product-description">
                    <div class="col-xs-12">
                        <div role="tabpanel">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="{{!$description ? "active" : ""}}">
                                    <a href="#product-description" aria-controls="home" role="tab" data-toggle="tab">Mô tả</a>
                                </li>
                                <li role="presentation" class="{{$description ? "active" : ""}}">
                                    <a href="#product-comment" aria-controls="tab" role="tab" data-toggle="tab">Đánh giá</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane {{!$description ? "active" : ""}}" id="product-description">   
                                {!!$product->description!!}
                                </div>
                                <div role="tabpanel" class="tab-pane {{$description ? "active" : ""}}" id="product-comment">
                                    <form class="form-comment" action="{{route('product.comment')}}" method="POST" role="form">
                                        @csrf
                                        <label>Đánh giá của bạn</label>
                                        <div class="form-group">
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <input class="rating-input" name="star" type="text" title="" value="5"/>
                                            <br>
                                            <input type="text" class="form-control" id="" name="fullname" placeholder="Tên *" required>
                                            <input type="email" name="email" class="form-control" id="" placeholder="Email *" required>
                                            <textarea name="description" id="input" class="form-control" rows="3" required placeholder="Nội dung *"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Gửi</button>
                                    </form>
                                    <div class="comment-list">
                                        @if (isset($comments) && count($comments))
                                            @foreach ($comments as $comment)
                                            <hr>
                                            <span class="date pull-right">{{$comment->created_date}}</span>
                                            <input class="answered-rating-input" name="rating" type="text" title="" value="{{$comment->star}}" readonly="readonly" />
                                            <br>
                                            <span class="by">{{$comment->fullname}}</span>
                                            <p>{{$comment->description}}</p>
                                            @endforeach
                                            @if ($still)
                                            <div id="more">
                                                <button id="more-comment">Xem thêm</button>
                                            </div>
                                            @endif
                                        @else   
                                            <br>
                                            <div id="more">
                                                <p>Chưa có bình luận nào</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row product-related equal">
                    <div class="col-md-12">
                        <h4 class="text-center">Sản phẩm liên quan</h4>
                        <div class="owl-carousel owl-theme">
                            @foreach ($related_products as $product)
                            <div class="item thumbnail">
                                @include('sitepages.layout.product')
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

