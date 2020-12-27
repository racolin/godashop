@extends('sitepages.layout.master')
@section('title')
<title>Đơn hàng #1 - Mỹ Phẩm Goda</title>
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
                                <a href="route('account.addressDefault')" title="Địa chỉ giao hàng mặc định" target="_self">Địa chỉ giao hàng mặc định
                                </a>
                            </li>
                            <li class="active">
                                <a href="route('order.order')" target="_self">Đơn hàng của tôi
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </aside>
            <div class="col-md-9 order-info">
                <div class="row">
                    <div class="col-xs-6">
                        <h4 class="home-title">Đơn hàng #2</h4>
                    </div>
                    <div class="clearfix"></div>
                    <aside class="col-md-7 cart-checkout">
                        
                        <div class="row">
                            <div class="col-xs-2">
                                <img class="img-responsive" src="{{asset('images/suaTamSandrasMychai250ml.jpg')}}" alt="Sữa tắm Sandras Mỹ chai 250ml"> 
                            </div>
                            <div class="col-xs-7">
                                <a class="product-name" href="chi-tiet-san-pham.html">Sữa tắm Sandras Mỹ chai 250ml</a>
                                <br>
                                <span>2</span> x <span>210,000₫</span>
                            </div>
                            <div class="col-xs-3 text-right">
                                <span>420,000₫</span>
                            </div>
                        </div>
                        <hr>
                        
                        <div class="row">
                            <div class="col-xs-6">
                                Phí vận chuyển
                            </div>
                            <div class="col-xs-6 text-right">
                                50,000₫
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-6">
                                Tổng cộng
                            </div>
                            <div class="col-xs-6 text-right">
                                1,377,000₫
                            </div>
                        </div>
                    </aside>
                    <div class="ship-checkout col-md-5">
                        <h4>Thông tin giao hàng</h4>
                        <div>
                            Họ và tên: Trần Thị Vy Trang                            
                        </div>
                        <div>
                            Số điện thoại: 0942514622                            
                        </div>
                        <div>
                            Thành phố Hồ Chí Minh                            
                        </div>
                        <div>
                            Quận Tân Phú                            
                        </div>
                        <div>
                            Phường Hiệp Tân                            
                        </div>
                        <div>
                            278 Hòa Bình                            
                        </div>
                        <div>
                            Phương thức thanh toán: COD                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection