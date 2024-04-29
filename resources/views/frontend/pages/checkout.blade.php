@extends('frontend.layouts.master')

@section('content')

    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ul>
                            <li><a href="
                                {{ route('home') }}">Trang chủ</a></li>
                            <li><a href="
                                {{ route('cart-details') }}">Giỏ hàng</a></li>
                            <li><a href="{{ route('user.checkout') }}">Thanh toán</a></li>
                            
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
        CHECK OUT PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-7">
                        <div class="wsus__check_form">
                            <h5 style="
                            display: flex;
                            justify-content: space-between;
                        "><span style="text-transform: capitalize; font-size: 18px; font-weight: 500;    align-items: center;display: flex;">Thông tin người nhận</span>  
                            <a href="#" class="btn btn-info text-light" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Thêm địa chỉ</a>

                            </h5>
                            {{-- <div class="row">
                                <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="wsus__check_single_form">
                                        <input type="text" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="wsus__check_single_form">
                                        <input type="text" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xl-12">
                                    <div class="wsus__check_single_form">
                                        <input type="text" placeholder="Company Name (Optional)">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="wsus__check_single_form">
                                        <select class="select_2" name="state">
                                            <option value="AL">Country / Region *</option>
                                            <option value="">dhaka</option>
                                            <option value="">barisal</option>
                                            <option value="">khulna</option>
                                            <option value="">rajshahi</option>
                                            <option value="">bogura</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="wsus__check_single_form">
                                        <input type="text" placeholder="Street Address *">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="wsus__check_single_form">
                                        <input type="text" placeholder="Apartment, suite, unit, etc. (optional)">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="wsus__check_single_form">
                                        <input type="text" placeholder="Town / City *">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="wsus__check_single_form">
                                        <input type="text" placeholder="State *">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="wsus__check_single_form">
                                        <input type="text" placeholder="Zip *">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="wsus__check_single_form">
                                        <input type="text" placeholder="Phone *">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="wsus__check_single_form">
                                        <input type="email" placeholder="Email *">
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xl-12">
                                    <div class="accordion checkout_accordian" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    <div class="wsus__check_single_form">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                id="flexCheckDefault">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Same as shipping address
                                                            </label>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse"
                                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body p-0">
                                                    <div class="wsus__check_form p-0" style="box-shadow: none;">
                                                        <div class="row">
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="text" placeholder="First Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="text" placeholder="Last Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="text"
                                                                        placeholder="Company Name (Optional)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <select class="select_2" name="state">
                                                                        <option value="AL">Country / Region *</option>
                                                                        <option value="">dhaka</option>
                                                                        <option value="">barisal</option>
                                                                        <option value="">khulna</option>
                                                                        <option value="">rajshahi</option>
                                                                        <option value="">bogura</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="text" placeholder="Street Address *">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="text"
                                                                        placeholder="Apartment, suite, unit, etc. (optional)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="text" placeholder="Town / City *">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="text" placeholder="State *">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="text" placeholder="Zip *">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="text" placeholder="Phone *">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="email" placeholder="Email *">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xl-12">
                                    <div class="wsus__check_single_form">
                                        <h5>Additional Information</h5>
                                        <textarea cols="3" rows="4"
                                            placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row">
                                @foreach ($addresses as $item)
                                    <div class="col-xl-12">
                                        <div class="wsus__checkout_single_address">
                                            <div class="form-check">
                                                <input class="form-check-input shipping_address" data-id="{{ $item->id }}" type="radio" name="flexRadioDefault"
                                                    id="flexRadioDefault1" >
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Chọn địa chỉ nhận hàng
                                                </label>
                                            </div>
                                            <div class="column">
                                                <span class="text-dark text-h">{{ $item->name }}</span>
                                                <span >{{ $item->phone }}</span>
                                                
                                                <div class="body-nav">
                                                    <span>
                                                         {{ $item->address }}
                                                    </span>
                                                   
                                                </div>
                                                <div class="body-nav">
                                                    <span>
                                                        @php
                                                            $xa = App\Models\Ward::where('id',$item->ward_id)->first();
                                                            $quan = App\Models\District::where('id',$item->district_id)->first();
                                                            $ct = App\Models\City::where('id',$item->city_id)->first();
                                                        @endphp
                                                        {{ $xa->name }}, {{ $quan->name }}, {{ $ct->name }}
                                                   </span>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                @endforeach
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5">
                        <div class="wsus__order_details" id="sticky_sidebar">
                            <p class="wsus__product">TỔNG TIỀN</p>
                            
                           
                    
                            <div class="wsus__order_details_summery">
                                <p class=" ">Tiền hàng: <span class="text-dark  fw-bold">{{ number_format(getCartTotal($user_id), 0, ',', '.') }}&#8363;</span></p>
                                <p>Mã giảm: <span class="text-dark  fw-bold">{{ getDiscountCode() }}</span></p>
                                <p>Tổng tiền được giảm: <span class="text-dark  fw-bold">{{ number_format(getCartDiscount($user_id), 0, ',', '.') }}&#8363;</span></p>
                                <hr>
                                <p><b>Tiền thanh toán:</b> <span class="text-danger  fw-bold"><b>{{ number_format(getMainCartTotal($user_id), 0, ',', '.') }}&#8363;</b></span></p>
                            </div>
                        
                            <p class="wsus__product">PHƯƠNG THỨC THANH TOÁN</p>

                            <div class=" " style="padding-bottom: 10px;">
                            <a href="" id="submitCheckOutForm" class="common_btn "style="background-color: forestgreen" >Thanh toán khi nhận hàng</a>
                               
                            </div>
                           
                            <form  action="{{ route('user.payment.vn-pay') }}" method="POST">
                                @csrf
                                <input type="hidden" name="shipping_address_id" value="" id="shipping_address_id">
                                <input type="hidden" name="total" value="{{ getCartTotal($user_id) }}">
                                
                                <button type="submit" class="common_btn "  name="redirect" style="background-color: crimson ">
                                    Thanh toán bằng VNPay 
                                </button>
                            </form>
                            
                            <form action="" id="checkOutForm">
                                @csrf
                                <input type="hidden" name="address_id" value="" id="address_id">
                            </form>
                            

                            

                        </div>
                    </div>
                </div>
            
        </div>
    </section>

    <div class="wsus__popup_address">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm địa chỉ mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="wsus__check_form p-3">
                            <form action="{{ route('user.checkout.address.create') }}" method="POST" >
                                @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="wsus__check_single_form">
                                        <input type="text" placeholder="Họ và tên" name="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="wsus__check_single_form">
                                        <input type="text" placeholder="Số điện thoại" name="phone">
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="wsus__check_single_form">
                                        <select class="select_2 city" name="city_id">
                                            <option value="AL">Chọn Tỉnh / Thành Phố</option>
                                            @foreach ($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="wsus__check_single_form">
                                        <select class="select_2 district" name="district_id">
                                            <option value="AL">Chọn Quận / Huyện</option>
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="wsus__check_single_form">
                                        <select class="select_2 ward" name="ward_id">
                                            <option value="AL">Chọn Xã/Phường/Thị Trấn</option>
                                          
                                        </select>
                                    </div>
                                </div>
                                
                               
                               
                                <div class="col-md-12">
                                    <div class="wsus__check_single_form">
                                        <input type="text" placeholder="Địa chỉ cụ thể" name="address">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__check_single_form">
                                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                    </div>
                                </div>
                            </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
    <!--============================
        CHECK OUT PAGE END
    ==============================-->

   
@endsection

@push('scripts')



<script>
  $(document).ready(function(){
    $('#shipping_address_id').val("");
    $('#address_id').val("");
    $('input[type="radio"]').prop('checked', false);

    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.city').change(function(){
        var city_id = $(this).val();
        console.log(city_id);
        $.ajax({
            url: "{{ route('user.get-district', '') }}/" + city_id,
            type: 'GET',
            success:function(response){
                var options = '<option value="">Chọn Quận/Huyện</option>';
                $.each(response, function(index, district){
                    options += '<option value="'+district.id+'">'+district.name+'</option>';
                });
                $('.district').html(options);
            }
        });
    });

    $('.district').change(function(){
        var district_id = $(this).val();
        $.ajax({
            url: "{{ route('user.get-ward', '') }}/" + district_id,
            type: 'GET',
            success:function(response){
                var options = '<option value="">Chọn Xã/Phường/Thị Trấn</option>';
                $.each(response, function(index, ward){
                    options += '<option value="'+ward.id+'">'+ward.name+'</option>';
                });
                $('.ward').html(options);
            }
        });
    });

    $('.shipping_address').on('click', function(){
        $('#shipping_address_id').val($(this).data('id'));
        $('#address_id').val($(this).data('id'));
    });

    $('#submitCheckOutForm').on('click', function(e){
        e.preventDefault();
        if($('#shipping_address_id').val() == ""){
            toastr.error('Địa chỉ nhận hàng chưa được chọn!');
        }
        else if($('.agree_term').prop('')){
            toastr.error('Bạn cần đồng ý với điều khoản sử dụng của cửa hàng!')
        }
        else{
            $.ajax({
            url: "{{ route('user.checkout.form-submit') }}",
            method: 'POST',
            data: $('#checkOutForm').serialize(),
            
            success: function(data){
                if(data.status == 'success'){
                   
                    toastr.success(data.message);
                    window.location.href = data.redirect; 
                }

            },
            error: function(data){
                console.log(data);
            }
        });
        }

       
    })

  });
</script>
   
@endpush