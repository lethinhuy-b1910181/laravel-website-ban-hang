@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Mã Giảm Giá</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Mã Giảm Giá</a></div>
        <div class="breadcrumb-item">Thêm</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-10 col-md-10 col-lg-10">
          <div class="card">
            <div class="card-header">
              <h4>Thêm Mã Giảm Giá</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.coupon.store') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group ">
                        <label for="">Tên Mã giảm<span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" name="name">
                    </div>
                       
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">Mã giảm giá<span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" name="code">
                        </div>
                        <div class="form-group col-6">
                            <label for="">Loại giảm giá<span class="text-danger">(*)</span></label>
                            <select name="type" id="inputState" class="form-control">
                                <option value="">----Chọn loại giảm----</option>
                                <option value="1">Giảm theo tiền</option>
                                <option value="0">Giảm theo phần trăm</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">Ngày bắt đầu<span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control  datepicker" name="start_date">
                        </div>
                        <div class="form-group col-6">
                            <label for="">Ngày kết thúc<span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control  datepicker" name="end_date" value="{{ request()->start_date }}" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="">Số lượng<span class="text-danger">(*)</span></label>
                            <input type="number" class="form-control" name="value">
                        </div>
                        <div class="form-group col-3">
                            <label for="">Giá trị giảm<span class="text-danger">(*)</span></label>
                            <input type="number" class="form-control" name="min_price">
                        </div>
                        <div class="form-group col-3">
                            <label for="">Đơn tối hiểu</label>
                            <input type="number" class="form-control" name="min_order">
                        </div>
                        <div class="form-group col-3">
                            <label for="">Giảm tối đa</label>
                            <input type="number" class="form-control" name="max_price">
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success"><b>THÊM</b></button>
                        <a href="{{ route('admin.coupon.index') }}" class="btn btn-danger ml-2"><b>QUAY LẠI</b></a>
                    </div>
                </form>
            </div>
            
          </div>
        </div>
      </div>
      
    </div>
  </section>
@endsection

@push('scripts')

@endpush