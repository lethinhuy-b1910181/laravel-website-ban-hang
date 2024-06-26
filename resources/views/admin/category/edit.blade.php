@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Danh mục</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.slider.index') }}">Danh mục</a></div>
        <div class="breadcrumb-item">Cập nhật</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-10 col-md-10 col-lg-10">
          <div class="card">
            <div class="card-header">
              <h4>Cập Nhật Danh Mục</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.category.update', $category->id) }}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Tên danh mục</label>
                        <input type="text" value="{{ $category->name }}" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="">Mô tả</label>
                        <input type="text" class="form-control" value="{{ $category->image }}" name="image">
                    </div>
                    <div class="form-group">
                        <label for="inputState">Trạng thái hiển thị</label>
                        <select name="status" id="inputState" class="form-control">
                            <option {{ $category->status == 1 ? 'selected' : '' }} value="1">Hiển thị</option>
                            <option {{ $category->status == 0 ? 'selected' : '' }} value="0">Không hiển thị</option>
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
