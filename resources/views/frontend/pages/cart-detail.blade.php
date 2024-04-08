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
            <div class="row">
                @if ($cartItems->count() > 0)
                <div class="col-xl-9">
                    <div class="wsus__cart_list">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                    <tr class="d-flex">
                                        <th class="wsus__pro_img">
                                            Hình ảnh
                                        </th>

                                        <th class="wsus__pro_name">
                                            Tên sản phẩm
                                        </th>

                                       
                                        <th class="wsus__pro_select">
                                            Số lượng
                                        </th>

                                        <th class="wsus__pro_tk">
                                            Đơn giá
                                        </th>

                                        <th class="wsus__pro_icon">
                                            <a href="#" class="common_btn clear_cart">Xóa</a>
                                        </th>
                                    </tr>
                                        @foreach ($cartItems as $item)
                                            @php
                                                $product = \App\Models\Product::where('id', $item->product_id)->first();
                                                
                                            @endphp
                                            <tr class="d-flex">
                                                <td class="wsus__pro_img">
                                                    <img src="{{ asset($product->image) }}" alt="product"class="img-fluid w-50">
                                                </td>

                                                <td class="wsus__pro_name">
                                                    <p>{!! $product->name !!}</p>
                                                    <b >{{ number_format($product->offer_price, 0, ',', '.') }}&#8363;</b>
                                                    {{-- @foreach ($item->options->colors as $key =>$color)
                                                    <span>&#40;Màu {{ $color['name'] }}&#41;</span>
                                                    @endforeach --}}
                                                </td>

                                            
                                                
                                                <td class="wsus__pro_select">
                                                    <div class="product_qty_wrapper">
                                                        <button class="btn  product-decrement ">-</button>
                                                        <input class="product-qty" data-rowid="{{ $item->id }}" type="text" min="1" max="100" value="{{ $item->qty }}" readonly/>
                                                        <button class="btn  product-increment">+</button>
                                                    </div>
                                                </td>
                                                <td class="wsus__pro_tk">
                                                    <h6 id="{{ $item->id }}">{{ number_format($product->offer_price*$item->qty, 0, ',', '.') }}&#8363; </h6>
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
                <div class="col-xl-3">
                    <div class="wsus__cart_list_footer_button" id="sticky_sidebar">
                        @php
                           
                            $user_id = \Illuminate\Support\Facades\Auth::guard('customer')->user()->id; // Lấy user_id của người dùng đang đăng nhập
                            $total = getCartTotal($user_id);
                        @endphp 
                        <h6>Tổng tiền</h6>
                        <p >Tổng cộng: <span id="total">{{ isset($total) ? number_format($total, 0, ',', '.')  : '0' }}&#8363;</span>
                        </p>
                        <p>Mã giảm: <span>10.00</span></p>
                        <p class="total"><span>Tiền thanh toán:</span> <span>{{ isset($total) ? number_format($total, 0, ',', '.')  : '0' }}&#8363;</span></p>

                        <form id="coupon_form">
                            <input type="text" placeholder="Coupon Code" name="coupon_code">
                            <button type="submit" class="common_btn">apply</button>
                        </form>
                        <a class="common_btn mt-4 w-100 text-center" href="{{ route('user.checkout') }}" >Thanh toán</a>    
                       
                        <a class="common_btn mt-1 w-100 text-center" href="{{ route('home.shop') }}"><i
                                class="fab fa-shopify"></i> Tiếp tục mua sắm</a>
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
        </div>
    </section>

    <!--============================
          CART VIEW PAGE END
    ==============================-->
    
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
                let rowId = input.data('rowid');
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
                        }
                    },
                    error: function(data){
                        console.log(data);

                    }

                });
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
                            toastr.error(data.message);
                        }
                    },
                    error: function(data){
                        console.log(data);

                    }

                });
            })

            
        });
    </script>
@endpush