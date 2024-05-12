@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Danh mục Bài Viết</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Danh mục Bài Viết</a></div>
        <div class="breadcrumb-item">Thêm</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-10 col-md-10 col-lg-10">
          <div class="card">
            <div class="card-header">
              <h4>Thêm Danh Mục Mới</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blog-category.store') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Tên danh mục</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                  
                    <div class="form-group">
                        <label for="inputState">Trạng thái hiển thị</label>
                        <select name="status" id="inputState" class="form-control">
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