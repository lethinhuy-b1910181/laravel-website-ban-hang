@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Slider</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.slider.index') }}">Slider</a></div>
        <div class="breadcrumb-item">Cập nhật</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Cập Nhật Slider</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.slider.update', $slider->id) }}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Tiêu đề</label>
                        <input type="text" value="{{ $slider->name }}" class="form-control" name="name">
                        
                    </div>
                    <div class="form-group">
                        <label for="">Hình ảnh</label>
                        <div class="input_img">
                            <input type="file" name="image" id="custom-file-input" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" 
                                class="form-control" >

                        </div>
                        <div class="mt-2">
                            <img id="preview_avtimg" src="{{ asset($slider->image) }}"  width="300" height="150">
                        </div>
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
