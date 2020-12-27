@extends('sitepages.layout.master')
@section('title')
<title>Thanh toán - Mỹ Phẩm Goda</title>
@endsection

@section('main')
<main id="maincontent" class="page-main">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="/" target="_self">Giỏ hàng</a></li>
                    <li><span>/</span></li>
                    <li class="active">
                    @if (session()->has('products'))
                    <span>Đơn hàng gặp trục trặc</span></li> 
                    @else
                    <span>Hoàn thành đơn hàng</span></li> 
                    @endif
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 text-success">
                @if (session()->has('products'))
                Đơn hàng của bạn có vấn đề . Để  trở về, click vào <a href="{{route('home')}}">đây</a> 
                @else
                Bạn đã hoàn thành đơn hàng. Để tiếp tục mua sắm, click vào <a href="{{route('home')}}">đây</a> 
                @endif
            </div>
        </div>     
    </div>
</main>  
@endsection