@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header">
      <h1>Nhà Cung Cấp</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Nhà Cung Cấp </div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Danh Sách Nhà Cung Cấp </h4>
              <div class="card-header-action">
                <a href="{{ route('admin.provider.create') }}" class="btn btn-primary"><i class="fa fa-plus mx-2"></i>Thêm</a>

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