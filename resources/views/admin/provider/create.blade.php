@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Nhà Cung Cấp</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.provider.index') }}">Nhà Cung Cấp</a></div>
        <div class="breadcrumb-item">Thêm</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-10 col-md-10 col-lg-10">
          <div class="card">
            <div class="card-header">
              <h4>Thêm Nhà Cung Cấp</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.provider.store') }}" method="POST" >
                    @csrf
                    <div class="form-group">
                        <label for="">Tên Nhà Cung Cấp</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="form-group col-6">
                            <label for="">Số điện thoại</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Địa chỉ</label>
                        <textarea name="address" id="" class="form-control" cols="30" rows="10"></textarea>
                        {{-- <input type="text" class="form-control" name="address"> --}}
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