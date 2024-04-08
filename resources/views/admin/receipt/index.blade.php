@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header">
      <h1>Nhập Kho</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Nhập Kho</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Lịch Sử Nhập Kho</h4>
              <div class="card-header-action">
                <a href="{{ route('admin.receipt.create') }}" class="btn btn-primary"><i class="fa fa-plus mx-2"></i>Thêm phiếu nhập</a>

              </div>
            </div>
            <div class="card-body">
              {{ $dataTable->table() }}
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
      $('body').on('click', '.change-status', function(e){
          e.preventDefault(); // Ngăn chặn hành động mặc định của nút
          let id = $(this).data('id');
          let status = 1; // Hoặc 0 tùy thuộc vào trạng thái bạn muốn gửi
          
          $.ajax({
              url: "{{ route('admin.receipt.change-status') }}",
              method: 'PUT',
              data: {
                  id: id,
                  status: status // Gửi cả id và status
              },
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Đảm bảo gửi CSRF token
              },
              success: function(data){
                  toastr.success(data.message);
                  // Cập nhật giao diện nếu cần thiết
                  location.reload();
              },
              error: function(xhr, status, error){
                  console.log(error);
              }
          });
      });
  });
  </script>
  
@endpush