@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Mã Giảm Giá</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.coupon.index') }}">Mã Giảm Giá</a></div>
        <div class="breadcrumb-item">Gửi Mã Giảm Giá</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Gửi Mã Giảm Giá Đến Khách Hàng</h4>
            </div>
            <div class="card-body">
               
                <form action="{{ route('admin.coupon.send.mail') }}"  method="get">
                    @csrf
                    <input type="hidden" name="coupon_id" value="{{ $coupon->id }}">
                    <div class="row">
                      <div class="form-group col-6 d-flex" >
                        <span style="
                                width: 160px;
                                align-items: center;
                                display: flex;
                                font-weight: 600;
                                color: #103679;
                            ">Loại gửi<span class="text-danger">(*):</span></span>
                        <select name="type"  class="form-control select2" id="send-type">
                            <option value="4">Cá nhân</option>
                            <option value="1">Toàn bộ</option>
                            <option value="2">Khách Vip</option>
                            <option value="3">Khách Thường</option>
                            
                        </select>
                      </div>

                      <div class="col-2 mt-1 btn-all-gui d-none">
                        <button type="submit" class="btn btn-info"><i class="fas fa-paper-plane"></i><b> Gửi</b></button>
                      </div>
                    </div>
                    
                    <div class=" row  input-email-customer ">
                      <div class="form-group col-10 d-flex" >
                        <span style="
                                width: 150px;
                                align-items: center;
                                display:flex;
                                font-weight: 600;
                                color: #103679;
                            ">Chọn tài khoản gửi<span class="text-danger">(*):</span></span>
                        <select class="form-control select2" multiple="" name='customer_email[]'>
                          @foreach ($customers as $customer)
                            <option value="{{ $customer->email }}" >
                              {{ $customer->email }}
                          </option>
                              
                          @endforeach
                        </select>
                      </div>
                      <div class="col-2 mt-1 btn-gui">
                        <button type="submit" class="btn btn-info"><i class="fas fa-paper-plane"></i><b> Gửi</b></button>
                      </div>
                    </div>
                    
                    
                   
                </form>


                    @php
                        if($coupon->type == 0) {
                            $c = 'Giảm theo phần trăm';
                            $v = '%';
                        }
                        else {
                            $c = 'Giảm theo giá tiền';
                            $v = '₫';
                        }
                    @endphp
                
                    <div class="coupon row">
                        <div class="coupon-title col-12"><h4>Thông tin mã giảm giá - {{ $coupon->code }}</h4></div>
                        <div class=" row col-12">
                            <div class="coupon-content__left col-6">
                                <p class="coupon-content__title">Tên Mã giảm giá: <span> {{ $coupon->name }}</span></p>
                                <p class="coupon-content__title">Số lượng mã: <span> {{ $coupon->value }}</span></p>
                                <p class="coupon-content__title">Đơn tối hiểu: <span class="text-danger font-weight-bold"> {{number_format($coupon->min_order, 0, ',', '.') }}&#8363;</span></p>
                                <p class="coupon-content__title">Ngày bắt đầu: <span > {{ \Carbon\Carbon::parse($coupon->start_date)->format('d-m-Y') }}</span></p>
                            </div>
                            <div class="coupon-content__right col-6">
                                <p class="coupon-content__title">Loại giảm giá: <span> {{ $c }}</span></p>
                                @if($coupon->type == 0)
                                   
                                <p class="coupon-content__title">Giá trị giảm: <span> {{ $coupon->min_price }}{{ $v }}</span></p>
                                @else
                                <p class="coupon-content__title">Giá trị giảm: <span> {{number_format($coupon->min_price , 0, ',', '.') }}&#8363;</span></p>
                                @endif
                                <p class="coupon-content__title">Giảm tối đa: <span class="text-danger font-weight-bold"> {{number_format($coupon->max_price, 0, ',', '.') }}&#8363; </span></p>
                                <p class="coupon-content__title">Ngày Kết thúc: <span> {{ \Carbon\Carbon::parse($coupon->end_date)->format('d-m-Y') }}</span></p>
                            </div>
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

<script>
  $(document).ready(function () {
    $('#send-type').on('change', function () {
        var selectedOption = $(this).val();
        // Kiểm tra nếu lựa chọn là "Cá nhân" (value=4) thì hiển thị div.input-email-customer
        if (selectedOption === '4') {
            $('.input-email-customer').removeClass('d-none');
            $('.btn-all-gui').addClass('d-none');
            $('.btn-gui').removeClass('d-none');
            
        } else {
            // Nếu không, ẩn div.input-email-customer đi
            $('.input-email-customer').addClass('d-none');
            $('.btn-all-gui').removeClass('d-none');
            $('.btn-gui').addClass('d-none');
        }
    });
});
</script>

@endpush