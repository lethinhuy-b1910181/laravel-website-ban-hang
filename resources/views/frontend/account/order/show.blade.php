@php
    $address = json_decode($order->order_address);
    $email = \App\Models\Customer::where('id', $address->user_id)->first();

    $city = \App\Models\City::where('id', $address->city_id)->first();
    $district = \App\Models\District::where('id', $address->district_id)->first();
    $ward = \App\Models\Ward::where('id', $address->ward_id)->first();
    $coupon = json_decode($order->order_coupon);
@endphp

@extends('frontend.layouts.master')

@section('content')
<div class="container BtZOqO">
    @include('frontend.sidebar')
    <div class="fkIi86">
        <div class="CAysXD">
            <div class="" style="display: contents;">
                <div class="utB99K">
                    <div class="SFztPl">
                        <a href="{{ route('user.orders.index') }}" class="icon-size"><i class="fa fa-angle-left"></i> TRỞ LẠI</a>
                        <span>Mã đơn hàng: {{ $order->id }}</span>
                    </div>
                    <div class="RCnc9v">
                        
                       <div class="row col-12 RCnc9v-row">
                        <div class="col-4">
                            <p>Ngày đặt hàng:</p>
                            <span>{{date('d-m-Y ' , strtotime($order->created_at)) }}</span>
                        </div>
                        <div class="col-4">
                            <p>Tình trạng đơn hàng:</p>
                            @php
                                if($order->order_status == 0){
                                    $t = 'Đang chờ duyệt';
                                    $tl = 'btn btn-sm btn-info';
                                    $icon = 'fas fa-clock';
                                }else if($order->order_status == 1){
                                    $t = 'Đang chờ vận chuyển';
                                    $tl = 'btn btn-sm btn-primary';
                                    $icon = 'fas fa-hourglass-half';
                                }else if($order->order_status == 2 ){
                                    $t = 'Đang được giao';
                                    $tl = 'btn btn-sm btn-warning';
                                    $icon = 'fas fa-truck';
                                }else if($order->order_status == 3){
                                    $t = 'Đã giao';
                                    $tl = 'btn btn-sm btn-success';
                                    $icon = 'fa fa-check';
                                }else if($order->order_status == 4){
                                    $t = 'Đã hủy';
                                    $tl = ' btn btn-sm btn-danger';
                                    $icon = 'bx bx-x-circle';
                                    
                                }else if($order->order_status == 5){
                                    $t = 'Giao hàng không thành công';
                                    $tl = ' btn btn-sm btn-danger';
                                    $icon = 'bx bx-x-circle';
                                    
                                }
                            @endphp
                            <span class="{{ $tl }} text-light"><i class="{{ $icon }}"></i> {{ $t }}</span>
                        </div>
                        <div class="col-4">
                            <p>Vận chuyển bởi: </p>
                            @if($order->shipper_status == 0)
                                <span class="text-warning">Chưa cập nhật</span>
                            @elseif($order->shipper_status ==1)
                                @php
                                  $ship = \App\Models\Shipper::findOrFail($order->shipper_id); 
                                @endphp
                                <span class="text-dark">{{ $ship->name }}</span> <br>
                                <span>{{ $ship->phone }}</span>

                            @endif
                        </div>
                        
                       
                        
                       </div>
                       <hr>
                    </div>

                    <div class="row col-12 RCnc9v-row">
                        <div class="col-8">
                            <div class="">
                                <span class="RCnc9v-text">Tên khách hàng: </span>
                                <span>{{ $address->name }}</span>
                            </div>
                            <div class="">
                                <span class="RCnc9v-text">Địa chỉ nhận hàng: </span>
                                <span>{{ $address->address }}, {{ $ward->name }}, {{ $district->name }}, {{ $city->name }}</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="">
                                <span class="RCnc9v-text">Số điện thoại: </span>
                                <span>{{ $address->phone }}</span>
                            </div>
                            <div class="">
                                <span class="RCnc9v-text">Thanh toán: </span>
                                <span>{{ $order->payment_method }} </span>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-md-12">
                          <div class="section-title">Danh sách sản phẩm của đơn hàng</div>
                          <div class="table-responsive">
                            <table class="table table-striped table-hover table-md">

                                @php 
                                    $count = 0;
                                    if($order->order_status == 3){
                                        $done = '';
                                    }else $done = 'd-none';
                                 @endphp


                              <tr class="head">
                                <th data-width="40">#</th>
                                <th class="text-center">Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-right">Đơn giá</th>
                                <th class="text-right">Thành tiền</th>
                                @if($order->order_status == 3)
                                <th class="text-right {{ $done }}">Đánh giá</th>
                                @endif
                              </tr>
                              
                                  
                                  @foreach ($orderDetail as $item)
                              
                                  <tr>
                                      <td>{{ ++$count}}</td>
                                      <td class="text-center"><img width='80px' height='80px' src="{{ asset($item->product->image) }}"> </img></td>
                                      <td>
                                        <div class="j3I_Nh" tabindex="0">    <a href="{{ route('product-detail', $item->product->slug ) }}" target="_blank" rel="noopener noreferrer">{{ $item->product_name }}</a></div>
                                        @php

                                            $color = \App\Models\Color::where('id', $item->color_id)->first();
                                            
                                        @endphp
                                        <div class="rsautk" tabindex="0">Phân loại hàng: {{ $color->name }}</div>
                                      

                                    </td>
                                      <td class="text-center">{{ $item->qty }}</td>
                                      <td class="text-right"> {{  number_format($item->unit_price, 0, ',', '.')}} &#8363;</td>
                                      <td class="text-right"> {{  number_format($item->qty * $item->unit_price , 0, ',', '.')}} &#8363;</td>
                                      @if($order->order_status == 3)
                                      <td style="
                                      text-align: center;font-size: 20px;
                                  ">
                                            @if ($item->status == 0)
                                                <a href="" class="text-warning" data-bs-toggle="modal" data-bs-target="#reviewModal-{{ $item->id }}"><i class=" fas fa-star"></i></a>
                                            @else
                                                <a href="" class="text-primary " data-bs-toggle="modal" data-bs-target="#viewModal-{{ $item->id }}"><i class=" fas fa-eye"></i></a>
                                                
                                            @endif
                                      </td>
                                      @endif
                                    </tr>
                                  @endforeach
                              
                              
                            
                            </table>
                          </div>
                          <div class="row mt-4">
                            <div class="col-lg-7">
                              <div class="section-title">Phương thức thanh toán</div>
                              <b class="section-lead text-info">Thanh toán bằng {{ $order->payment_method }}</b>
                              
                            </div>
                            <div class="col-lg-5 ">
                              <div class="invoice-detail-item">
                                  <div class="invoice-detail-value invoice-detail-value-lg">Tiền hàng : <span class="text-danger fw-bold fs-5">{{  number_format($order->sub_total, 0, ',', '.')}} &#8363;</span></div>

                                  
                              </div>
                              <div class="invoice-detail-item">
                                @php
                                if($coupon){
                                    if($coupon->coupon_type ==0){
                                        $text = '%';
                                    }else {
                                        $text = '₫';
                                    }
                                }else $text = '';
                                    
                                    
                                @endphp
                                <div class="invoice-detail-value invoice-detail-value-lg">Mã giảm : <span class="text-danger fw-bold fs-5">{{isset($coupon) ?  $coupon->coupon_min_price : 0 }}{{ $text }}</span></div>
                                
                              </div>
                              <div class="invoice-detail-item">
                                  <div class="invoice-detail-value invoice-detail-value-lg">Tổng tiền giảm : <span class="text-danger fw-bold fs-5">{{isset($coupon) ?  number_format( $order->sub_total - $order->amount, 0, ',', '.') : 0}} &#8363;</span></div>

                                 
                                </div>
                              <hr class="mt-2 mb-2">
                              <div class="invoice-detail-item">
                                  <div class="invoice-detail-value invoice-detail-value-lg">Tổng tiền thanh toán : <span class="text-danger fw-bold fs-5">{{  number_format($order->amount, 0, ',', '.')}} &#8363;</span></div>

                                
                              </div>
                             
                            </div>
                          </div>
                        </div>
                        <hr>
                {{-- Đánh giá đơn hàng --}}
                        @if ($order->order_status == 3)

                            @php
                                $orderReview = \App\Models\OrderReview::where(['user_id'=> Auth::guard('customer')->user()->id, 'order_id' => $order->id])->first();
                                if($orderReview){
                                    $orderRating = $orderReview->star;
                                    $orderReview = $orderReview->review;
                                    $textSubmit = 'Cập nhật';
                                    $textColor = 'info';
                                     
                                    switch($orderRating) {
                                    case 1:
                                        $orderRatingtext = 'Tệ';
                                        $orderRatingtextColor = '#ccc';
                                        break;
                                    case 2:
                                        $orderRatingtext = 'Không hài lòng';
                                        $orderRatingtextColor = 'color:#ccc;';
                                        break;
                                    case 3:
                                        $orderRatingtext = 'Bình thường';
                                        $orderRatingtextColor = 'color:#ccc;';
                                        break;
                                    case 4:
                                        $orderRatingtext = 'Hài lòng';
                                        $orderRatingtextColor = 'color:#ffcc00;';
                                        break;
                                    case 5:
                                        $orderRatingtext = 'Tuyệt vời';
                                        $orderRatingtextColor = 'color:#ffcc00;';
                                        break;
                                }
                                }else {
                                    $orderRating = 5;
                                    $orderReview = '';
                                    $orderRatingtext = 'Tuyệt vời';
                                    $orderRatingtextColor = 'color:#ffcc00;';
                                    $textSubmit = 'Gửi phản hồi';
                                    $textColor = 'success';
                                    
                                }
                            @endphp
                            <div class="order-review">
                                <div class="">
                                    <span style="
                                    color: darkblue;
                                    text-transform: capitalize;
                                ">Gửi phản hồi đơn hàng</span>
                                </div>


                                <form action="{{ route('user.orders.order-review') }}" method="POST">
                                    @csrf
                                   
                                    <ul class="list-inline" style="
                                    display: flex;
                                    align-items: center;
                                    font-size: .875rem;
                                    padding-bottom: 10px;">
                                        <span style="
                                        padding-right: 15px;    font-size: .875rem;
                                        
                                    ">Dịch vụ vận chuyển</span>
                                    <br>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @php
                                                if($i <= $orderRating){
                                                    $colorI = 'color:#ffcc00';
                                                }else{
                                                    $colorI = 'color:#ccc';

                                                }
                                            @endphp
                                           
                                            <li id="{{ $order->id }}-{{ $i }}" data-index_order="{{ $i }}" data-order_id="{{ $order->id }}" data-rating_order="{{ $orderRating }}" class="rating-order"  style="display: inline-block;cursor: pointer; font-size:30px; {{ $colorI }}">&#9733;</li>
                                            
                                        @endfor
                                        <span id="ratingOrderText" style="
                                        padding-left: 10px;
                                        font-size: .875rem;
                                        {{ $orderRatingtextColor }}
                                        font-weight:600;
                                    ">{{ $orderRatingtext }}</span>
    
                                    </ul>
                                    
                                    <div >
                                        <textarea class="form-control" name="review" id="" cols="30" rows="4" placeholder="Để lại đánh giá của bạn về dịch vụ vận chuyển của chúng tôi...">{{ $orderReview }}</textarea>
                                    </div>
    
                                    <input type="hidden" name="user_id" value="{{ Auth::guard('customer')->user()->id }}">
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <input id="starOrderInput" type="hidden" name="star" value="{{ $orderRating }}">
                                    
                                    <br>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button class="btn btn-{{ $textColor }} text-light">{{ $textSubmit }}</button>
                                    </div>
                                </form>
                                

                            </div>
                            
                        @endif

                      <div class="text-md-right">
                        <div class="float-lg-left mb-lg-0 mb-3">
                            @php
                            if($order->order_status  > 0){
                                $temp = 'd-none';
                            }
                                else $temp ='';
                            @endphp
                            <a href="" style="float: right;" class="{{ $temp }} btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Hủy đơn hàng</a>
                            
                        </div>
                      </div>
                    </div>
                </div>
            </div>
                
            
        </div>
       
    </div>
