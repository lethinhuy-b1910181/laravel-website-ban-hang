@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header">
      <h1>Đánh Giá Sản Phẩm</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Đánh Giá Sản Phẩm</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Tất Cả Đánh Giá</h4>
              
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
      $('body').on('click', '.change-status', function(){
          let isChecked = $(this).is(':checked');
          let id = $(this).data('id');
       
          isChecked = isChecked ?  1: 0;
          
          $.ajax({
              url:"{{ route('admin.product-review.change-status') }}",
              method: 'PUT',
              data:{
                  status: isChecked,
                  id: id
              },
              success:function(data){
                  toastr.success(data.message);

              },
              error: function(xrr, status, error){
                  console.log(error);
              }
          })
      })
  })
</script> 
@endpush