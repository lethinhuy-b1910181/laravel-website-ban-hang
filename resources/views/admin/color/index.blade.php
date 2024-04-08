@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header">
      <h1>Màu Sắc</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Màu Sắc </div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-9 col-md-9 col-lg-9">
          <div class="card">
            <div class="card-header">
              <h4>Danh Sách Màu Sắc</h4>
              <div class="card-header-action">
                <a href="{{ route('admin.product-color.create') }}" class="btn btn-primary"><i class="fa fa-plus mx-2"></i>Thêm</a>

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
   
    
@endpush