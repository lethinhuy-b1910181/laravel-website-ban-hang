@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header">
      <h1>Danh mục</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Danh mục </div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Danh Mục Sản Phẩm</h4>
              <div class="card-header-action">
                <a href="{{ route('admin.category.create') }}" class="btn btn-primary"><i class="fa fa-plus mx-2"></i>Thêm</a>

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
   {{-- <script>
        $(document).ready(function(){
            $('body').on('click', '.change-status', function(){
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');
                
                $.ajax({
                    url:"{{ route('admin.category.change-status') }}",
                    method: 'POST',
                    data:{  
                        _method:'PUT',
                        status: isChecked,
                        id: id,
                        _token: '{{ csrf_token() }}',
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
    </script>  --}}

    <script>
        $(document).ready(function(){
            $('body').on('click', '.change-status', function(){
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');
                isChecked = isChecked ? 1 : 0;
                $.ajax({
                    url: "{{ route('admin.category.change-status') }}",
                    method: 'PUT', // Sử dụng phương thức PUT trực tiếp
                    data: {
                        status: isChecked,
                        id: id,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(data){
                        toastr.success(data.message);
                    },
                    error: function(xhr, status, error){
                        console.log(error);
                    }
                });
            });
        });
    </script>
    
@endpush