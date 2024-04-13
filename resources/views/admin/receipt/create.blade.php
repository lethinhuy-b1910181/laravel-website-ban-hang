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
                <div class="col-4">
                    <div class="card col-12">
                        <div class="card-header">
                            <h4>Sản Phẩm Nhập</h4>
                            </div>
                        <form action="{{ route('admin.receipt-detail.store') }}" method="POST" id="addReceiptDetailForm" >
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
                                    <input type="number" min="0" class="form-control" name="price" placeholder="Nhập giá nhập kho">
                            
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
                                                
                                                {{-- <option value="{{ $item->id }}" @if(request()->provider_id == $item->id) selected @endif>{{ $item->name }}</option> --}}

        
                                                <option value="{{ $item->id }}" @if(old('provider_id') == $item->id) selected @endif>{{ $item->name }}</option>
                                                    {{-- <option value="{{ $item->id }}">{{ $item->name }}</option> --}}
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
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-md" id="product-table">
                                            <thead style="text-align: center;">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Màu sắc</th>
                                                    <th>Số lượng</th>
                                                    <th>Đơn giá</th>
                                                    <th>Xóa</th>
                                                </tr>
                                            </thead>
                                                <tbody>
                                                    <!-- Thông tin sản phẩm sẽ được hiển thị ở đây -->
                                                    <!-- Kiểm tra xem $receiptDetails có dữ liệu hay không -->
                                                @php
                                                    $receiptDetails = \App\Models\ReceiptDetail::get();
                                                @endphp
                                                    @if(isset($receiptDetails) && $receiptDetails->count() > 0)
                                                    @foreach ($receiptDetails as $receiptDetail)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $receiptDetail->product->name }}</td>
                                                        <td>{{ $receiptDetail->color->name }}</td>
                                                        <td>{{ $receiptDetail->quantity }}</td>
                                                        <td class="font-weight-bold">{{ number_format( $receiptDetail->price, 0, ',', '.') }}₫</td>
                                                        <td><a href="{{ route('admin.receipt-detail.destroy', $receiptDetail->id) }}" class="btn btn-danger item-delete" data-id="{{ $receiptDetail->id }}">Xóa</a></td>
                                                    </tr>
                                                    @endforeach
                                                   
                                                    @endif
                                                    
                                                    
                                                </tbody>
                                        </table>
                                    </div>

                                    {{-- {{ $dataTable->table() }} --}}
                                </div>
                                <div class="text-footer mb-3 mt-2 justify-content-end d-flex">
                                    <span>Tổng số lượng: <b id="totalQuantity">{{ $sl }}</b> </span>
                                </div>
                                <div class="text-footer mb-3 mt-2 justify-content-end d-flex">
                                    <span >Tổng tiền: <b class="text-danger" id="totalAmount">{{ $total }}&#8363;</b> </span>
                                </div>
                                
                                    
                                <div class="d-flex receipt-btn ">
                                    <button type="submit" class="btn btn-primary"><b><i class="icon-size bx bx-file-blank mr-2"></i>TẠO PHIẾU</b></button>
                                    <a href="{{ route('admin.receipt-detail-delete-all') }}" class="text-danger delete-item" >Xóa tất cả</a>
                                </div>
                            
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
{{-- {{ $dataTable->scripts(attributes: ['type'=>'module']) }} --}}
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
                });
            });

            

        
       
        });


        document.addEventListener('DOMContentLoaded', function () {
        // Lắng nghe sự kiện click của nút thêm dữ liệu
        document.querySelector('#addReceiptDetailForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của form

            // Lấy dữ liệu từ form
            var formData = new FormData(this);

            // Gửi AJAX request
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Nếu request thành công, cập nhật bảng
                if (data.success) {
                    var newRow = `
                        <tr>
                            <td>${data.receiptDetail.id}</td>
                            <td>${data.receiptDetail.product.name}</td>
                            <td>${data.receiptDetail.color.name}</td>
                            <td>${data.receiptDetail.quantity}</td>
                            
                            <td class="font-weight-bold">${data.total}</td>
                            <td ><a href="#" class="btn btn-danger item-delete" data-id="${data.receiptDetail.id}">Xóa</a></td>
                        </tr>
                    `;
                    document.querySelector('tbody').insertAdjacentHTML('beforeend', newRow);
                    setupDeleteEvent();
                    fetch('get-updated-values', {
                            method: 'GET',
                        })
                    .then(response => response.json())
                    .then(data => {
                        // Cập nhật giá trị của $sl và $total trên giao diện
                        document.getElementById('totalQuantity').textContent = data.sl;
                        document.getElementById('totalAmount').textContent = data.total + '₫';
                    })
                }
            })
            .catch(error => console.error('Error:', error));
        });


        function setupDeleteEvent() {
        // Lắng nghe sự kiện click của nút xóa
        document.querySelectorAll('.item-delete').forEach(item => {
            item.addEventListener('click', function (event) {
                event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

               var deleteUrl = "{{ route('admin.receipt-detail.destroy', ':id') }}"; 
                var receiptDetailId = this.getAttribute('data-id');
               deleteUrl = deleteUrl.replace(':id', receiptDetailId);// Lấy URL xóa từ thuộc tính href
                 // Lấy ID của chi tiết phiếu nhập từ thuộc tính data-id
                var tableRow = this.closest('tr'); // Tìm dòng chứa nút xóa

                // Gửi AJAX request để xóa chi tiết phiếu nhập
                fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Nếu xóa thành công, xóa dòng tương ứng trong bảng
                    if (data.status === 'success') {
                        tableRow.parentNode.removeChild(tableRow); // Xóa dòng
                        alert(data.message); // Hiển thị thông báo

                        fetch('get-updated-values', {
                            method: 'GET',
                            })
                        .then(response => response.json())
                        .then(data => {
                            // Cập nhật giá trị của $sl và $total trên giao diện
                            document.getElementById('totalQuantity').textContent = data.sl;
                            document.getElementById('totalAmount').textContent = data.total + '₫';
                        })
                        // document.getElementById('totalQuantity').textContent = data.sl;
                        // document.getElementById('totalAmount').textContent = data.total;
                    } else {
                        alert('Đã xảy ra lỗi khi xóa!');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    }

    // Gọi hàm để cài đặt sự kiện xóa khi trang được tải lần đầu
    setupDeleteEvent();
    });




    // document.addEventListener('DOMContentLoaded', function () {
    //     // Lắng nghe sự kiện click của nút xóa
    //     document.querySelectorAll('.item-delete').forEach(item => {
    //         item.addEventListener('click', function (event) {
    //             event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

    //             var deleteUrl = this.getAttribute('href'); // Lấy URL xóa từ thuộc tính href
    //             var receiptDetailId = this.getAttribute('data-id'); // Lấy ID của chi tiết phiếu nhập từ thuộc tính data-id

    //             // Gửi AJAX request để xóa chi tiết phiếu nhập
    //             fetch(deleteUrl, {
    //                 method: 'DELETE',
    //                 headers: {
    //                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //                 }
    //             })
    //             .then(response => response.json())
    //             .then(data => {
    //                 // Nếu xóa thành công, xóa dòng tương ứng trong bảng
    //                 if (data.status === 'success') {
    //                     var tableRow = this.closest('tr'); // Tìm dòng chứa nút xóa
    //                     tableRow.parentNode.removeChild(tableRow); // Xóa dòng
    //                     alert(data.message); // Hiển thị thông báo
    //                 } else {
    //                     alert('Đã xảy ra lỗi khi xóa!');
    //                 }
    //             })
    //             .catch(error => console.error('Error:', error));
    //         });
    //     });
    // });
    </script>
    
@endpush