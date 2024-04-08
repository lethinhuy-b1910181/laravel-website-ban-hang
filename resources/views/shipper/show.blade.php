@php
    $address = json_decode($order->order_address);
    $email = \App\Models\User::where('id', $address->user_id)->first();

    $city = \App\Models\City::where('id', $address->city_id)->first();
    $district = \App\Models\District::where('id', $address->district_id)->first();
    $ward = \App\Models\Ward::where('id', $address->ward_id)->first();
    $shippers = \App\Models\Shipper::where('status', 1)->get();
@endphp

@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header">
      <h1>Đơn Hàng</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('shipper.shipper.index') }}">Đơn hàng</a></div>
        <div class="breadcrumb-item">Chi tiết đơn hàng</div>
      </div>
    </div>

    <div class="section-body " >
      
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Chi tiết đơn hàng</h4>
            </div>
            <div class="card-body">
                <div class="section-body">
                    <div class="invoice">

                      <div class="invoice-print">
                        <div class="row col-12">
                          <address>
                            <strong>Trạng thái đơn hàng: <span class="text-danger">
                              @if ($order->order_status == 0)
                                  Đang chờ duyệt
                              @elseif($order->order_status == 1 && $order->shipper_status == 0)
                                  Đơn hàng đã được duyệt và Đang chuyển giao cho Shipper
                              @elseif($order->order_status == 1 && $order->shipper_status == 1)
                                  Shipper đã nhận đơn và đang chuẩn bị giao hàng
                              @elseif($order->order_status == 2)
                                  Đang giao hàng
                              @elseif($order->order_status == 3)
                                  Giao hàng thành công
                              @elseif($order->order_status == 4)
                                  Đơn hàng bị hủy
                              @endif
                          </span></strong>
                          </address>
                        </div>
                        <div class="row">
                          <div class="col-5">
                            <address>
                              <strong>Ngày đặt hàng: <span class="text-dark">{{date('d-m-Y ' , strtotime($address->created_at)) }}</span></strong><br>
                            </address>
                          </div>
                          <div class="col-5">
                          <address>
                              <strong>Trạng thái thanh toán: <span class="text-info">
                                        @if ($order->payment_method == 'VNPay')
                                            Đã thanh toán
                                        @elseif($order->order_status == 3)
                                            Đã thanh toán
                                        @else
                                            Chưa thanh toán
                                        @endif
                                      </span></strong>
                            </address>
                          </div>
                          <div class="col-4">
                            
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          
                          <div class="col-lg-12">
                            <div class="row">
                              <div class="col-md-7">
                                <address>
                                  <strong>Thông tin khách hàng:</strong><br>
                                    Họ và tên: <b>{{ $address->name }}</b> <br>
                                    Số điện thoại: <b>{{ $address->phone }}</b><br>
                                    Email: <b>{{ $email->email }}</b><br>
                                    
                                    Địa chỉ giao hàng: <b>{{ $address->address }},  {{ $ward->name }}, {{ $district->name }}, {{ $city->name }}.</b>
                                </address>
                              </div>

                              <div class="col-md-5 ">
                                <address style="text-align: right" >
                                  <strong>Thông tin người giao hàng:</strong>
                                  <br>
                                  @if ($order->shipper_status == 0)
                                      <b class="text-warning">*****Chưa cập nhật****</b>
                                  @elseif($order->shipper_status==1)
                                  @php
                                      $ship = App\Models\Shipper::where('id', $order->shipper_id)->first();
                                  @endphp
                                    Họ và tên: <b>{{ $ship->name }}</b> <br>
                                    Số điện thoại: <b>{{ $ship->phone }}</b><br>
                                    Email: <b>{{ $ship->email }}</b>
                                  @endif
                                  <br>
                                    
                                </address>
                              </div>
                              
                            </div>
                            
                          </div>
                        </div>
                        
                        <div class="row ">
                          <div class="col-md-12">
                            <div class="section-title">Danh sách sản phẩm của đơn hàng</div>
                            <div class="table-responsive">
                              <table class="table table-striped table-hover table-md">
                                <tr>
                                  <th data-width="40">#</th>
                                  <th class="text-center">Hình ảnh</th>

                                  <th>Tên sản phẩm</th>
                                  <th class="text-center">Số lượng</th>
                                  <th class="text-right">Đơn giá</th>
                                  <th class="text-right">Thành tiền</th>
                                </tr>
                                @php $count = 0; @endphp
                                @foreach ($orderDetail as $item)
                                <tr>
                                   
                                        <td>{{ ++$count}}</td>
                                        <td class="text-center"><img width='80px' height='80px' src="{{ asset($item->product->image) }}"> </img></td>
                                        <td>{{ $item->product_name }}</td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="text-right"> {{  number_format($item->unit_price, 0, ',', '.')}} &#8363;</td>
                                        <td class="text-right"> {{  number_format($item->qty * $item->unit_price , 0, ',', '.')}} &#8363;</td>
                              
                                  
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
                                    <div class="invoice-detail-value invoice-detail-value-lg">Tiền hàng : <span class="text-danger text-bold fs-3">{{  number_format($order->amount, 0, ',', '.')}} &#8363;</span></div>

                                    
                                </div>
                                <div class="invoice-detail-item">
                                  <div class="invoice-detail-value invoice-detail-value-lg">Mã giảm : <span class="text-danger text-bold fs-3">15%</span></div>
                                  
                                </div>
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-value invoice-detail-value-lg">Tổng tiền giảm : <span class="text-danger text-bold fs-3">15</span></div>

                                   
                                  </div>
                                <hr class="mt-2 mb-2">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-value invoice-detail-value-lg">Tổng tiền thanh toán : <span class="text-danger text-bold fs-3">{{  number_format($order->amount, 0, ',', '.')}} &#8363;</span></div>
                                  
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                      @if ($order->shipper_status == 0)
                      <form  action="{{ route('shipper.chang-status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="text-md-right ml-3 ">
                          <div class="float-lg-right  ">
                            <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Từ chối</button>

                          </div>
                            
                            <div class="float-lg-right mb-lg-0 mb-3 ml-2 mr-2 ">
                              <button data-id="{{ $order->id }}" onclick="return confirm('Bạn có chắc chắn muốn duyệt đơn hàng không?')"  class=" shipper-confirm-submit  btn btn-info btn-icon icon-left" type="submit" ><i class="fas fa-check"></i> Nhận đơn</button>
                                
                            </div>

                        </div>
                     </form>
                      @else
                      <form  action="{{ route('shipper.chang-status-2', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="text-md-right ml-3 ">
                          <div class="float-lg-right  ">
                            <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Thất bại</button>

                          </div>
                            
                            <div class="float-lg-right mb-lg-0 mb-3 ml-2 mr-2 ">
                              <button  class="  btn btn-info btn-icon icon-left" type="submit" ><i class="fas fa-check"></i> Hoàn thành</button>
                                
                            </div>

                        </div>
                     </form>
                      @endif
                        
                     
                    </div>
                  </div>
            </div>
            
          </div>
        </div>
      </div>
      
    </div>
  </section>
    
@endsection

@push('scripts')

{{-- <script>
  $(document).ready(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $('.shipper-confirm-submit').on('submit', function(e){
          e.preventDefault();
          let formData = $(this).serialize();
          let id = $(this).data('id');
          console.log(formData);
          $.ajax({
              method: 'POST',
              data: formData,
              url: "{{ route('shipper.chang-status','') }}/" + id,
              success: function(data){
                  if(data.status === 'success'){
                      getCartCount();
                      // fetchSidebarCartProducts();
                      toastr.success(data.message);
                  }else if(data.status === 'error'){
                      toastr.error(data.message);

                  }
              },
              error: function(data){

              },
          });
      });

      function getCartCount(){
          $.ajax({
              method: 'GET',
              url: "{{ route('admin.order.order-count') }}",
              success: function(data){
                  $('#order-count').text(data);
              },
              error: function(data){

              },
          });
      }
      
  });
</script> --}}

@endpush