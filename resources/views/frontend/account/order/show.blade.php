@php
    $address = json_decode($order->order_address);
    $email = \App\Models\User::where('id', $address->user_id)->first();

    $city = \App\Models\City::where('id', $address->city_id)->first();
    $district = \App\Models\District::where('id', $address->district_id)->first();
    $ward = \App\Models\Ward::where('id', $address->ward_id)->first();
    
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
                                }else if($order->order_status == 2){
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
                              <tr class="head">
                                <th data-width="40">#</th>
                                <th class="text-center">Hình ảnh</th>

                                <th>Tên sản phẩm</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-right">Đơn giá</th>
                                <th class="text-right">Thành tiền</th>
                              </tr>
                              <tr>
                                  @php $count = 0; @endphp
                                  @foreach ($orderDetail as $item)
                                      <td>{{ ++$count}}</td>
                                      <td class="text-center"><img width='80px' height='80px' src="{{ asset($item->product->image) }}"> </img></td>
                                      <td><a href="{{ route('product-detail', $item->product->slug ) }}" target="_blank" rel="noopener noreferrer">{{ $item->product_name }}</a></td>
                                      <td class="text-center">{{ $item->qty }}</td>
                                      <td class="text-right"> {{  number_format($item->unit_price, 0, ',', '.')}} &#8363;</td>
                                      <td class="text-right"> {{  number_format($item->qty * $item->unit_price , 0, ',', '.')}} &#8363;</td>
                             
                                  @endforeach


                                
                              </tr>
                              
                            
                            </table>
                          </div>
                          <div class="row mt-4">
                            <div class="col-lg-7">
                              <div class="section-title">Phương thức thanh toán</div>
                              <b class="section-lead text-info">Thanh toán bằng {{ $order->payment_method }}</b>
                              
                            </div>
                            <div class="col-lg-5 ">
                              <div class="invoice-detail-item">
                                  <div class="invoice-detail-value invoice-detail-value-lg">Tiền hàng : <span class="text-danger fw-bold fs-5">{{  number_format($order->amount, 0, ',', '.')}} &#8363;</span></div>

                                  
                              </div>
                              <div class="invoice-detail-item">
                                <div class="invoice-detail-value invoice-detail-value-lg">Mã giảm : <span class="text-danger fw-bold fs-5">15%</span></div>
                                
                              </div>
                              <div class="invoice-detail-item">
                                  <div class="invoice-detail-value invoice-detail-value-lg">Tổng tiền giảm : <span class="text-danger fw-bold fs-5">15</span></div>

                                 
                                </div>
                              <hr class="mt-2 mb-2">
                              <div class="invoice-detail-item">
                                  <div class="invoice-detail-value invoice-detail-value-lg">Tổng tiền thanh toán : <span class="text-danger fw-bold fs-5">{{  number_format($order->amount, 0, ',', '.')}} &#8363;</span></div>

                                
                              </div>
                              {{-- <div class="invoice-detail-value invoice-detail-value-lg">Phương thức thanh toán : <span class="text-danger fw-bold fs-5">Thanh toán khi nhận hàng</span></div> --}}

                            </div>
                          </div>
                        </div>
                        <hr>
                      <div class="text-md-right">
                        <div class="float-lg-left mb-lg-0 mb-3">
                            @php
                            if($order->order_status  >0){
                                $temp = 'd-none';
                            }
                                else $temp ='';
                            @endphp
                            {{-- @if($order->order_status == 0)
                             @endif --}}
                        <a href="" style="float: right;" class="{{ $temp }} btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Hủy đơn hàng</a>
                            
                        </div>
                      </div>
                      </div>
                </div>
            </div>
                
            
        </div>
       
    </div>
</div>

@endsection

