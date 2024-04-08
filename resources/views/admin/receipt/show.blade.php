@extends('admin.layouts.master')

@section('content')
@php
    $receiptProduct = App\Models\ReceiptProduct::where('receipt_id', $receipt->id)->get();
    $user = App\Models\User::where('id', $receipt->user_id)->first();
    $provider = App\Models\Provider::where('id', $receipt->provider_id)->first();
        
    // $providers = App\Models\Provider::all();
    // $products = App\Models\Product::all();
    // $colors = App\Models\Color::all();

    $sl = App\Models\ReceiptProduct::where('receipt_id', $receipt->id)->sum('quantity');

    $date = Carbon\Carbon::parse($receipt->input_date)->format('d-m-y H:i:s');
    
@endphp
<section class="section">
    <div class="section-header">
      <h1>Nhập Kho</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.receipt.index') }}">Phiếu Nhập Kho</a></div>
        <div class="breadcrumb-item">Chi Tiết Phiếu Nhập</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-10 col-md-10 col-lg-10 ">
           
            <div class="card  receipt-card">
                <div class="card-header ">
                    <h4>Phiếu Nhập Kho</h4>
                    <span class="sub-header">
                        Mã phiếu: {{ $receipt->id }}
                    </span>
                    <span class="sub-header">
                        Ngày nhập: {{ $date }}
                    </span>
                    
                </div>
                
                
                <div class=" card-body receipt-content ">
                    <div class="row " >
                        <div class="form-group  col-6">
                            <span > <b>Người nhập kho: </b>{{ $user->name }}</span>
                                
                        </div>
                        <div class="form-group  col-6">
                            <span > <b>Tên đơn vị cung cấp: </b>{{ $provider->name }}</span>
                          
                            
                        </div>
                    </div>
                    <div class="form-group  ">
                        <span > <b>Ghi chú: </b>{{ $receipt->note }}</span>

                        
                    </div>
                    <hr>
                    <div class="receipt-tb">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên Sản Phẩm</th>
                                <th scope="col">Màu Sắc</th>
                                <th scope="col">Số Lượng</th>
                                <th scope="col">Đơn Giá</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($receiptProduct as $item)
                              <tr>
                                
                                    <th scope="row">{{ $item->product_id }}</th>
                                    <td>
                                        @php
                                            $text = App\Models\Product::where('id', $item->product_id)->first();
                                            $name = $text->name;
                                        @endphp
                                        {{ $name }}
                                    </td>
                                    <td>
                                        @php
                                            $text = App\Models\Color::where('id', $item->color_id)->first();
                                            $color = $text->name;
                                        @endphp
                                        {{ $color }}
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td><b>{{number_format($item->price, 0, ',', '.') }}&#8363;</b></td>

                              </tr>
                              @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="text-footer mb-3 mt-2 justify-content-end d-flex">
                        <span>Tổng số lượng: <b>{{ $sl }}</b> </span>
                    </div>
                    <div class="text-footer mb-3 mt-2 justify-content-end d-flex">
                        <span>Tổng tiền: <b >{{number_format($receipt->total, 0, ',', '.') }}&#8363;</b> </span>
                    </div>
                </div>
                
                
            </div>  
                
        </div>
          
        </div>
      
    </div>
  </section>
@endsection

@push('scripts')
{{-- {{ $dataTable->scripts(attributes: ['type'=>'module']) }}
    <script>
        $(document).ready(function(){
            $('body').on('change', '.main-product', function(){
                let id = $(this).val();
                $.ajax({
                    method: 'GET',
                    url: '{{ route('admin.get-providers') }}',
                    data: {
                        id: id
                    },
                    success: function(data){
                        console.log(data);
                        $('.sub-product').html(`<option value="">----- Chọn Màu Sắc -----</option>`);

                        $.each(data, function(i, item){

                            $('.sub-product').append(`<option value="${item.color.id}">${item.color.name}</option>`);
                        });

                    },
                    error: function(xrr, status, error){
                        console.log(error);
                    }
                })
            })
        })
    </script> --}}
    
@endpush