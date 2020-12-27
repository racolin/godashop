@extends('sitepages.layout.master')
@section('title')
    <title>Trang chủ - Mỹ Phẩm Goda</title>
@endsection
@section('main')

<main id="maincontent" class="page-main">
    <div class="container">
        @foreach ($allTypeProducts as $caption => $typeProducts)
            <div class="row equal">
                <div class="col-xs-12">
                    <h4 class="home-title">{{$caption}}</h4>
                </div>
                @foreach ($typeProducts['products'] as $product)
                <div class="col-xs-6 col-sm-3">
                    @include('sitepages.layout.product')
                </div>
                @endforeach
                {{-- @if ($typeProducts['still'])
                <div id="more">
                    <button class="more-product" id="more-{{$typeProducts['products'][0]->category_id}}">Xem thêm</button>
                </div>
                @endif --}}
            </div>
        @endforeach
    </div>
</main>
@endsection
  