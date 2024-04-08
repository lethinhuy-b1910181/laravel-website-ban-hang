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
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Đánh giá</a>
                  </li>
                  
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="home-content">
                            <div class="header">
                                <span><b>Tổng số lượng:</b>  Còn <b >{{ $sl }}</b> hàng trong kho.</span>
                                <div class="sub-header">
                                    <table class="table col-5">
                                        <thead>
                                          <tr>
                                            <th scope="col">Màu Sắc</th>
                                            <th scope="col">Số Lượng</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($receiptProduct as $item)
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
                                        <label for="">Giá nhập</label>
                                        <input type="text" class="form-control" value="" disabled>
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
                                        <input type="text" class="form-control" value="" disabled>
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
                    Sed sed metus vel lacus hendrerit tempus. Sed efficitur velit tortor, ac efficitur est lobortis quis. Nullam lacinia metus erat, sed fermentum justo rutrum ultrices. Proin quis iaculis tellus. Etiam ac vehicula eros, pharetra consectetur dui. Aliquam convallis neque eget tellus efficitur, eget maximus massa imperdiet. Morbi a mattis velit. Donec hendrerit venenatis justo, eget scelerisque tellus pharetra a.
                  </div>
                  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    Sed sed metus vel lacus hendrerit tempus. Sed efficitur velit tortor, ac efficitur est lobortis quis. Nullam lacinia metus erat, sed fermentum justo rutrum ultrices. Proin quis iaculis tellus. Etiam ac vehicula eros, pharetra consectetur dui. Aliquam convallis neque eget tellus efficitur, eget maximus massa imperdiet. Morbi a mattis velit. Donec hendrerit venenatis justo, eget scelerisque tellus pharetra a.
                  </div>

                  
                </div>
            </div>
        </div>

        
        
    </div>
  </section>
@endsection

@push('scripts')

@endpush