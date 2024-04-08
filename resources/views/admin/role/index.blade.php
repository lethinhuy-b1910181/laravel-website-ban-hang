@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header">
      <h1>Phân Quyền Nhân viên</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Phân Quyền Nhân viên</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Phân Quyền Nhân viên</h4>
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
  $(document).on('click', '.change-role-btn', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var quyen_id = $(this).data('quyen-id');
    var confirmation = confirm('Bạn có chắc chắn muốn thay đổi quyền của nhân viên không?');
    if (!confirmation) {
        return false; // Người dùng hủy thao tác, không thực hiện Ajax
    }
    $.ajax({
        url: '{{ route('admin.role.change-role') }}',
        type: 'POST',
        data: {id: id, quyen_id: quyen_id, _token: '{{ csrf_token() }}'}, 
        success: function(response) {
            
                toastr.success(response.message); 
                location.reload();
        },
        error: function(xhr, status, error) {
            console.log(data);
        }
    });
});

</script> 
@endpush