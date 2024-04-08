@extends('admin.layouts.master')

@section('content')
@php
    $providers = App\Models\Provider::all();
    $products = App\Models\Product::all();
    $colors = App\Models\Color::all();
    $sl = App\Models\ReceiptDetail::sum('quantity');
    $tong = \App\Models\ReceiptDetail::sum(\DB::raw('price * quantity'));
    $total = number_format( $tong, 0, ',', '.')
    
@endphp
<section class="section">
    <div class="section-header">
      <h1>Nhập Kho</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.receipt.index') }}">Phiếu Nhập Kho</a></div>
        <div class="breadcrumb-item">Thêm</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12 ">
            <div class="row">
                
                <div class="col-8">
                    <div class="card  receipt-card">
                        <form action="{{ route('admin.receipt.store') }}" method="POST" >
                            @csrf
                        <div class="card-header ">
                            <h4>Phiếu Nhập Kho</h4>
                            <span class="sub-header">
                                @php
                                    $ngay_hien_tai = date('d-m-Y');
                                @endphp
                                Ngày nhập: {{ $ngay_hien_tai }}
                            </span>
                        </div>
                        
                        
                            <div class=" card-body receipt-content ">
                                <div class="row " >
                                    <div class="form-group  col-6">
                                        <label >Người nhập kho: </label>
                                            <input type="text" class="form-control" name="user_id" id="inputEmail3" value="{{ Auth::guard('admin')->user()->name }}" disabled>
                                        
                                    </div>
                                    <div class="form-group  col-6">
                                        <label >Tên đơn vị cung cấp: </label>
                                        
                                            <select class="form-control selectric" name="provider_id" >
                                                <option value="">----- Chọn Nhà Cung Cấp ----- </option>
                                                @foreach ($providers as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        
                                    </div>
                                </div>
                                <div class="form-group  ">
                                    <label >Ghi chú: </label>
                                    <input type="text" class="form-control" name="note" id="inputEmail3"  placeholder="Lí do nhập kho">
                                    
                                </div>
                                <hr>
                                <div class="receipt-tb">
                                    {{ $dataTable->table() }}

                                </div>
                                <div class="text-footer mb-3 mt-2 justify-content-end d-flex">
                                    <span>Tổng số lượng: {{ $sl }}<b></b> </span>
                                </div>
                                <div class="text-footer mb-3 mt-2 justify-content-end d-flex">
                                    <span>Tổng tiền: <b>{{ $total }}&#8363;</b> </span>
                                </div>
                                    
                                <div class="d-flex receipt-btn ">
                                    <button type="submit" class="btn btn-primary"><b><i class="icon-size bx bx-file-blank mr-2"></i>TẠO PHIẾU</b></button>
                                    <a href="{{ route('admin.receipt-detail-delete-all') }}" class="text-danger delete-item">Xóa tất cả</a>
                                </div>
                            
                            </div>
                        </form>
                        
                    </div>
                </div>
           
                <div class="col-4">
                    <div class="card col-12">
                        <div class="card-header">
                            <h4>Sản Phẩm Nhập</h4>
                            </div>
                        <form action="{{ route('admin.receipt-detail.store') }}" method="POST" >
                            @csrf
                                <div class="form-group ">
                                    <label>Sản phẩm<span class="text-danger">(*)</span></label>
                                    <select class="form-control select2 main-product" name="product_id">
                                        <option value="">----- Chọn Sản Phẩm ----- </option>
                                        @foreach ($products as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label>Màu sắc<span class="text-danger">(*)</span></label>
                                    <select class="form-control select2 sub-product" name="color_id">
                                        <option value="">----- Chọn Màu Sắc ----- </option>
                                        
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label for="">Giá nhập<span class="text-danger">(*)</span></label>
                                    <input type="number" min="0" class="form-control" name="price" placeholder="Nhập giá bán ra">
                            
                                </div>
                                <div class="form-group ">
                                    <label for="">Số lượng<span class="text-danger">(*)</span></label>
                                    <input type="number" min="0" class="form-control" name="quantity" placeholder="Nhập số lượng hàng">
                            
                                </div>
                            
                            <div class="d-flex justify-content-center mb-3">
                                <button type="submit" class="btn btn-primary"><b><i class="icon-size bx bx-file-blank mr-2"></i>THÊM</b></button>
        
                            </div>
        
                        </form>
                    </div>
                </div>
            </div>
                
                
        </div>
          
    </div>
      
    </div>
  </section>
@endsection

@push('scripts')
{{ $dataTable->scripts(attributes: ['type'=>'module']) }}
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
    </script>
    
@endpush