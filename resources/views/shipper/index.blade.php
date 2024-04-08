@extends('admin.layouts.master')

@section('content')


<section class="section">
    <div class="section-header">
      <h1>Đơn Hàng </h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item">Đơn Hàng </div>
      </div>
    </div>

    <div class="section-body " >
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Danh sách đơn hàng</h4>
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
            let status = 3; // Hoặc 0 tùy thuộc vào trạng thái bạn muốn gửi
            
            $.ajax({
                url: "{{ route('shipper.change-status-3') }}",
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