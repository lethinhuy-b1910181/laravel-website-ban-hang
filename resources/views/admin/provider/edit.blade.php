@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Nhà Cung Cấp</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.provider.index') }}">Nhà Cung Cấp</a></div>
        <div class="breadcrumb-item">Cập Nhật</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-10 col-md-10 col-lg-10">
          <div class="card">
            <div class="card-header">
              <h4>Cập Nhật Nhà Cung Cấp</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.provider.update', $provider->id) }}" method="POST" >
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Tên Nhà Cung Cấp</label>
                        <input type="text" class="form-control" name="name" value="{{ $provider->name }}">
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $provider->email }}" >
                        </div>
                        <div class="form-group col-6">
                            <label for="">Số điện thoại</label>
                            <input type="text" class="form-control" name="phone" value="{{ $provider->phone }}">
                        </div>
                    </div>  
                    <div class="form-group">
                        <label for="">Địa chỉ</label>
                        <textarea name="address" id="" class="form-control" cols="30" rows="10">value="{{ $provider->address }}</textarea>

                    </div>
                    <div class="form-group">
                      <label>Trạng thái</label>
                      <select class="form-control selectric" name="status">
                        <option {{ $provider->status == 1 ? 'selected' : '' }} value="1">Đang hợp tác</option>
                            <option {{ $provider->status == 0 ? 'selected' : '' }} value="0">Ngừng hợp tác</option>
                      </select>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success"><b>CẬP NHẬT</b></button>

                    </div>
                </form>
            </div>
            
          </div>
        </div>
      </div>
      
    </div>
  </section>
@endsection