</div>



    @foreach ($orderDetail as $order)
       
    {{-- Form đánh giá sản phẩm --}}
       


        <section class="review_popup_modal">
            <div class="modal fade" id="reviewModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" style="
                        max-width: 700px !important;
                        width: 700px;
                    ">
                    
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                    class="far fa-times"></i></button>
                            <div class="col-12">
                                <h4>Đánh Giá Sản Phẩm</h4>
                                <br>
                                <div class="col-12">
                                    <div class="row item-review" >
                                        <div class="col-3">
                                            <img width='80px' height='80px' src="{{ asset($order->product->image) }}"> </img>
                                        </div>
                                        <div class="col-9">
                                            <div class="">
                                                <a href="{{ route('product-detail', $order->product->slug) }}" target="_blank" rel="noopener noreferrer"><span style="font-size: 14px; color: black;">{{ $order->product->name }}</span></a>
                                                
                                            </div>
                                            <div style="font-size: 14px; "><span>Phân loại hàng: {{ $order->color->name }}</span></div>
                                            
                                        </div>
                                    </div>
                                </div> 
                                <hr>
                                
                                <form action="{{ route('user.orders.product-review') }}" method="POST">
                                    @csrf
                                    <ul class="list-inline" style="
                                     display: flex;
                                        align-items: center;
                                        font-size: .875rem;
                                        padding-bottom: 10px;">
                                            <span style="
                                            padding-right: 15px;    font-size: .875rem;
                                            
                                        ">Chất lượng sản phẩm</span>
                                        <br>
                                        @for ($i = 1; $i <= 5; $i++)
                                           
                                            <li id="{{ $order->product_id }}-{{ $i }}" data-index_pd="{{ $i }}" data-product_id="{{ $order->product_id }}" data-rating="5" class="ratingProduct ratingProduct-{{ $order->product_id }}"  style="display: inline-block;cursor: pointer; font-size:30px;color:#ffcc00;">&#9733;</li>
                                            
                                        @endfor
                                        

                                        <span id="ratingProductText" style="
                                            padding-left: 10px;
                                            font-size: .875rem;
                                            color:#ffcc00;
                                            font-weight:600;
                                        ">Tuyệt vời</span>
                                    </ul>

                                    <div >
                                        <textarea class="form-control" name="review" id="" cols="30" rows="4" placeholder="Để lại đánh giá của bạn về sản phẩm này..."></textarea>
                                    </div>

                                    <input type="hidden" name="user_id" value="{{ Auth::guard('customer')->user()->id }}">
                                    <input type="hidden" name="product_id" value="{{ $order->product_id }}">
                                    <input type="hidden" name="color_id" value="{{ $order->color_id }}">
                                    <input type="hidden" name="order_id" value="{{ $order->order_id }}">

                                   
                                    <input id="starProductInput-{{ $order->product_id}}" type="hidden" name="star" value="5">

                                    <br>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success text-light">Gửi đánh giá</button>
                                    </div>
                                        
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @endforeach
    {{-- Form Xem lại và cập nhật đánh giá sản phẩm --}}
 

        

   

    
