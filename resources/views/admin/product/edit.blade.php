@extends('admin.layouts.master')

@section('content')
@php
    $categories = App\Models\Category::all();
    $brands = App\Models\Brand::all();
    $colorDetails = App\Models\ColorDetail::all();
    $colors = App\Models\Color::all();
@endphp
<section class="section">
    <div class="section-header">
      <h1> Sẳn Phẩm</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Sản Phẩm</a></div>
        <div class="breadcrumb-item">Cập Nhật</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Cập Nhật Sản Phẩm</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.product.update', $product->id) }}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-8">
                            <label for="">Tên Sản Phẩm<span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" value="{{ $product->name }}" name="name" placeholder="Nhập tên sản phẩm">
                        </div>
                        <div class="form-group col-4">
                            <label>Màu Sắc<span class="text-danger">(*)</span></label>
                            <select  class="form-control select2" multiple="" name='color_id[]'  >
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}" {{ $product->colors->contains('id', $color->id) ? 'selected' : '' }}>
                                        {{ $color->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="">Giá Sản Phẩm<span class="text-danger">(*)</span></label>
                            <input type="number" min="0" value="{{ $product->offer_price }}" class="form-control" name="offer_price" placeholder="Nhập giá bán">
                        </div>
                        <div class="form-group col-4">
                            <label>Danh mục<span class="text-danger">(*)</span></label>
                            <select class="form-control selectric" name="category_id">
                                <option value="">----- Chọn Danh Mục ----- </option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}" {{ $product->category_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label>Thương hiệu<span class="text-danger">(*)</span></label>
                            <select class="form-control selectric" name="brand_id">
                                <option value="">----- Chọn Thương Hiệu ----- </option>
                                @foreach ($brands as $item)
                                    <option value="{{ $item->id }}" {{ $product->brand_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">

                        
                        <div class="form-group col-4">
                            <label for="">Hình ảnh đại diện sản phẩm<span class="text-danger">(*)</span></label>
                            <div class="input_img">
                                <input type="file" name="image" id="custom-file-input"  class="form-control" >
                               
                            </div>
                            <div class="mt-2 viewimg">
                                
                                <img id="preview_avtimg" src="{{ asset($product->image) }}"  >
                            </div>
                            
                            
                        </div>
                        <div class="form-group col-8">
                            <label for="">Hình ảnh chi tiết sản phẩm<span class="text-danger">(*)</span> </label>
                            <input type="file" multiple name="multi_img[]" class="form-control" id="multiImg" name="image" accept="image/jpeg,image/jpg,image/gif,image/png ">
                            <div class="mt-2 viewmul">
                                
                                @foreach ($multiImgs as $item)
                                <img id="preview_avtimg"  src="  {{ asset('uploads/'.$item->multi_img) }}" alt="Admin" class=" bg-primary" width="80">
                                <a href="{{ route('admin.multi-image.delete',$item->id) }}"><i class="bx bx-x"></i></a>
                            @endforeach
                            </div>
                            
                        
                            <div class="row viewmul "  id="preview_img">
                                
                            </div>
                            
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Đường link video<span class="text-danger">(*)</span></label>
                        <input type="text" value="{{ $product->video_link }}" class="form-control" name="video_link" placeholder="Nhập đườnglink video giới thiệu sản phẩm">
                    </div>
                    <div class="form-group">
                        <label for="">Mô tả tóm tắt sản phẩm<span class="text-danger">(*)</span></label>
                        <textarea  class="form-control"  name="short_description" id="" cols="" rows="50">{{ $product->short_description }}</textarea>

                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label text-md-right ">Mô tả chi tiết sản phẩm<span class="text-danger">(*)</span></label>
                        <textarea name="long_description"  class="form-control summernote">{{ $product->long_description }}</textarea>
                      </div>

                      <div class="row">
                          <div class="form-group col-6">
                            <label>Loại sản phẩm</label>
                            <select class="form-control selectric" name="status">
                                <option value="normal" {{ $product->product_type == 'normal' ? 'selected' : '' }}>Thông thường</option>
                              <option value="new"  {{ $product->product_type == 'new' ? 'selected' : '' }}>Mới ra mắt</option>
                              <option value="hot" {{ $product->product_type == 'hot' ? 'selected' : '' }}>Sản phẩm Hot</option>
                              <option value="order" {{ $product->product_type == 'order' ? 'selected' : '' }}>Hàng đặt trước</option>
                            </select>
                          </div>
                          <div class="form-group col-6">
                            <label>Trạng thái hiển thị</label>
                            <select class="form-control selectric" name="status">
                                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Không hiển thị</option>
                            </select>
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
@push('scripts')
<!--------===Show MultiImage ========------->
<script>
    $(document).ready(function(){
     $('#multiImg').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            var data = $(this)[0].files; //this file data
             
            $.each(data, function(index, file){ //loop though each file
                if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                    return function(e) {
                        var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(130)
                    .height(130); //create image element 
                        $('#preview_img').append(img); //append image to output element
                    };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });
             
        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
     });
    });
 </script>
 @endpush