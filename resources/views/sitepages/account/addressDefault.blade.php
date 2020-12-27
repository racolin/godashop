@extends('sitepages.layout.master')
@section('title')
<title>Địa chỉ giao hàng mặc định - Mỹ Phẩm Goda</title>
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
                            <li class="active">
                                <a href="{{route('account.addressDefault')}}" title="Địa chỉ giao hàng mặc định" target="_self">Địa chỉ giao hàng mặc định
                                </a>
                            </li>
                            <li class="">
                                <a href="{{route('order.order')}}" target="_self">Đơn hàng của tôi
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </aside>
            <div class="col-md-9 account">
                <div class="row">
                    <div class="col-xs-6">
                        <h4 class="home-title">Địa chỉ giao hàng mặc định</h4>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <form action="{{route("account.updateAddress")}}" method="POST" role="form">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <input type="text" value="{{session('customer')->shipping_name}}" class="form-control" name="fullname" placeholder="Họ và tên" required="" oninvalid="this.setCustomValidity('Vui lòng nhập tên của bạn')" oninput="this.setCustomValidity('')">
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="tel" value="{{session('customer')->shipping_mobile}}" class="form-control" name="mobile" placeholder="Số điện thoại" required="" pattern="[0][0-9]{9,}" oninvalid="this.setCustomValidity('Vui lòng nhập số điện thoại bắt đầu bằng số 0 và ít nhất 9 con số theo sau')" oninput="this.setCustomValidity('')">
                                </div>
                                <div class="form-group col-sm-4">
                                    <select name="province" class="form-control province" required="" oninvalid="this.setCustomValidity('Vui lòng chọn Tỉnh / thành phố')" oninput="this.setCustomValidity('')">
                                        <option value="0">Tỉnh / thành phố</option>
                                        @if (!session()->has('customer') || session('customer')->ward_id == null)
                                        {{-- {{dd()}} --}}
                                        @foreach ($provinces as $_province)
                                            <option value="{{$_province->id}}">{{$_province->name}}</option>
                                        @endforeach
                                        @else
                                        {{-- {{'khong'}} --}}
                                        @foreach ($provinces as $_province)
                                            <option value="{{$_province->id}}" {{$_province->id == $province->id ? 'selected' : ''}}>{{$_province->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <select name="district" class="form-control district" required="" oninvalid="this.setCustomValidity('Vui lòng chọn Quận / huyện')" oninput="this.setCustomValidity('')">
                                        <option value="0">Quận / huyện</option>
                                        @if (session()->has('customer') && session('customer')->ward_id != null)
                                        @foreach ($districts as $_district)
                                            <option value="{{$_district->id}}" {{$_district->id == $district->id ? 'selected' : ''}}>{{$_district->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <select name="ward" class="form-control ward" required="" oninvalid="this.setCustomValidity('Vui lòng chọn Phường / xã')" oninput="this.setCustomValidity('')">
                                        <option value="">Phường / xã</option>
                                        @if (session()->has('customer') && session('customer')->ward_id != null)
                                        @foreach ($wards as $_ward)
                                            <option value="{{$_ward->id}}" {{$_ward->id == $ward->id ? 'selected' : ''}}>{{$_ward->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-sm-12">
                                    <input type="text" value="{{session()->has('customer') ? session('customer')->housenumber_street : ""}}" class="form-control" placeholder="Địa chỉ" name="housenumber_street" required="" oninvalid="this.setCustomValidity('Vui lòng nhập địa chỉ bao gồm số nhà, tên đường')" oninput="this.setCustomValidity('')">
                                </div>
                                <div class="form-group col-sm-12">
                                    <button type="submit" class="btn btn-primary pull-right">Cập nhật</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection