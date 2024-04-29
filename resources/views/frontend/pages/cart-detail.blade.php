@extends('frontend.layouts.master')

@section('content')
<!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        
                        <ul>
                            <li><a href="{{ route('home') }}">Trang chủ</a></li>
                            <li><a href="#">Giỏ hàng của bạn</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BREADCRUMB END
    ==============================-->

<!--============================
        CART VIEW PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            @if ($cartItems->count() > 0)
                <div class="row">
                    
                    <div class="col-xl-8">
                        <div class="wsus__cart_list">
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                        <tr class="d-flex">
                                            {{-- <th class="wsus__pro_img">
                                                Hình ảnh
                                            </th> --}}

                                            <th class="wsus__pro_name">
                                                Sản phẩm
                                            </th>

                                        
                                            <th class="wsus__pro_select">
                                                Số lượng
                                            </th>

                                            <th class="wsus__pro_tk">
                                                Thành tiền
                                            </th>

                                            <th class="wsus__pro_icon">
                                                <a href="#" class="common_btn clear_cart">Xóa</a>
                                            </th>
                                        </tr>
                                            @foreach ($cartItems as $item)
                                                @php
                                                    $product = \App\Models\Product::where('id', $item->product_id)->first();
                                                    $color = \App\Models\Color::where('id', $item->color_id)->first();
                                                
                                                
                                                    $quantityMinusSale = \App\Models\ColorDetail::where(['product_id' => $product->id, 'color_id' => $item->color_id])
                                                                                                ->value('quantity')   -  \App\Models\ColorDetail::where(['product_id' => $product->id, 'color_id' => $item->color_id])
                                                                                                ->value('sale');
                                                @endphp
                                                <tr class="d-flex">
                                                    {{-- <td class="wsus__pro_img">
                                                        <img src="{{ asset($product->image) }}" alt="product"class="img-fluid w-50">
                                                    </td> --}}

                                                    <td class="wsus__pro_name">
                                                        <div class="row">
                                                            <div class="col-3">
                                                        <img src="{{ asset($product->image) }}" alt="product"class="img-fluid" style="padding-left: 5px; max-width:120%;">

                                                            </div>
                                                            <div class="col-9">
                                                                <a href="{{ route('product-detail', $product->slug) }}">{!! $product->name !!}&#40;{!! $color->name !!}&#41;</a>
                                                    
                                                                <b class="text-align-end offer-price-cart" >{{ number_format( $item->product_price  , 0, ',', '.') }}&#8363;</b>
                                                        
                                                            </div>
                                                        </div>
                                                    
                                                        
                                                    </td>

                                                
                                                    
                                                    <td class="wsus__pro_select">
                                                        <div class="product_qty_wrapper">
                                                            <button class="btn  product-decrement ">-</button>
                                                            <input class="product-qty" data-rowid="{{ $item->id }}" type="text" min="1" max="{{ $quantityMinusSale  }}" value="{{ $item->qty }}" />
                                                            <button class="btn  product-increment">+</button>
                                                        </div>
                                                    </td>
                                                    <td class="wsus__pro_tk">
                                                        <h6 id="{{ $item->id }}">{{ number_format($item->product_price *$item->qty, 0, ',', '.') }}&#8363; </h6>
                                                    </td>
                                                

                                                    <td class="wsus__pro_icon">
                                                        <a href="{{ route('cart.remove-product', $item->id) }}"><i class="far fa-times"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            
                                        
                                    </tbody>
                                </table>
                            </div>
                         
                        </div>
                                
                    </div>
                    <div class="col-xl-4">
                        <div class="wsus__cart_list_footer_button" id="sticky_sidebar">
                            @php
                            
                                $user_id = \Illuminate\Support\Facades\Auth::guard('customer')->user()->id; // Lấy user_id của người dùng đang đăng nhập
                                $total = getCartTotal($user_id);
                                $mainTotal = getMainCartTotal($user_id);
                                $discountTotal = getCartDiscount($user_id);
                            @endphp 
                            <h4 class="d-flex justify-content-center">Giỏ Hàng</h4>
                            <p>Tổng cộng: <span class="text-dark font-weight-bold" id="total" >{{ isset($total) ? number_format($total, 0, ',', '.')  : '0' }}&#8363;</span>
                            </p>
                            <p>Mã giảm: <span class="text-dark font-weight-bold" id="discount_code" >{{  getDiscountCode()  }}</span></p>
                            <p>Tổng tiền giảm: <span class="text-dark font-weight-bold" id="discount">{{   isset($discountTotal) ? number_format($discountTotal, 0, ',', '.')  : '0' }}&#8363;</span></p>
                            <p class="total"><span>Tạm tính:</span> <span class="text-danger font-weight-bold" id="cart_total">{{ isset($mainTotal) ? number_format($mainTotal, 0, ',', '.')  : '0' }}&#8363;</span></p>
                            <fieldset class="pro-discount">
                                <legend >
                                
                                    <img alt="MÃ GIẢM GIÁ" src="//bizweb.dktcdn.net/100/462/587/themes/880841/assets/code_dis.gif?1713177410075"> Mã Giảm Giá
                                </legend>
                                <a href="" data-bs-toggle="modal" data-bs-target="#couponModal" style="
                                font-size: 14px;
                                text-decoration: underline;
                            
                                color: blue;
                            ">Chọn mã</a>


                                
                            
                            </fieldset>
                            <form id="coupon_form">
                                <input type="hidden" name="total" value="{{ $total }}" >
                                <input type="text" placeholder="Nhập mã" name="coupon_code" value="{{ session()->has('coupon') ? session()->get('coupon')['coupon_code'] : '' }}">
                                <button type="submit" class="common_btn btn-success" style=" width: 130px;">Áp mã</button>
                            </form>
                            <a class="common_btn mt-4 w-100 text-center"  style="background-color: forestgreen" href="{{ route('user.checkout') }}" >Thanh toán</a>    
                        
                            <a class="common_btn mt-1 w-100 text-center" href="{{ route('home.shop') }}"><i
                                    class="fab fa-shopify"></i> Tiếp tục mua sắm</a>
                            
                                
                        </div>
                        
                    </div>
                
                    
                    
                </div>
               
            @elseif($cartItems->count() == 0)
                <div class="col-xl-12">
                    <div class="d-flex justify-content-center" style="color: rgb(13, 60, 97);
                    background-color: rgb(232, 244, 253);padding:20px">
                        <i class="fa fa-info-circle pl-2"></i> Chưa có sản phẩm nào trong giỏ hàng của bạn lúc này. Hãy quay lại trang và bắt đầu — <a class=" text-primary text-bold " href="{{ route('home.shop') }}">mua sắm</a>!
                    </div>
                </div>
               
            @endif
            
        </div>
    </section>

    <!--============================
          CART VIEW PAGE END
    ==============================-->


    <div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="shopee-popup-form C2oiXP">
                <div class="shopee-popup-form__header">
                    <div class="shopee-popup-form__title">
                        <span tabindex="0">Chọn Voucher</span>
                    </div>
                </div>
                <div class="shopee-popup-form__main">
                    <div class="JuwA26 shopee-popup-form__main-container">
                        <div class="YcRvku">
                            <span class="dXrf9h" aria-label="Mã Voucher" tabindex="0">Mã Voucher</span>
                            <div class="qskn3u" aria-label="" tabindex="0">
                                <div class="input-with-validator-wrapper">
                                    <div class="input-with-validator">
                                        <input id="voucherInput" type="text" name="coupon_code" value="" placeholder="Mã Voucher" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <button id="applyButton" class="stardust-button stardust-button--disabled bRb6uQ LxsvzT qFr_OU" disabled="" role="button" tabindex="0" aria-label="Áp Dụng" aria-disabled="true">
                                <span id="buttonText">Áp Dụng</span>
                            </button>
                        </div>
                        <div id="message"></div>

                        <div class="lqe2oF hYSKGf">
                            <div class="RwB3H5 RLe78F A2nTco"><span tabindex="0">Có thể chọn 1 Voucher</span></div>
                            @foreach ($coupons as $coupon)
                                @php
                                    if($coupon->status == 1){
                                        $o = 'XsKHMJ';
                                        $a = 'a4L4_I';
                                    }else if($coupon->discount->start_date > date('Y-m-d')){
                                        $o = 'XsKHMJ';
                                        $a = 'a4L4_I';
                                    }else if($coupon->discount->end_date < date('Y-m-d')){
                                        $o = 'XsKHMJ';
                                        $a = 'a4L4_I';
                                    }else {
                                        $o = '';
                                        $a = '';
                                    }
                                @endphp
                                <div class="FcXANd gj97Rr {{ $o }} BP5yjX tIXZdG ZrFksI">
                                    <div class="q2pjG9">
                                        <div class="P8Mfoo" style="--vc-card-left-border-color: #08c; --vc-card-left-fill-color: #08c;">
                                            <div class="PcmVqR"></div>
                                        </div>
                                        <div class="hPIn_I"></div>
                                        <div class="MShxuW"></div>
                                        <div class="EAMMai" role="presentation">
                                            <div class="QqwAWp" role="presentation">
                                                
                                                <div class="GZ_QY_ wcZL9e" style="color: white; text-align: center; font-weight:600; padding-bottom:10px;">#{{ $coupon->discount->code }}</div>
                                                <div class="GZ_QY_ wcZL9e" style="color: white; font-size: 12px; text-align: center;">{{ $coupon->discount->name }} </div>

                                            </div>
                                            <div class="ZvtffU" role="presentation" style="
                                            padding: 15px;">
                                                <div class="XF46UZ">
                                                    <span aria-label=""></span>
                                                    <span aria-label=" Vui lòng mua hàng trên ứng dụng Shopee để sử dụng ưu đãi."></span>
                                                </div>
                                                <div class="xu9UIY">
                                                    @php
                                                        if($coupon->discount->type == 0){
                                                            $c = $coupon->discount->min_price;
                                                            $v = '%';
                                                        }else{
                                                            $c = number_format($coupon->discount->min_price, 0, ',', '.');
                                                            $v = '₫';
                                                        }
                                                    @endphp
                                                    <div class="UsdMJE ZbLqtU">Giá Trị Mã Giảm {{ $c }}{{ $v }}</div>
                                                </div>
                                                <div class="FI_cTo liTyw2">Đơn Tối Thiểu {{  number_format($coupon->discount->min_order, 0, ',', '.') }}₫</div>
                                                <div class="VWeV_W">
                                                    <div class="ljpBGw">
                                                        <div class="DOIpDy" aria-label="Tối đa 40K" style="color: red;">Giảm Tối Đa {{  number_format($coupon->discount->max_price, 0, ',', '.') }}₫</div>
                                                    </div>
                                                </div>
                                                <div class="MAHVi3">
                                                    <div class="QxJU53">
                                                        <div class="R3vm95 lVIsCZ">
                                                            <span class="eT2hlo" style="
                                                            font-size: 13px;
                                                        ">Hạn sử dụng: {{date('d-m-Y ' , strtotime($coupon->discount->end_date)) }}</span>
                                                        </div>
                                                    </div>
                                                
                                                </div>
                                            </div>
                                            <div class="UBy_Of" role="presentation">
                                                
                                                <div class="V8mIhB">
                                                    <div class="pdM6zg {{ $a }}" aria-label="" role="radio" aria-checked="false" tabindex="0" data-button-id="{{ $coupon->id }}" data-coupon-code="{{ $coupon->discount->code }}"><div class="check-mark"><i class="text-light fa fa-check"></i></div></div>
                                                </div>
                                            </div>
                                            <div class="cnFM7k owyP4s">
                                                <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg" class="izn8vl oHnnYi">
                                                    <path d="M1.50391 0.716797L2.50977 2.46973L3.53516 0.716797H4.8291L3.22754 3.30957L4.89258 6H3.59863L2.52441 4.17383L1.4502 6H0.151367L1.81152 3.30957L0.214844 0.716797H1.50391Z" fill="#EE4D2D"></path>
                                                </svg> 
                                                <div>1</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Xjagg4">
                                        <div class="iaxBQi aOZb2y" style="border-right: 0.0625rem dashed rgb(232, 232, 232); background: rgb(38, 170, 153);"></div>
                                    </div>
                                
                                </div>
                            @endforeach
                            
                          
                        </div>
                    </div>
                </div>
                <div class="shopee-popup-form__footer">
                    <div class="xcE5lt"></div>
                    <button class="cancel-btn">
                        <span tabindex="-1" aria-label=" Trở Lại">Trở Lại</span>
                    </button>
                    <button type="button" class="btn-apply-coupon btn btn-solid-primary btn--s btn--inline tDxbKE" aria-disabled="false">
                        <span tabindex="-1" aria-label=" OK">OK</span>
                    </button>
                </div>
            </div>
          </div>
        </div>
    </div>
    
