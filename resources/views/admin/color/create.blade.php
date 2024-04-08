@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Màu Sắc</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.product-color.index') }}">Màu Sắc</a></div>
        <div class="breadcrumb-item">Thêm</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-10 col-md-10 col-lg-10">
          <div class="card">
            <div class="card-header">
              <h4>Thêm Màu Mới</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.product-color.store') }}" method="POST" >
                    @csrf
                    <div class="form-group">
                        <label for="">Tên Màu</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success"><b>THÊM</b></button>

                    </div>
                </form>
            </div>
            
          </div>
        </div>
      </div>
      
    </div>
  </section>
@endsection