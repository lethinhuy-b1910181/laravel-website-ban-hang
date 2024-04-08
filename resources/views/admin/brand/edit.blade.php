@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Thương Hiệu</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.brand.index') }}">Thương Hiệu</a></div>
        <div class="breadcrumb-item">Cập Nhật</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Cập Nhật Thương Hiệu</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.brand.update', $brand->id) }}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Tên Thương Hiệu</label>
                        <input type="text" value="{{ $brand->name }}" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="">Hình ảnh Logo</label>
                        <div class="input_img">
                            <input type="file" name="image" value="{{ $brand->image }}" id="custom-file-input" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" 
                                class="form-control" >

                        </div>
                        <div class="mt-2">
                            <img id="preview_avtimg" src="{{ asset($brand->image) }}"  width="100" height="100">
                        </div>
                    </div>
                    <div class="form-group">
                      <label>Trạng thái hiển thị</label>
                      <select class="form-control selectric" name="status">
                        <option {{ $brand->status == 1 ? 'selected' : '' }} value="1">Hiển thị</option>
                            <option {{ $brand->status == 0 ? 'selected' : '' }} value="0">Không hiển thị</option>
                      </select>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success"><b>Cập Nhật</b></button>
                    </div>
                </form>
            </div>
            
          </div>
        </div>
      </div>
      
    </div>
  </section>
@endsection