@endsection

@push('scripts')

    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.product-increment').on('click', function(){
                let input = $(this).siblings('.product-qty');
                let quantity = parseInt(input.val()) + 1;
                let maxQuantity = parseInt(input.attr('max'));

                if (quantity <= maxQuantity) { 
                    let rowId = input.data('rowid');

                    input.val(quantity);

                    $.ajax({
                        url: "{{ route('cart.update-quantity') }}",
                        method: 'POST',
                        data: {
                            rowId: rowId,
                            quantity: quantity
                        },
                        success: function(data){
                            if(data.status == 'success'){
                                let productId = '#'+rowId;
                                $(productId).text(data.product_total + '₫');
                                updateTotal(data.total);
                                calculateCoupon(function(status, message) {
                                    if (status == 'success') {
                                        toastr.success(message);
                                    
                                    } else {
                                        toastr.error(message);
                                    }
                                });
                            }
                        },
                        error: function(data){
                            console.log(data);

                        }

                    });
                }else {
                    // Hiển thị thông báo khi vượt quá giá trị max
                    toastr.warning('Chỉ có ' + maxQuantity + ' sản phẩm trong cửa hàng');
                }
            });

            $('.product-decrement').on('click', function(){
                let input = $(this).siblings('.product-qty');
                let quantity = parseInt(input.val()) - 1;
                let rowId = input.data('rowid');
                if(quantity < 1){
                    quantity = 1;
                }

                console.log(rowId);
                input.val(quantity);

                $.ajax({
                    url: "{{ route('cart.update-quantity') }}",
                    method: 'POST',
                    data: {
                        rowId: rowId,
                        quantity: quantity
                    },
                    success: function(data){
                        if(data.status == 'success'){
                            let productId = '#'+rowId;
                            $(productId).text(data.product_total + '₫');
                            updateTotal(data.total);
                            calculateCoupon(function(status, message) {
                                if (status == 'success') {
                                    toastr.success(message);
                                
                                } else {
                                    toastr.error(message);
                                }
                            });
                        }
                    },
                    error: function(data){
                        console.log(data);

                    }

                });
            });

            function updateTotal(total) {
                $('span#total').text(total + '₫');
            }

            $('.clear_cart').on('click', function(e){
                e.preventDefault();
                Swal.fire({
                    title: "Xác nhận",
                    text: "Xóa tất cả sản phẩm trong giỏ hàng!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Xác nhận",
                    cancelButtonText: "Hủy",
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                        type: 'get',
                        url:"{{ route('cart.clear-cart') }}",
                        success: function(data){
                            if(data.status == 'success'){
                            Swal.fire({
                                title: "Xóa thành công!",
                                text: data.message
                            });
                            window.location.reload();
                            }
                            else if(data.status=='error'){
                            Swal.fire({
                                title: "Không thể xóa!",
                                text: data.message
                            });
                            window.location.reload();
                            }
                        }, 
                        error: function(xrr, status, error){
                            console.log(error);
                        }
                        });
                    }
                });
            });

            $('#coupon_form').on('submit', function(e){
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('apply-coupon') }}",
                    data: formData,
                    method: 'GET',
                    
                    success: function(data){
                        if(data.status == 'error'){
                            $('#discount').text(0 + '₫');
                            $('#discount_code').text(0);
                            $('#cart_total').text(data.cart_total);
                            toastr.error(data.message);
                        }
                        if(data.status == 'success'){
                            calculateCoupon(function(status, message) {
                                if (status == 'success') {
                                    toastr.success(message);
                                } else {
                                    toastr.error(message);
                                }
                            });
                           

                        }
                    },
                    error: function(data){
                        console.log(data);

                    }

                });
            });
           
            function calculateCoupon(){
                $.ajax({
                    url: "{{ route('coupon-calculation') }}",
                    method: 'GET',
                    
                    success: function(data){
                        if(data.status == 'success'){
                            $('#discount').text(data.discount );
                            $('#discount_code').text(data.discount_code);
                            $('#cart_total').text(data.cart_total );
                            // toastr.success(data.message);
                            
                        } else if(data.status == 'error') {
                            $('#discount').text(0 + '₫');
                            $('#discount_code').text(0);
                            $('#cart_total').text(data.cart_total  + '₫');
                            toastr.error(data.message);
                            
                        }
                        
                    },
                    error: function(data){
                        console.log(data);
                    }

                });
            }
 
        });
    </script>


