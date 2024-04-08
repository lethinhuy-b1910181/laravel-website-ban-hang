@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header">
      <h1>Đơn Hàng Mới</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Đơn Hàng Mới</div>
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

@endpush