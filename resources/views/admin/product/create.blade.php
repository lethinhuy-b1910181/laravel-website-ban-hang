@extends('admin.layouts.master')

@section('content')
@php
    $categories = App\Models\Category::all();
    $brands = App\Models\Brand::all();
    $colors = App\Models\Color::all();
@endphp
<section class="section">
    <div class="section-header">
      <h1> Sẳn Phẩm</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Sản Phẩm</a></div>
        <div class="breadcrumb-item">Thêm</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Thêm Sản Phẩm Mới</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.product.store') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-8">
                            <label for="">Tên Sản Phẩm<span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Nhập tên sản phẩm">
                        </div>
                        <div class="form-group col-4">
                            <label for="">Màu Sắc<span class="text-danger">(*)</span></label>
                            
                            <select class="form-control select2" multiple="" name='color_id[]'>
                                @foreach ($colors as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="">Giá Sản Phẩm<span class="text-danger">(*)</span></label>
                            <input type="number" min="0" class="form-control" name="offer_price" placeholder="Nhập giá bán ra">
                        </div>
                        
                        <div class="form-group col-4">
                            <label>Thương hiệu<span class="text-danger">(*)</span></label>
                            <select class="form-control select2 brand" name="brand_id">
                                <option value="">----- Chọn Thương Hiệu ----- </option>
                                @foreach ($brands as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group col-4">
                            <label>Danh mục<span class="text-danger">(*)</span></label>
                            <select class="form-control select2 cate" name="category_id">
                                <option value="">----- Chọn Danh Mục ----- </option>
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
                                <img id="preview_avtimg"  >
                            </div>
                            
                            
                        </div>
                        <div class="form-group col-8">
                            <label for="">Hình ảnh chi tiết sản phẩm<span class="text-danger">(*)</span> <i class="text-danger">(Tối đa 4 ảnh)</i></label>
                            <input type="file" multiple name="multi_img[]" class="form-control" id="multiImg" name="image" accept="image/jpeg,image/jpg,image/gif,image/png ">
                            
                            <div class="row viewmul viewimg"  id="preview_img">
                            </div>
                            
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Đường link video<span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" name="video_link" placeholder="Nhập đườnglink video giới thiệu sản phẩm">
                    </div>
                    <div class="form-group">
                        <label for="">Mô tả tóm tắt sản phẩm<span class="text-danger">(*)</span></label>
                        <textarea  class="form-control" name="short_description" id="" cols="" rows="50"></textarea>

                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label text-md-right ">Mô tả chi tiết sản phẩm<span class="text-danger">(*)</span></label>
                        <textarea name="long_description" class="form-control summernote"></textarea>
                      </div>
                      <div class="row">
                        <div class="form-group col-6">
                            <label>Trạng thái hiển thị</label>
                            <select class="form-control selectric" name="status">
                              <option value="1">Hiển thị</option>
                              <option value="0">Không hiển thị</option>
                            </select>
                          </div>
                          <div class="form-group col-6">
                            <label>Loại sản phẩm</label>
                            <select class="form-control selectric" name="product_type">
                                <option value="normal">Thông thường</option>
                              <option value="new">Mới ra mắt</option>
                              <option value="hot">Sản phẩm Hot</option>
                              <option value="order">Hàng đặt trước</option>
                            </select>
                          </div>
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

     $('.brand').on('change',function(){
          var brand_id = $(this).val();
          console.log(brand_id);
          $.ajax({
              url: "{{ route('admin.get-category', '') }}/" + brand_id,
              type: 'GET',
              success:function(response){
                  var options = '<option value="">Chọn Danh Mục</option>';
                  $.each(response, function(id, name){
                    
                    options += '<option value="'+id+'">'+name+'</option>';
                    
                  });
                  $('.cate').html(options);
                  console.log($('.cate').html());
                 
              }
          });
      });
    });
 </script>
 @endpush