<script>

document.addEventListener("DOMContentLoaded", function() {
    const cancelButton = document.querySelector(".cancel-btn"); // Lấy nút "Trở Lại"
    const overlay = document.querySelector(".overlay"); // Lấy lớp overlay của modal
    
    cancelButton.addEventListener("click", function() {
        closeModal(); // Đóng modal
    });
    
    overlay.addEventListener("click", function() {
        closeModal(); // Đóng modal khi click vào overlay
    });
});

function closeModal() {
    const modal = document.getElementById("couponModal");
    modal.style.display = "none";
}


document.addEventListener("DOMContentLoaded", function() {
                const buttons = document.querySelectorAll(".pdM6zg"); // Lấy tất cả các nút
                
                buttons.forEach(function(button) {
                    button.addEventListener("click", function() {
                        const buttonId = button.getAttribute("data-button-id");// Lấy ID của nút
                        
                        const selectedButton = document.querySelector(`.pdM6zg[data-button-id="${buttonId}"]`); // Tìm nút cụ thể bằng ID
                        
                        // Loại bỏ thuộc tính aria-checked="true" khỏi tất cả các nút
                        buttons.forEach(function(btn) {
                            btn.setAttribute("aria-checked", "false");
                        });
                        
                        // Đặt thuộc tính aria-checked="true" cho nút được click
                        selectedButton.setAttribute("aria-checked", "true");
                        
                        // Loại bỏ lớp 'selected' khỏi tất cả các nút
                        buttons.forEach(function(btn) {
                            btn.classList.remove("selected");
                            const checkMark = selectedButton.querySelector(".check-mark");
                            checkMark.style.display = "none";
                        });
                        
                        // Thêm lớp 'selected' chỉ vào nút được click
                        selectedButton.classList.add("selected");
                        
                        // Hiển thị dấu check trên nút được chọn
                        const checkMark = selectedButton.querySelector(".check-mark");
                        checkMark.style.display = "block";
                    });
                });
            });
            $(document).ready(function() {
                $('#applyButton').click(function(e) {
                    e.preventDefault(); // Ngăn chặn hành động mặc định của nút submit
                    
                    var voucherCode = $('#voucherInput').val().trim(); // Lấy giá trị mã giảm giá từ input
                    
                    // Kiểm tra xem mã giảm giá có được nhập vào không
                    if (voucherCode === '') {
                        // Hiển thị thông báo lỗi nếu không có mã giảm giá được nhập vào
                        $('#message').html('<span style="color: red;">Bạn cần nhập mã giảm giá để tiếp tục!</span>');
                        
                        return; // Dừng việc thực thi hàm nếu không có mã giảm giá
                    }
                    
                    // Gửi yêu cầu Ajax để kiểm tra mã giảm giá
                    $.ajax({
                        type: 'POST',
                        url: '/check-coupon', // Đặt URL của route kiểm tra mã giảm giá
                        data: {
                            coupon_code: voucherCode
                        },
                        success: function(response) {
                            // Hiển thị thông báo kết quả kiểm tra
                            $('#message').html('<span style="color: ' + (response.status === 'success' ? 'green' : 'red') + ';">' + response.message + '</span>');
                            if (response.status === 'success') {
                                toastr.success(response.message); // Hiển thị thông báo toastr thành công
                                setTimeout(function(){
                                    location.reload(); // Reload lại trang sau 1 giây
                                }, 1000);
                            }
                        },
                       error: function(xhr, status, error) {
                            // Hiển thị thông báo lỗi nếu có lỗi xảy ra
                            $('#message').html('<span style="color: red;">Có lỗi xảy ra khi kiểm tra mã giảm giá.</span>');
                            toastr.error('Có lỗi xảy ra khi kiểm tra mã giảm giá.');
                        }
                    });
                });

                $('.btn-apply-coupon').click(function() {
                    // Lấy dữ liệu từ nút đã được chọn trước đó
                    var couponId = $('.pdM6zg[aria-checked="true"]').data('coupon-code');
              

                    // Tạo dữ liệu formData để gửi qua AJAX
                   

                     // Gửi yêu cầu AJAX
                    $.ajax({
                        type: 'POST',
                        url: '/check-coupon',
                        data: {
                            coupon_code: couponId
                        },
                        success: function(response) {
                            // Hiển thị thông báo kết quả kiểm tra
                            //$('#message').html('<span style="color: ' + (response.status === 'success' ? 'green' : 'red') + ';">' + response.message + '</span>');
                            if (response.status === 'success') {
                                setTimeout(function(){
                                    location.reload(); // Reload lại trang sau 1 giây
                                }, 100);
                                toastr.success(response.message); // Hiển thị thông báo toastr thành công
                                
                            }
                        },
                       error: function(xhr, status, error) {
                            // Hiển thị thông báo lỗi nếu có lỗi xảy ra
                            $('#message').html('<span style="color: red;">Có lỗi xảy ra khi kiểm tra mã giảm giá.</span>');
                            toastr.error('Có lỗi xảy ra khi kiểm tra mã giảm giá.');
                        }
                    });
            
                });
            });
            // document.addEventListener("DOMContentLoaded", function() {
            //     const buttons = document.querySelectorAll(".pdM6zg"); // Lấy tất cả các nút
                
            //     buttons.forEach(function(button) {
            //         button.addEventListener("click", function() {
            //             const buttonId = button.getAttribute("data-button-id");// Lấy ID của nút
                        
            //             const selectedButton = document.querySelector(`.pdM6zg[data-button-id="${buttonId}"]`); // Tìm nút cụ thể bằng ID
                        
            //             // Loại bỏ lớp 'selected' khỏi tất cả các nút
            //             buttons.forEach(function(btn) {
            //                 btn.classList.remove("selected");
            //                 const checkMark = selectedButton.querySelector(".check-mark");
            //                 checkMark.style.display = "none";
            //             });
                        
            //             // Thêm lớp 'selected' chỉ vào nút được click
            //             selectedButton.classList.add("selected");
                        
            //             // Hiển thị dấu check trên nút được chọn
            //             const checkMark = selectedButton.querySelector(".check-mark");
            //             checkMark.style.display = "block";
            //         });
            //     });
            // });


           



            document.addEventListener("DOMContentLoaded", function() {
                const voucherInput = document.getElementById('voucherInput');
                const applyButton = document.getElementById('applyButton');
                const buttonText = document.getElementById('buttonText');
                
                // Lắng nghe sự kiện nhập liệu trên thẻ input
                voucherInput.addEventListener('input', function() {
                    // Nếu độ dài của giá trị nhập vào lớn hơn 0
                    if (voucherInput.value.length > 0) {
                        // Bỏ trạng thái disabled của nút và thay đổi màu sắc
                        applyButton.removeAttribute('disabled');
                        applyButton.style.backgroundColor = '#08c';
                        applyButton.style.cursor = 'pointer';
                        buttonText.style.color = 'white'; // Chuyển màu chữ sang trắng
                    } else {
                        // Nếu không có giá trị nhập vào, đặt lại trạng thái disabled và màu sắc ban đầu của nút
                        applyButton.setAttribute('disabled', true);
                        applyButton.style.backgroundColor = '';
                        applyButton.style.cursor = '';
                        buttonText.style.color = ''; // Đặt màu chữ về mặc định
                    }
                });
            });


            // Sự kiện click cho nút button




</script>
@endpush