// function openMenuMobile() {
//     $(".menu-mb").width("250px");
//     $(".btn-menu-mb").hide("slow");
// }

// function closeMenuMobile() {
//     $(".menu-mb").width(0);
//     $(".btn-menu-mb").show("slow");
// }

function deleteProductInCart(e, id) {
    // handle front-end
    element = e.closest('.clearfix.text-left').remove();
    // handle back-end
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "get",
        url: "/product/ajax/deleteCart",
        data: { id: id },
        success: function(response) {
            data = JSON.parse(response);
            $('.number-total-product').html(data.amount);
            $('.price-total').html(number_format(data.totalAll) + '₫');
        }
    });
}

function addProductInCart(id, amount = 1) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    totalAll = 0;
    totalProduct = 0;
    $.ajax({
        type: "get",
        url: "/product/ajax/addCart",
        data: { id: id, amount: amount },
        success: function(response) {
            // frontend
            count = $('.number-total-product').html();

            data = JSON.parse(response);
            product = data.product;
            if (null != product) {
                count = parseInt(count) + 1;
                $('.number-total-product').html(count);

                $('.cart-product').append('<div class="clearfix text-left productCart">\
                <hr>\
                <div class="row">\
                    <div class="col-sm-6 col-md-1">\
                        <div><img class="img-responsive" src="' + window.location.origin + '/images/' + product.featured_image + '" alt="' + product.name + '"></div>\
                    </div>\
                    <div class="col-sm-6 col-md-3"><a class="product-name" href="' + $('#route').val() + '?id=' + product.id + '">' + product.name + '</a></div>\
                    <div class="col-sm-6 col-md-2"><span class="product-item-discount">' + number_format(product.sale_price) + '₫</span></div>\
                    <div class="col-sm-6 col-md-3">\
                        <input type="hidden" class="item-id" value="' + product.id + '">\
                        <input type="number" class="item-amount" onchange="changeCart(this)" min="1" value="1">\
                    </div>\
                    <div class="col-sm-6 col-md-2"><span class="total' + product.id + '">' + number_format(product.sale_price) + '₫</span></div>\
                    <div class="col-sm-6 col-md-1"><a class="remove-product" href="javascript:void(0)" onclick="deleteProductInCart(this, ' + product.id + ')">\
                        <span class="glyphicon glyphicon-trash"></span></a></div>\
                </div>\
            </div>');
            }
            $('total' + id).html(number_format(data.totalProduct) + '₫');
            $('.price-total').html(number_format(data.totalAll) + '₫');
        }
    });
}

// Thêm giá trị của thuộc tính theo phương thức GET vào thanh địa chỉ
// Nếu đã tồn tại thuộc tính thì cập nhật 
function addValueToHref(href, property, value) {
    if (href.search(property) != -1) {
        partern = new RegExp(property + '=' + '[^\&$]+');
        return href.replace(partern, property + '=' + value);
    }
    if (href.search('\\?') == -1) {
        href += "?";
    } else {
        href += "&";
    }
    return href += property + '=' + value;
}

function clear(name, string) {
    $('select[name=' + name + ']').empty();
    $('select[name=' + name + ']').append('<option value="0">' + string + '</option>');
}

function add(name, list) {
    list.forEach(element => {
        $('select[name=' + name + ']').append('<option value="' + element.id + '">' + element.name + '</option>');
    });
}

var countcomment = 1;
var countproduct = [];
const amountcomment = 5;
const amountproduct = 4;
var checkEmail = false;

function changeCart(el) {
    amount = el.value;
    id = el.previousElementSibling.value;
    // backend
    addProductInCart(id, amount);
}

