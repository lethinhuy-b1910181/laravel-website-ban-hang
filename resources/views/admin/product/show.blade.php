@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header">
      <h1>Sản Phẩm</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Sản Phẩm</a></div>
        <div class="breadcrumb-item">Chi Tiết Sản Phẩm</div>
      </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Tổng quan</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="false">Chi tiết</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Đánh giá ({{ $dem }})</a>
                  </li>
                  
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="home-content">
                            <div class="header">
                                <span><b>Tổng số lượng:</b>  Còn <b >{{ $sl }}</b> hàng trong kho.</span>
                                <div class="sub-header">
                                    <table class="table col-10 table-bordered">
                                        <thead>
                                          <tr>
                                            <th scope="col">Màu Sắc</th>
                                            <th scope="col">Số Lượng</th>
                                            <th scope="col">Lượt bán</th>
                                            <th scope="col">Phụ phí (+)</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($productColor as $item)
                                            <tr>
                                                    <td> 
                                                        @php
                                                            $text = App\Models\Color::where('id', $item->color_id)->first();
                                                            $color = $text->name;
                                                        @endphp
                                                        {{ $color }}
                                                    </td>
                                                    <td>
                                                        {{ $item->quantity }}
                                                    </td>

                                                    

                                                    <td>
                                                        {{ $item->sale }}
                                                    </td>

                                                    <td class="d-flex justify-content-center">

                                                      

                                                        <div class="" style="
                                                            align-items: center;
                                                            display: flex;
                                                        ">
                                                          <form  action="{{ route('admin.product.update-bonus') }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                                            <input type="hidden" name="color_id" value="{{ $item->color_id }}">
                                                            <input type="number" id="bonusInput" value="{{ $item->bonus}}" name="bonus">
                                                            <button type="submit"  class=" btn btn-danger">Cập nhật</button>
                                                          </form>
                                                        </div>
                                                       

                                                      
                                                      
                                                      
                                                  </td>
                                            </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                            <div class="content">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="">Tên Sản Phẩm</label>
                                        <input type="text" class="form-control" value="{{ $product->name }}" disabled>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="">Giá bán</label>
                                        <input type="text" class="form-control text-danger" value="{{number_format($product->offer_price, 0, ',', '.') }}&#8363;" disabled>
                                    </div>
                                   
                                </div>
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label for="">Danh mục</label>
                                        <input type="text" class="form-control" value="{{ $category->name }}" disabled>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="">Thương hiệu</label>
                                        <input type="text" class="form-control" value="{{ $brand->name }}" disabled>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="">Lượt bán</label>
                                        <input type="text" class="form-control" value="{{ $product->sales }}" disabled>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="">Lượt xem</label>
                                        <input type="text" class="form-control" value="{{ $product->view }}" disabled>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                  </div>
                  <div class="tab-pane fade" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                    <div class="content">
                      <div class="row">
                        <div class="form-group col-4">
                          <label for="">Hình ảnh đại diện sản phẩm<span class="text-danger">(*)</span></label>
                         
                          <div class="mt-2 viewimg">
                              
                              <img id="preview_avtimg" src="{{ asset($product->image) }}"  >
                          </div>
                          
                          
                        </div>
                        <div class="form-group col-8">
                            <label for="">Hình ảnh chi tiết sản phẩm<span class="text-danger">(*)</span> </label>
                          
                            <div class="mt-2 viewmul">
                                
                                @foreach ($multiImgs as $item)
                                    <img id="preview_avtimg"  src="  {{ asset('uploads/'.$item->multi_img) }}" alt="Admin" class=" bg-primary" width="80">
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
                    </div>
                  </div>
                  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    
                    <table class="table col-12 table-bordered">
                      <thead>
                        <tr>
                          <th scope="col">Khách hàng</th>
                          <th scope="col">Mức đánh giá</th>
                          <th scope="col">Nội dung</th>
                          <th scope="col">Trạng thái</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($reviews as $item)
                          @php
                              $user = App\Models\Customer::where('id', $item->user_id)->first();
                              $color = $user->name;
                              if($item->status == 1) $text = 'Hiện';
                              else $text = 'Ẩn';
                             
                          @endphp
                          <tr>
                                  <td> 
                                     
                                      {{ $color }}
                                  </td>
                                  <td>
                                  @for ($i = 1; $i <= 5; $i++) 
                                    @php
                                        if ($i <= $item->star) {
                                          // Tô màu sao đầy
                                          $starIcons = "fas fa-star" ;
                                          $starSt = "color: #ffcc00;";
                                      } else {
                                          // Tô màu sao rỗng
                                          $starIcons = "fas fa-star";
                                          $starSt = "color: #ccc;";
    
                                      }
                                    @endphp
                                    <i class="{{$starIcons  }}" style="{{ $starSt }}" ></i>

                                  @endfor
                                      
                                  </td>

                                  

                                  <td>
                                      {{ $item->review }}
                                  </td>

                                  <td class="d-flex justify-content-center">
                                    <span class="text-info">{{ $text }}</span>
                                    
                                </td>
                          </tr>
                         @endforeach
                      </tbody>
                  </table>
                  
                  </div>

                  
                </div>
            </div>
        </div>

        
        
    </div>
  </section>
@endsection

@push('scripts')

{{-- <script>
  $(document).ready(function() {
        $('#updateBonusForm').on('click',function(e) {
            e.preventDefault(); // Ngăn chặn form gửi đi một cách bình thường

            var formData = $(this).serialize(); // Chuyển đổi dữ liệu của form thành chuỗi query
            var url = $(this).attr('action'); // Lấy đường dẫn action từ form

            $.ajax({
                type: 'PUT',
                url: url,
                data: formData,
                success: function(response) {
                  toastr.success(response.message);
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi nếu có
                    alert('Đã xảy ra lỗi: ' + error);
                }
            });
        });

        
    });
</script> --}}
@endpush