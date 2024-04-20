@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Thương Hiệu</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.brand.index') }}">Thương Hiệu</a></div>
        <div class="breadcrumb-item">Thêm</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Thêm Thương Hiệu Mới</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.brand.store') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Tên Thương Hiệu</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                      <label for="">Danh mục sản phẩm<span class="text-danger">(*)</span></label>
                      
                      <select class="form-control select2" multiple="" name='category_id[]'>
                          @foreach ($category as $item)
                              <option value="{{ $item->id }}">{{ $item->name }}</option>
                          @endforeach
                      </select>
                  </div>
                    
                    <div class="form-group">
                      <label>Trạng thái hiển thị</label>
                      <select class="form-control selectric" name="status">
                        <option value="1">Hiển thị</option>
                        <option value="0">Không hiển thị</option>
                      </select>
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