$(document).ready(function() {
    // update
    $('.item-amount').change(function() {
        changeCart($(this));
    });

    // addCart
    $('.addCart').click(function() {
        id = $(this).attr('product-id');
        addProductInCart(id);
    });
    // Email exist
    $('#email').change(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "get",
            url: "/account/check",
            data: { email: $('#email').val() },
            success: function(response) {
                // console.log(response);
                checkEmail = response == 1 ? false : true;
                if (response == 1) {
                    $('#describe-email').html('Email đã tồn tại!').css('color', 'red');
                } else {
                    $('#describe-email').html('Bạn có thể đăng kí với email này!').css('color', 'green');
                }
            }
        });
    });
    // Password
    $('input[name=re-password]').keyup(function() {
        // console.log($(this).val());
        // console.log($('input[name=password]').val());
        if ($(this).val() == $('input[name=password]').val() && checkEmail) {
            // console.log('true');
            $('#sign-up').removeAttr('disabled');
        }
    });
    // Search 
    // $('.js-example-basic-multiple').select2();
    $('.js-example-basic-multiple').change(function() {
        console.log(1);
        console.log(keyword);
    });

    // Ajax district list
    $('select[name=province]').change(function() {
        id = $('select[name=province]').val();
        clear('district', 'Quận / Huyện');
        clear('ward', 'Phường / Xã');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "get",
            url: "/order/districts",
            data: { id: id },
            success: function(response) {
                data = JSON.parse(response);
                list = data[0];
                transport = data[1];
                if ($('.shipping-fee')) {
                    $('.shipping-fee').html(number_format(transport) + '₫');
                    total = $('.payment-total');
                    total.html(number_format(parseInt(total.attr('data')) + transport) + '₫');
                }
                add('district', list);
            }
        });
    });

    // Ajax wards list
    $('select[name=district]').change(function() {
        id = $('select[name=district]').val();
        clear('ward', 'Phường / Xã');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "get",
            url: "/order/wards",
            data: { id: id },
            success: function(response) {
                list = JSON.parse(response);
                // console.log(list);
                add('ward', list);
            }
        });
    });


    $('#input-3').rating({ displayOnly: true, step: 0.5 });
    $("#sort-select").val($('#sortSelected').val());
    $("#filter-" + $('#PriceRange').val()).attr('checked', 'checked');

    // Xem thêm bình luận
    $('#more-comment').click(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "get",
            url: "/product/nextComment",
            data: { current: countcomment * amountcomment, amount: amountcomment, product_id: $('input[name=product_id]').val() },
            success: function(response) {
                countcomment++;
                response = JSON.parse(response);
                comments = response.comments;
                still = response.still;
                // console.log(response);
                comments.forEach(comment => {
                    date = comment.created_date;
                    date = date.replace('.000000Z', '');
                    date = date.replace('T', ' ');
                    string = '<span class="star">\
                                <i class="glyphicon glyphicon-star"></i>\
                            </span>'
                    for (i = 1; i < comment.star; i++) {
                        string += '<span class="star">\
                                    <i class="glyphicon glyphicon-star"></i>\
                                </span>';
                    }
                    $('<hr>').insertBefore('#more');
                    $('<span class="date pull-right">' + date + '</span>').insertBefore('#more');
                    $('<div class="rating-container rating-md rating-animate rating-disabled">\
                    <div class="rating-stars" title="Five Stars">\
                        <span class="empty-stars">\
                            <span class="star">\
                            <i class="glyphicon glyphicon-star-empty"></i>\
                            </span><span class="star"><i class="glyphicon glyphicon-star-empty"></i></span>' +
                        '<span class="star"><i class="glyphicon glyphicon-star-empty"></i></span>' +
                        '<span class="star"><i class="glyphicon glyphicon-star-empty"></i></span>' +
                        '<span class="star"><i class="glyphicon glyphicon-star-empty"></i></span>' +
                        '</span>' +
                        '<span class="filled-stars" style="width: 100%;">' +
                        string +
                        '</span>\
                        <input class="answered-rating-input rating-input" name="rating" type="text" title="" value="5" readonly="readonly">\
                    </div>\
                </div>').insertBefore('#more');
                    $('<span class="by">' + comment.fullname + '</span>').insertBefore('#more');
                    $('<p>' + comment.description + '</p>').insertBefore('#more');
                });
                if (!still) {
                    $('#more').remove();
                }
            }
        });
    });

    // Chuyển hướng khi click vào "Sắp xếp"
    $('#sort-select').change(function() {
        values = $(this).val().split('-');
        query = window.location.search;
        href = window.location.pathname;
        if (href.search('sort') == -1) {
            href += "/" + 'sort';
        }
        href += query;
        href = addValueToHref(addValueToHref(href, 'column', values[0]), 'orderBy', values[1]);
        window.location.href = href;
    });
    // Chuyển hướng khi click vào "Khoảng giá"
    $('input[name=filter-price]').click(function() {
        values = $(this).val().split('-');
        query = window.location.search;
        href = window.location.pathname;
        if (href.search('range') == -1) {
            href += "/" + 'range';
        }
        href += query;
        href = addValueToHref(addValueToHref(href, 'min', values[0]), 'max', values[1]);
        window.location.href = href;
    });

    // Hiện lên "Xem chi tiết" và "Thêm vào giỏ hàng" khi hover vào sản phẩm
    $(".product-container").hover(function() {
        $(this).children(".button-product-action").toggle(400);
    });

    // Display or hidden button back to top
    // $(window).scroll(function() {
    //     if ($(this).scrollTop()) {
    //         $(".back-to-top").fadeIn();
    //     } else {
    //         $(".back-to-top").fadeOut();
    //     }
    // });

    // Khi click vào button back to top, sẽ cuộn lên đầu trang web trong vòng 0.8s
    $(".back-to-top").click(function() {
        $("html").animate({ scrollTop: 0 }, 800);
    });

    // Hiển thị form đăng ký
    $('.btn-register').click(function() {
        $('#modal-login').modal('hide');
        $('#modal-register').modal('show');
    });

    // Hiển thị form forgot password
    $('.btn-forgot-password').click(function() {
        $('#modal-login').modal('hide');
        $('#modal-forgot-password').modal('show');
    });

    // Hiển thị form đăng nhập
    $('.btn-login').click(function() {
        $('#modal-login').modal('show');
    });

    // Fix add padding-right 17px to body after close modal
    // Don't rememeber also attach with fix css
    // $('.modal').on('hide.bs.modal', function(e) {
    //     e.stopPropagation();
    //     $("body").css("padding-right", 0);

    // });

    // Hiển thị cart dialog
    $('.btn-cart-detail').click(function() {
        $('#modal-cart-detail').modal('show');
    });

    // Hiển thị aside menu mobile
    // $('.btn-aside-mobile').click(function() {
    //     $("main aside .inner-aside").toggle();
    // });

    // Hiển thị carousel for product thumnail
    // $('main .product-detail .product-detail-carousel-slider .owl-carousel').owlCarousel({
    //     margin: 10,
    //     nav: true

    // });
    // Bị lỗi hover ở bộ lọc (mobile) & tạo thanh cuộn ngang
    // Khởi tạo zoom khi di chuyển chuột lên hình ở trang chi tiết
    // $('main .product-detail .main-image-thumbnail').ezPlus({
    //     zoomType: 'inner',
    //     cursor: 'crosshair',
    //     responsive: true
    // });

    // Cập nhật hình chính khi click vào thumbnail hình ở slider
    $('main .product-detail .product-detail-carousel-slider img').click(function(event) {
        /* Act on the event */
        $('main .product-detail .main-image-thumbnail').attr("src", $(this).attr("src"));
        var image_path = $('main .product-detail .main-image-thumbnail').attr("src");
        $(".zoomWindow").css("background-image", "url('" + image_path + "')");

    });

    $('main .product-detail .product-description .rating-input').rating({
        min: 0,
        max: 5,
        step: 1,
        size: 'md',
        stars: "5",
        showClear: false,
        showCaption: false
    });

    $('main .product-detail .product-description .answered-rating-input').rating({
        min: 0,
        max: 5,
        step: 1,
        size: 'md',
        stars: "5",
        showClear: false,
        showCaption: false,
        displayOnly: false,
        hoverEnabled: true
    });

    $('main .ship-checkout[name=payment_method]').click(function(event) {
        /* Act on the event */
    });

    $('input[name=checkout]').click(function(event) {
        /* Act on the event */
        window.location.href = "/order";
    });

    $('input[name=back-shopping]').click(function(event) {
        /* Act on the event */
        window.location.href = "san-pham.html";
    });

    // Hiển thị carousel for relative products
    $('main .product-detail .product-related .owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 4
            },
            1000: {
                items: 5
            }
        }

    });
});

// Login in google
function onSignIn(googleUser) {
    var id_token = googleUser.getAuthResponse().id_token;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://study.com/register/google/backend/process.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        console.log('Signed in as: ' + xhr.responseText);
    };
    xhr.send('idtoken=' + id_token);
}