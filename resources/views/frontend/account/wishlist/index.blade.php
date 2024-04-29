

@extends('frontend.layouts.master')

@section('content')
<div class="container BtZOqO">
    @include('frontend.sidebar')
    <div class="fkIi86">
        <div class="CAysXD">
            <div class="" style="display: contents;">
                <div class="utB99K">
                    <div class="SFztPl d-flex justify-content-center">
                        <h1 class="BVrKV_ " >
                            Sản Phẩm Yêu Thích Của Tôi
                        </h1>
                        
                    </div>
                    <div class="RCnc9v">
                         
                        <div class="row col-12 d-flex justify-content-center">
                            @if ($products != '')
                                @foreach ($products as $product)
                                @php
                                    $item= \App\Models\Product::where('id', $product->product_id)->first();
                                @endphp  
                                <div class="col-xl-3 col-sm-6 col-lg-4 new ">
                                    <div class="wsus__product_item item-top-product">
                                    
                                        {{-- <span class="wsus__minus">New</span> --}}
                                        <a class="wsus__pro_link" href="{{ route('product-detail',$item->slug) }}">
                                            <img src="{{ asset($item->image) }}" alt="product" class="img-fluid  img_1" />
                                            <img src="{{ asset($item->image) }}" alt="product" class="img-fluid  img_2" />
                                        </a>
                                        <ul class="wsus__single_pro_icon">
                                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $item->id }}"><i
                                                        class="far fa-eye"></i></a></li>
    
                                            @if (Auth::guard('customer')->check())
                                                    @php
                                                    
                                                    $check = \App\Models\Wishlist::where('user_id',Auth::guard('customer')->user()->id)->where('product_id',$item->id)->first();
                                                    if($check){
                                                        $i = 'fas fa-heart text-danger';
                                                    }else {
                                                        $i = 'fal fa-heart';
                                                    }
                                                @endphp
                                                <li><a href="#" data-id="{{ $item->id }}" class="wishlist"><i class="{{ $i }}" ></i></a></li>
                                            @else
                                                <li><a href="#" data-id="{{ $item->id }}" class="wishlist"><i class="fal fa-heart" ></i></a></li>
                                                
                                            @endif
                                            <li><a href="#"><i class="far fa-random"></i></a>
                                        </ul>
                                        <div class="wsus__product_details">
                                            <a class="wsus__category" href="#">
                                                @php
                                                    $temp = App\Models\Category::where('id',  $item->category_id)->first();
                                                @endphp
                                                {{ $temp->name}} 
                                            </a>
                                            <p class="wsus__pro_rating">       
                                                @php
                                                    $colorStar = \App\Models\ProductReview::where( 'product_id', $item->id)->count();
                                                    $star = \App\Models\ProductReview::where( 'product_id', $item->id)->avg('star');
                    
                                                    
                                                    // Lấy trung bình cộng của đánh giá
                                                    $average_star = \App\Models\ProductReview::where('product_id', $item->id)->avg('star');
                                                    
                                                    // Tạo một biến để lưu trữ số sao nguyên
                                                    $full_stars = floor($average_star);
                                                    
                                                    // Kiểm tra xem trung bình có phần thập phân không
                                                    $has_half_star = $average_star - $full_stars > 0;
                                                @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $full_stars)
                                                        @php $colorIcon = 'color:#ffcc00;'; @endphp
                                                        <i class="fas fa-star" style="{{ $colorIcon }}"></i>
                                                    @elseif ($has_half_star && $i == $full_stars + 1)
                                                        @php $colorIcon = 'color:#ffcc00;'; @endphp
                                                        <i class="fas fa-star-half" style="{{ $colorIcon }}"></i>
                                                    @else
                                                        @php $colorIcon = 'color:#ccc;'; @endphp
                                                        <i class="far fa-star" style="{{ $colorIcon }}"></i>
                                                    @endif
                                                @endfor
                                                
                                                <span>{{ $colorStar }} Đánh giá</span>
                                            </p>
                                            <a class="wsus__pro_name wsus__pro_name-home"  data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->name }}" href="{{ route('product-detail',$item->slug) }}">{{ $item->name }}</a>
                                            <p class="wsus__price text-danger"  >{{ number_format($item->offer_price, 0, ',', '.') }}&#8363;</p>
                                        
                                        </div>
                                    </div>
                                </div>
                                 @endforeach
                            @else
                                
                            @endif
                           
                        </div>
                        

                    </div>


                </div>
            </div>
                
            
        </div>
       
    </div>
</div>

@endsection