@foreach($orderDetail as $order)
<section class="review_popup_modal">
    <div class="modal fade" id="viewModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" style="
        max-width: 700px !important;
        width: 700px;
    ">
            
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="far fa-times"></i></button>
                    <div class="col-12">
                        <h4>Đánh Giá Shop</h4>
                        <br>
                        <div class="col-12">
                        <div class="row item-review" >
                            <div class="col-2">
                                <img width='56px' height='56px' src="{{ asset($order->product->image) }}"> </img>
                            </div>
                            <div class="col-8">
                                <div class="">
                                    <a href="{{ route('product-detail', $order->product->slug) }}" target="_blank" rel="noopener noreferrer"><span style="font-size: 14px; color: black;">{{ $order->product->name }}</span></a>
                                    
                                </div>
                                <div ><span style="font-size: 14px; ">Phân loại hàng: {{ $order->color->name }}</span></div>
                                
                            </div>
                            <div class="col-2">
                                <a href="" class="btn " data-bs-toggle="modal" data-bs-target="#reviewModal-{{ $order->id }}">Sửa</a>
                            </div>
                        </div>
                        </div> 
                        <hr>
                        @if($order->status == 1 )
                        <div class="row" style="
                        padding-left: 10px;
                    ">
                            <div class="col-2">
                                <img width='56px' height='56px' src="{{ Auth::guard('customer')->user()->image ? asset( Auth::guard('customer')->user()->image) : asset('uploads/default.png') }}"> </img>
                            </div>
                            <div class="col-10">
                                <div class="">
                                <span style="font-size: 14px; color: black;">{{ Auth::guard('customer')->user()->name }}</span>
                                    
                                </div>
                                <div >
                                    <ul class="list-inline" style="
                                    display: flex;
                                    align-items: center;
                                    font-size: .875rem;
                                    ">
                                    
                                    <br>
                                        @for ($i = 1; $i <= 5; $i++)
                                        
                                        @php
                                            $colorStar = \App\Models\ProductReview::where(['user_id'=> Auth::guard('customer')->user()->id, 'order_id' => $order->order_id, 'product_id' => $order->product_id, 'color_id' => $order->color_id])->first();

                                            if($colorStar){
                                                    $orderRating = $colorStar->star;
                                                
                                                    
                                                    switch($orderRating) {
                                                    case 1:
                                                        $orderRatingtext = 'Tệ';
                                                        $orderRatingtextColor = 'color:#ccc;';
                                                        break;
                                                    case 2:
                                                        $orderRatingtext = 'Không hài lòng';
                                                        $orderRatingtextColor = 'color:#ccc;';
                                                        break;
                                                    case 3:
                                                        $orderRatingtext = 'Bình thường';
                                                        $orderRatingtextColor = 'color:#ccc;';
                                                        break;
                                                    case 4:
                                                        $orderRatingtext = 'Hài lòng';
                                                        $orderRatingtextColor = 'color:#ffcc00;';
                                                        break;
                                                    case 5:
                                                        $orderRatingtext = 'Tuyệt vời';
                                                        $orderRatingtextColor = 'color:#ffcc00;';
                                                        break;
                                                }
                                                }else {
                                                    
                                                    $orderRatingtext = 'Tuyệt vời';
                                                    $orderRatingtextColor = 'color:#ffcc00;';
                                                    
                                                }
                                            if($colorStar){
                                                if($i <= $colorStar->star){
                                                    $colorIcon = 'color:#ffcc00;';
                                                }else{
                                                    $colorIcon = 'color:#ccc;';

                                                }
                                            }else $colorIcon = 'color:#ccc;';
                                        @endphp
                                            <li  style="display: inline-block;cursor: pointer; font-size:16px; {{ $colorIcon }}">&#9733;</li>
                                            
                                        @endfor
                                        <span  style="
                                        padding-left: 10px;
                                        font-size: .875rem;
                                        {{  $orderRatingtextColor }}
                                        font-weight:600;
                                    ">{{ $orderRatingtext }}</span>

                                    </ul>
                                </div>
                                @php
                                    $date = \App\Models\ProductReview::where(['user_id'=> Auth::guard('customer')->user()->id, 'order_id' => $order->order_id, 'product_id' => $order->product_id, 'color_id' => $order->color_id])->first();
                                    if ($date) {
                                        $formattedDate = $date->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('H:i:s d-m-Y');
                                    } else {
                                        $formattedDate = null; 
                                    }
                                    if($date->review != ''){
                                        $dn = '';
                                        $t = $date->review;
                                    } 
                                    else{
                                        $dn = 'd-none';
                                        $t = '';
                                    } 
                                @endphp
                                <div class="{{ $dn }}">
                                    <span style="
                                    padding-right: 15px;
                                    color: #ccc;
                                    font-size: .875rem;
                                    
                                ">Chất lượng sản phẩm: <span style="color: #000; font-size: .875rem;">{{ $t }}</span></span>
                                </div>

                                <div class="">
                                
                                    <span style="
                                    font-size: .875rem;
                                ">{{ $formattedDate }}</span>
                                </div>
                                
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endforeach()

