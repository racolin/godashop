@extends('sitepages.layout.master')
@section('title')
<title>Đơn hàng của tôi - Mỹ Phẩm Goda</title>
@endsection

@section('main')
<main id="maincontent" class="page-main">
    <div class="container">
        <div class="row">
            <div class="col-xs-9">
                <ol class="breadcrumb">
                    <li><a href="/" target="_self">Trang chủ</a></li>
                    <li><span>/</span></li>
                    <li class="active"><span>Tài khoản</span></li>
                </ol>
            </div>
            <div class="clearfix"></div>
            <aside class="col-md-3">
                <div class="inner-aside">
                    <div class="category">
                        <ul>
                            <li >
                                <a href="{{route('account.info')}}" title="Thông tin tài khoản" target="_self">Thông tin tài khoản
                                </a>
                            </li>
                            <li>
                                <a href="{{route('account.addressDefault')}}" title="Địa chỉ giao hàng mặc định" target="_self">Địa chỉ giao hàng mặc định
                                </a>
                            </li>
                            <li class="active">
                                <a href="{{route('order.order')}}" target="_self">Đơn hàng của tôi
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </aside>
            <div class="col-md-9 order">
                <div class="row">
                    <div class="col-xs-6">
                        <h4 class="home-title">Đơn hàng của tôi</h4>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <!-- Mỗi đơn hàng -->
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Đơn hàng <a href="{{route('account.orderDetails')}}">#2</a></h5>
                                <span class="date">
                                    Đặt hàng ngày 02 tháng 12 năm 2019 11:12:48                                
                                </span>
                                <hr>
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="{{asset('images/suaTamSandrasMychai250ml.jpg')}}" alt="" class="img-responsive">
                                    </div>
                                    <div class="col-md-3">
                                        <a class="product-name" href="chi-tiet-san-pham.html">Sữa tắm Sandras Mỹ chai 250ml</a>
                                    </div>
                                    <div class="col-md-2">
                                        Số lượng: 2                                    
                                    </div>
                                    <div class="col-md-2">
                                        Đã giao hàng                                    
                                    </div>
                                    <div class="col-md-3">
                                        Giao hàng ngày 05 tháng 12 năm 2019                                                                             
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
        