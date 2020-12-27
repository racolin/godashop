                        <div class="product-container">
                            <div class="image">
                                <img class="img-responsive" src="{{asset("images/$product->featured_image")}}" alt="">
                            </div>
                            <div class="product-meta">
                                <h5 class="name">
                                    <a class="product-name" href="{{route("product.details", ["id" => $product->id])}}" title="{{$product->name}}">{{$product->name}}</a>
                                </h5>
                                <div class="product-item-price">
                                    @if ($product->discount_percentage != "0")
                                    <span class="product-item-regular">{{number_format($product->price) . "₫"}}</span>
                                    @endif        
                                    <span class="product-item-discount">
                                        {{-- Cải tiến cập nhật giá sale theo ngày giờ chỉ định --}}
                                        {{number_format($product->price * (1 - $product->discount_percentage / 100)) . "₫"}}
                                    </span>    
                                </div>
                            </div>
                            <div class="button-product-action clearfix">
                                {{-- Luu vao session --}}
                                <div class="cart icon">
                                    <a class="btn btn-outline-inverse buy addCart" product-id="{{$product->id}}" href="javascript:void(0)" title="Thêm vào giỏ">
                                    Thêm vào giỏ <i class="fa fa-shopping-cart"></i>
                                    </a>
                                </div>
                                <div class="quickview icon">
                                    <a class="btn btn-outline-inverse" href="{{route("product.details", ["id" => $product->id])}}" title="Xem nhanh">
                                    Xem chi tiết <i class="fa fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>