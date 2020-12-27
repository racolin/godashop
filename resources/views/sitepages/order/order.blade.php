@extends('sitepages.layout.master')
@section('title')
<title>Đặt hàng - Mỹ Phẩm Goda</title>
@endsection

@section('main')
<main id="maincontent" class="page-main">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="/" target="_self">Giỏ hàng</a></li>
                    <li><span>/</span></li>
                    <li class="active"><span>Thông tin giao hàng</span></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <aside class="col-md-6 cart-checkout">
                @foreach (session('products') as $pack)
                <div class="row">
                    <div class="col-xs-2">
                        <img class="img-responsive" src="{{asset("images/" .$pack['product']->featured_image . "")}}" alt="{{$pack['product']->name}}"> 
                    </div>
                    <div class="col-xs-7">
                        <a class="product-name" href="{{route('product.details', ['id' => $pack['product']->id])}}">{{$pack['product']->name}}</a> 
                        <br>
                        <span>{{$pack['amount']}}</span> x <span>{{number_format($pack['product']->sale_price)}}₫</span>
                    </div>
                    <div class="col-xs-3 text-right">
                        <span>{{number_format($pack['product']->sale_price * $pack['amount'])}}₫</span>
                    </div>
                </div>
                <hr>
                @endforeach 
                <div class="row">
                    <div class="col-xs-6">
                        Tạm tính
                    </div>
                    <div class="col-xs-6 text-right">
                        {{number_format(session('totalAll'))}}₫
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        Phí vận chuyển
                    </div>
                    <div class="col-xs-6 text-right">
                        <span class="shipping-fee" data="">{{number_format($transport)}}₫</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-6">
                        Tổng cộng
                    </div>
                    <div class="col-xs-6 text-right">
                        <span class="payment-total" data="{{session('totalAll')}}">{{number_format(session('totalAll') + $transport)}}₫</span>
                    </div>
                </div>
            </aside>
            <div class="ship-checkout col-md-6">
                <h4>Thông tin giao hàng</h4>
                @if (empty(session('customer')))
                {{-- chưa đăng nhập --}}
                <div>Bạn đã có tài khoản? <a href="javascript:void(0)" class="btn-login">Đăng Nhập  </a></div><br>
                <form action="{{route('order.payment')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <input type="text" value="" class="form-control" name="fullname" placeholder="Họ và tên" required="" oninvalid="this.setCustomValidity('Vui lòng nhập tên của bạn')" oninput="this.setCustomValidity('')">
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="tel" value="" class="form-control" name="mobile" placeholder="Số điện thoại" required="" pattern="[0][0-9]{9,}" oninvalid="this.setCustomValidity('Vui lòng nhập số điện thoại bắt đầu bằng số 0 và ít nhất 9 con số theo sau')" oninput="this.setCustomValidity('')">
                        </div>
                        <div class="form-group col-sm-4">
                            <select name="province" class="form-control province" required="" oninvalid="this.setCustomValidity('Vui lòng chọn Tỉnh / thành phố')" oninput="this.setCustomValidity('')">
                                <option value="0">Tỉnh / Thành phố</option>
                                @foreach ($provinces as $_province)
                                    <option value="{{$_province->id}}">{{$_province->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <select name="district" class="form-control district" required="" oninvalid="this.setCustomValidity('Vui lòng chọn Quận / huyện')" oninput="this.setCustomValidity('')">
                                <option value="0">Quận / Huyện</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <select name="ward" class="form-control ward" required="" oninvalid="this.setCustomValidity('Vui lòng chọn Phường / xã')" oninput="this.setCustomValidity('')">
                                <option value="0">Phường / Xã</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12">
                            <input type="text" value="" class="form-control" placeholder="Địa chỉ" name="address" required="" oninvalid="this.setCustomValidity('Vui lòng nhập địa chỉ bao gồm số nhà, tên đường')" oninput="this.setCustomValidity('')">
                        </div>
                    </div>
                    <h4>Phương thức thanh toán</h4>
                    <div class="form-group">
                        <label> <input type="radio" name="payment_method" checked="" value="0"> Thanh toán khi giao hàng (COD) </label>
                        <div></div>
                    </div>
                    <div class="form-group">
                        <label> <input type="radio" name="payment_method" value="1"> Chuyển khoản qua ngân hàng </label>
                        <div class="bank-info">STK: 0421003707901<br>Chủ TK: Phan Trung Tín. Ngân hàng: Vietcombank TP.HCM <br>
                            Ghi chú chuyển khoản là tên và chụp hình gửi lại cho shop dễ kiểm tra ạ
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-primary pull-right">Hoàn tất đơn hàng</button>
                    </div>
                </form>
                @else
                {{-- đã đăng nhập --}}
                <br>
                <form action="{{route('order.payment')}}" method="POST">
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
                                <option value="0">Tỉnh / Thành phố</option>
                                @foreach ($provinces as $_province)
                                    <option value="{{$_province->id}}" {{$_province->id == $province_id ? 'selected' : ''}}>{{$_province->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <select name="district" class="form-control district" required="" oninvalid="this.setCustomValidity('Vui lòng chọn Quận / huyện')" oninput="this.setCustomValidity('')">
                                <option value="0">Quận / Huyện</option>
                                @foreach ($districts as $_district)
                                    <option value="{{$_district->id}}" {{$_district->id == $district_id ? 'selected' : ''}}>{{$_district->name}}</option>
                                @endforeach
                            </select>
                            
                        </div>
                        <div class="form-group col-sm-4">
                            <select name="ward" class="form-control ward" required="" oninvalid="this.setCustomValidity('Vui lòng chọn Phường / xã')" oninput="this.setCustomValidity('')">
                                <option value="0">Phường / Xã</option>
                                @foreach ($wards as $_ward)
                                    <option value="{{$_ward->id}}" {{$_ward->id == $ward_id ? 'selected' : ''}}>{{$_ward->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-12">
                            <input type="text" value="{{session('customer')->housenumber_street}}" class="form-control" placeholder="Địa chỉ" name="address" required="" oninvalid="this.setCustomValidity('Vui lòng nhập địa chỉ bao gồm số nhà, tên đường')" oninput="this.setCustomValidity('')">
                        </div>
                    </div>
                    <h4>Phương thức thanh toán</h4>
                    <div class="form-group">
                        <label> <input type="radio" name="payment_method" checked="" value="0"> Thanh toán khi giao hàng (COD) </label>
                        <div></div>
                    </div>
                    <div class="form-group">
                        <label> <input type="radio" name="payment_method" value="1"> Chuyển khoản qua ngân hàng </label>
                        <div class="bank-info">STK: 0421003707901<br>Chủ TK: Phan Trung Tín. Ngân hàng: Vietcombank TP.HCM <br>
                            Ghi chú chuyển khoản là tên và chụp hình gửi lại cho shop dễ kiểm tra ạ
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-primary pull-right">Hoàn tất đơn hàng</button>
                    </div>
                </form>
                @endif
                
            </div>
        </div>
    </div>
</main>
@endsection