@endsection

@push('scripts')
    



<script>

// document.addEventListener("DOMContentLoaded", function() {
//     var order_stars = document.querySelectorAll('.ratingProduct-' + this.getAttribute('data-product_id'))
    
//     order_stars.forEach(function(order_star) {
//         order_star.addEventListener('click', function() {
//             var clickedIndex = parseInt(this.getAttribute('data-index_pd'));

           
//             let x = 5;
//             for (let i = 1; i < 6; i++) {
//                 if ((i-1) < clickedIndex) {
//                     // Sử dụng id của mỗi phần tử sao để thay đổi màu sắc
//                     document.getElementById(order_stars[x].id).style.color = '#ffcc00'; 
//                 } else {
//                     document.getElementById(order_stars[x].id).style.color = '#ccc'; 
//                 }
//                 console.log(order_stars[x].id);
//                 x++;
//             }

//             var starInputId = 'starProductInput-' + this.getAttribute('data-product_id');
//             document.getElementById(starInputId).value = clickedIndex;

            
//         });
//     });
// });

document.addEventListener("DOMContentLoaded", function() {
    var order_stars = document.querySelectorAll('.ratingProduct');

    order_stars.forEach(function(order_star) {
        order_star.addEventListener('click', function() {
            var clickedIndex = parseInt(this.getAttribute('data-index_pd'));
            var productId = this.getAttribute('data-product_id');
            var starInputId = 'starProductInput-' + productId;
            
            // Thay đổi màu sắc của các sao trước và bao gồm sao được nhấp vào
            var stars = document.querySelectorAll('.ratingProduct-' + productId);
            stars.forEach(function(star, index) {
                if (star.getAttribute('data-product_id') === productId) {
                    if (index < clickedIndex) {
                        star.style.color = '#ffcc00'; 
                    } else {
                        star.style.color = '#ccc'; 
                    }
                }
            });

            // Cập nhật giá trị của ô input ẩn
            document.getElementById(starInputId).value = clickedIndex;
        });
    });
});



    document.addEventListener("DOMContentLoaded", function() {
        var order_stars = document.querySelectorAll('.rating-order');

        order_stars.forEach(function(order_star) {
            order_star.addEventListener('click', function() {
                var clickedIndex = parseInt(this.getAttribute('data-index_order'));

                order_stars.forEach(function(s, index) {
                    if (index < clickedIndex) {
                        s.style.color = '#ffcc00'; // Màu vàng cho các ngôi sao được click và các ngôi sao phía trước
                    } else {
                        s.style.color = '#ccc'; // Màu xám cho các ngôi sao phía sau
                    }
                });

                switch(clickedIndex) {
                    case 1:
                        ratingOrderText.textContent = 'Tệ';
                        ratingOrderText.style.color = '#ccc';
                        break;
                    case 2:
                        ratingOrderText.textContent = 'Không hài lòng';
                        ratingOrderText.style.color = '#ccc';
                        break;
                    case 3:
                        ratingOrderText.textContent = 'Bình thường';
                        ratingOrderText.style.color = '#ccc';
                        break;
                    case 4:
                        ratingOrderText.textContent = 'Hài lòng';
                        ratingOrderText.style.color = '#ffcc00';
                        break;
                    case 5:
                        ratingOrderText.textContent = 'Tuyệt vời';
                        ratingOrderText.style.color = '#ffcc00';
                        break;
                }

                starOrderInput.value = clickedIndex;

            });
        });
    });
</script>
    
@endpush
