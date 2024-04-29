@extends('frontend.layouts.master')

@section('content')
     


    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ul>
                            <li><a href="
                                {{ route('home') }}">Trang chủ</a></li>
                            <li><a href="#">Sản phẩm</a></li>
                            <li><a href="#">{{ $product->category->name }}</a></li>
                            <li><a href="#">{{ $product->name }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        PRODUCT DETAILS START
    ==============================-->
    <section id="wsus__product_details">
        <div class="container">
            <div class="wsus__details_bg">
                <div class="row">
                    <div class="col-xl-5 col-md-6 col-lg-6">
                        <div id="sticky_pro_zoom">
                            <div class="exzoom hidden" id="exzoom">
                                <div class="exzoom_img_box">
                                    @if ($product->video_link)
                                    <a class="venobox wsus__pro_det_video" data-autoplay="true" data-vbtype="video"
                                    href="{{ $product->video_link }}">
                                    <i class="fas fa-play"></i>
                                </a>
                                        
                                    @endif
                                    
                                    <ul class='exzoom_img_ul'>
                                        <li><img class="zoom ing-fluid w-100" src="{{ asset($product->image) }}" alt="product"></li>

                                        @foreach ($product->productImage as $item)
                                        <li><img class="zoom ing-fluid w-100" src="{{ asset('uploads/'.$item->multi_img) }}" alt="product"></li>
                                            
                                        @endforeach
                                        
                                    </ul>
                                </div>
                                <div class="exzoom_nav"></div>
                                <p class="exzoom_btn">
                                    <a href="javascript:void(0);" class="exzoom_prev_btn"> <i
                                            class="far fa-chevron-left"></i> </a>
                                    <a href="javascript:void(0);" class="exzoom_next_btn"> <i
                                            class="far fa-chevron-right"></i> </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-md-7 col-lg-7">
                        <div class="wsus__pro_details_text">
                            <a class="title" href="#">{{ $product->name }}</a>
                            {{-- <p class="wsus__stock_area" id="stock_area">Tình trạng: Còn <b id="stock_quantity">{{ $sl }}</b> hàng trong kho </p> --}}
                            <h4 id="offer_price">{{ number_format($product->offer_price, 0, ',', '.') }}₫</h4>
                       
                            <p class="review">       
                                @php
                                    $colorStar = \App\Models\ProductReview::where( 'product_id', $product->id)->count();
                                    $star = \App\Models\ProductReview::where( 'product_id', $product->id)->avg('star');

                                    
                                    // Lấy trung bình cộng của đánh giá
                                    $average_star = \App\Models\ProductReview::where('product_id', $product->id)->avg('star');
                                    
                                    // Tạo một biến để lưu trữ số sao nguyên
                                    $full_stars = floor($average_star);
                                    
                                    // Kiểm tra xem trung bình có phần thập phân không
                                    $has_half_star = $average_star - $full_stars > 0;
                                @endphp
                                {{round( $average_star, 1) }} 
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $full_stars)
                                        {{-- Tô màu sao đầy --}}
                                        @php $colorIcon = 'color:#ffcc00;'; @endphp
                                        <i class="fas fa-star" style="{{ $colorIcon }}"></i>
                                    @elseif ($has_half_star && $i == $full_stars + 1)
                                        {{-- Tô màu sao bán chấp nhận được --}}
                                        @php $colorIcon = 'color:#ffcc00;'; @endphp
                                        <i class="fas fa-star-half" style="{{ $colorIcon }}"></i>
                                    @else
                                        {{-- Tô màu sao rỗng --}}
                                        @php $colorIcon = 'color:#ccc;'; @endphp
                                        <i class="far fa-star" style="{{ $colorIcon }}"></i>
                                    @endif
                                @endfor
                                 
                                <span>{{ $colorStar }} Đánh giá</span>
                                <span> {{ $product->sales }} Đã bán</span>
                            </p>
                           <p class="description">{!! $product->short_description !!}</p>
                           <p class="brand_model"><span>Mã sản phẩm :</span> #{{ $product->id }}</p>
                            <p class="brand_model"><span>Thương hiệu :</span> {{ $product->brand->name }}</p>
                            <p class="brand_model"><span>Danh mục :</span> {{ $product->category->name }}</p>
                            
                            <form class="shopping-cart-form" style="
                                    margin-top: 20px;
                                ">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                @php
                                    $colors= App\Models\ColorDetail::where('product_id', $product->id)->get();
                                @endphp
                                @if ($colors != NULL)
                                <p style="padding-bottom: 15px; font-weight: 600">Chọn màu để xem giá:</p>
                                <div class="box-content">
                                    <ul class="list-variants" id="color-list">
                                        @if($colors->count() > 1)
                                            @foreach ($colors as $color)
                                            {{-- @php
                                                $count = PHP_INT_MAX;
                                                foreach($colors as $i){
                                                    $p =  App\Models\KhoHang::where(['product_id'=> $product->id, 'color_id' => $i->color_id])->latest()->first();
                                                    if($p->price < $count)
                                                        $count = $p->price;

                                                }
                                            @endphp --}}
                                            
                                            {{-- @foreach ($colors as $color)
                                            @php

                                                $min_prices =  App\Models\KhoHang::where('product_id', $product->id)->min('price');
                                                
                                                $price =  App\Models\KhoHang::where(['product_id'=> $product->id, 'color_id'=>$color->color_id ])->where('quantity' ,'>', 0)->max('price');
                                                if ($count == $price) {
                                                    $temp = 0;
                                                    $offerPrice = $product->offer_price;
                                                    $count++;
                                                } else {
                                                    $id = $colors[0]->color_id;
                                                    $f = App\Models\KhoHang::where(['product_id'=> $product->id, 'color_id'=>$id])->latest()->first();
                                               
                                                    // Tính toán giá của màu sắc dựa trên giá nhập của màu và giá khuyến mãi của sản phẩm
                                                    $temp = $price - $f->price;
                                                    $offerPrice = $product->offer_price + $temp;
                                                }
                                        
                                                // Xác định lớp CSS cho mỗi màu sắc
                                                $t = $offerPrice == $product->offer_price ? 'active' : '';
                                                $d = ($color->quantity - $color->sale) == 0 ? 'disable' : '';
                                        
                                                // Tính toán số lượng còn lại của màu sắc
                                                $quantity = $color->quantity - $color->sale;
                                            @endphp
                                        <li class="item-variant {{ $t }} {{ $d }}" data-temp="{{ $temp }}" data-quantity="{{ $quantity }}">
                                            <input type="hidden" class="color-item" data-id="{{ $color->color_id }}"  >
                                            <div class="is-flex is-flex-direction-column">
                                                <strong class="item-variant-name">{{ $color->color->name }}</strong>
                                                <span>{{ number_format($offerPrice, 0, ',', '.') }}₫</span>
                                            </div>
                                        </li> --}}
                                                @php
                                                    $bonus = \App\Models\ColorDetail::where(['product_id' => $product->id, 'color_id' => $color->color_id])->first();
                                                    $temp = $bonus->bonus;
                                                    if($product->offer_price == $product->offer_price + $temp){
                                                        $t = '';
                                                    }else $t='';


                                                    if($color->quantity - $color->sale == 0){
                                                        $d = 'disable';
                                                    }else $d = '';

                                                    $quantity = $color->quantity - $color->sale;

                                                @endphp
                                                <li class="item-variant {{ $t }} {{ $d }}" data-temp="{{ $temp }}" data-quantity="{{ $quantity }}">
                                                    <input type="hidden" class="color-item" data-id="{{ $color->color_id }}"  >
                                                    <div class="is-flex is-flex-direction-column">
                                                        <strong class="item-variant-name">{{ $color->color->name}}</strong>
                                                        <span >{{ number_format($product->offer_price + $temp , 0, ',', '.') }}₫</span>
                                                    </div>
                                                </li>
                                            
                                            @endforeach

                                        @else
                                        @foreach ($colors as $color)
                 
                                            @php
                                                $bonus = \App\Models\ColorDetail::where(['product_id' => $product->id, 'color_id' => $color->color_id])->first();
                                                    $temp = $bonus->bonus;
                                                    if($product->offer_price == $product->offer_price + $temp){
                                                        $t = 'active';
                                                    }else $t='';


                                                    if($color->quantity - $color->sale == 0){
                                                        $d = 'disable';
                                                    }else $d = '';

                                                    $quantity = $color->quantity - $color->sale;

                                            @endphp
                                            <li class="item-variant {{ $t }} {{ $d }}" data-temp="0" data-quantity="{{ $quantity }}">
                                                <input type="hidden" class="color-item" data-id="{{ $color->color_id }}"  >
                                                <div class="is-flex is-flex-direction-column">
                                                    <strong class="item-variant-name">{{ $color->color->name}}</strong>
                                                    <span>{{ number_format($product->offer_price , 0, ',', '.') }}₫</span>
                                                    
                                                </div>
                                            </li>
                                            @endforeach
                                        @endif
                                        
                                    </ul>
                                </div>
                                    
                                @endif
                                @if ($sl == 0)
                                
                                    <h5 class="text-danger">Sản Phẩm Tạm Hết Hàng</h5>
                                    <input class="" type="hidden" name="qty"  value="0" />

                                
                                @else
                                <div class="wsus__quentity">
                                    <h5>Số lượng :</h5>
                                    <div class="select_number">
                                        <input class="number_area" type="text" name="qty" id="quantity_input" min="1" max="{{ $sl }}" value="1" />
                                        
                                    </div>
                                    <p  style="
                                                font-weight: 400;
                                                padding-left: 20px;
                                            " class="wsus__stock_area" id="stock_area"> <b id="stock_quantity">{{ $sl }}</b> sản phẩm có sẵn </p>

                                </div>
                                <input type="hidden" name="color_id" id="color_id" value="">
                                <ul class="wsus__button_area">
                                    <li><button type="submit" class="add_cart "  href="#" >Thêm giỏ hàng</button></li>
                                    {{-- <li><a class="buy_now" href="#">Mua ngay</a></li> --}}
                                    
                                    <li><a href="#"></a></li>
                                    @if (Auth::guard('customer')->check())
                                                @php
                                                
                                                $check = \App\Models\Wishlist::where('user_id',Auth::guard('customer')->user()->id)->where('product_id',$product->id)->first();
                                                if($check){
                                                    $i = 'fas fa-heart text-danger';
                                                }else {
                                                    $i = 'fal fa-heart';
                                                }
                                            @endphp
                                            <li><a href="#" class="wishlist" data-id="{{ $product->id }}"><i class="{{ $i }}"  ></i></a></li>
                                        @else
                                            <li><a href="#"  class="wishlist" data-id="{{ $product->id }}"><i class="fal fa-heart" ></i></a></li>
                                            
                                        @endif
                                    
                                </ul>
                                @endif
                                <input type="hidden" name="product_price" value="">
                                {{-- <input type="hidden" id="color_id" name="color_id" value=""> --}}
                            </form>
                            
                            
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__pro_det_description">
                        <div class="wsus__details_bg">
                            <ul class="nav nav-pills mb-3" id="pills-tab3" role="tablist" style="
                            display: flex;
                            justify-content: center;
                        ">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active " id="pills-home-tab7" data-bs-toggle="pill"
                                        data-bs-target="#pills-home22" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true">Chi tiết sản phẩm</button>
                                </li>
                            
                                <li class="nav-item" role="presentation">
                                    @php
                                       if($reviews->count() == 0) $dn = 'd-none';
                                       else $dn  = '';

                                    @endphp
                                    <button class="nav-link " id="pills-contact-tab2" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact2" type="button" role="tab"
                                        aria-controls="pills-contact2" aria-selected="false">Đánh giá <span class="{{ $dn }}">({{ $reviews->count() }})</span></button>
                                </li>
                                
                               
                            </ul>
                            <div class="tab-content" id="pills-tabContent4">
                                <div class="tab-pane fade show active  " id="pills-home22" role="tabpanel"
                                    aria-labelledby="pills-home-tab7">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="wsus__description_area">
                                                {!! $product->long_description !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 col-md-4">
                                                <div class="description_single">
                                                    <h6><span>1</span> Giao hàng miễn phí</h6>
                                                    <p>Tất cả các sản phẩm sẽ được giao hàng tận nơi và miễn phí ship.</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4">
                                                <div class="description_single">
                                                    <h6><span>2</span> Dễ dàng đổi trả</h6>
                                                    <p>Hoàn trả dễ dàng trong vòng 30 ngày.</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4">
                                                <div class="description_single">
                                                    <h6><span>3</span> Chính sách bảo hành </h6>
                                                    <p>Bảo hành 12 tháng.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="tab-pane fade " id="pills-contact2" role="tabpanel"
                                    aria-labelledby="pills-contact-tab2">
                                    <div class="wsus__pro_det_review">
                                        <div class="wsus__pro_det_review_single">
                                            
                                            @if ($reviews->count() > 0)
                                            {{-- <div class="row " style="
                                            height: 50px;
                                            margin: 20px;
                                            background-color: rgb(255, 251, 248);
                                            border: 1px solid rgb(249, 237, 229);
                                        ">
                                                <div class="col-3">
                                                    <div class="">{{ $total_star }} trên 5</div>
                                                </div>
                                                <div class="col-9"></div>
                                            </div> --}}
                                                @foreach ($reviews as $item)
                                                     @php
                                                        $user = \App\Models\Customer::where('id', $item->user_id)->first();
                                                    @endphp
                                                    <div class="row" style="
                                                    margin: 10px 20px;    border-bottom: 1px solid grey;
                                                    ">
                                                        <div class="col-xl-12 col-lg-12">
                                                            <div class="row " style="
                                                                padding: 10px;
                                                            ">
                                                                <div class="col-1">
                                                                    <img style="
                                                                    width: 60px !important;
                                                                    height: 60px !important;
                                                                    margin-top: 8px !important;
                                                                " src="{{ $user->image ? asset( $user->image) : asset('uploads/default.png') }}"> </img>
                                                                </div>
                                                                <div class="col-11">
                                                                    <div class="">
                                                                    <span style="font-size: 14px; color: black;">{{ $user->name }}</span>
                                                                        
                                                                    </div>
                                                                    <div >
                                                                        <ul class="list-inline" style="
                                                                        display: flex;
                                                                        align-items: center;
                                                                        font-size: .875rem;
                                                                        ">
                                                                        
                                                                        <br>
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                            
                                                                            @php

                                                                                if($item){
                                                                                        $orderRating = $item->star;
                                                                                    
                                                                                        
                                                                                        switch($orderRating) {
                                                                                        case 1:
                                                                                            $orderRatingtext = 'Tệ';
                                                                                            $orderRatingtextColor = 'color:#ccc;';
                                                                                            break;
                                                                                        case 2:
                                                                                            $orderRatingtext = 'Không hài lòng';
                                                                                            $orderRatingtextColor = 'color:#ccc;';
                                                                                            break;
                                                                                        case 3:
                                                                                            $orderRatingtext = 'Bình thường';
                                                                                            $orderRatingtextColor = 'color:#ccc;';
                                                                                            break;
                                                                                        case 4:
                                                                                            $orderRatingtext = 'Hài lòng';
                                                                                            $orderRatingtextColor = 'color:#ffcc00;';
                                                                                            break;
                                                                                        case 5:
                                                                                            $orderRatingtext = 'Tuyệt vời';
                                                                                            $orderRatingtextColor = 'color:#ffcc00;';
                                                                                            break;
                                                                                    }
                                                                                    }else {
                                                                                        
                                                                                        $orderRatingtext = 'Tuyệt vời';
                                                                                        $orderRatingtextColor = 'color:#ffcc00;';
                                                                                        
                                                                                    }
                                                                                if($item){
                                                                                    if($i <= $item->star){
                                                                                        $colorIcon = 'color:#ffcc00;';
                                                                                    }else{
                                                                                        $colorIcon = 'color:#ccc;';

                                                                                    }
                                                                                }else $colorIcon = 'color:#000;';
                                                                            @endphp
                                                                                <li  style="display: inline-block;cursor: pointer; font-size:16px; {{ $colorIcon }}">&#9733;</li>
                                                                                
                                                                            @endfor
                                                                            <span id="ratingText" style="
                                                                            padding-left: 10px;
                                                                            font-size: .875rem;
                                                                            {{  $orderRatingtextColor }}
                                                                            font-weight:600;
                                                                        ">{{ $orderRatingtext }}</span>

                                                                        </ul>
                                                                    </div>
                                                                    @php
                                                                        if ($item) {
                                                                            $formattedDate = $item->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('H:i:s d-m-Y');
                                                                        } else {
                                                                            $formattedDate = null; 
                                                                        }
                                                                        if($item->review != ''){
                                                                            $dn = '';
                                                                            $t = $item->review;
                                                                        } 
                                                                        else{
                                                                            $dn = 'd-none';
                                                                            $t = '';
                                                                        } 
                                                                    @endphp
                                                                    <div class="{{ $dn }}">
                                                                        <div ><span style="
                                                                            font-size: .875rem;
                                                                        ">{{ $formattedDate }} </span><span style="font-size: 14px; ">| Phân loại hàng: {{ $item->color->name }}</span></div>
                                                                        <span style="
                                                                        padding-right: 15px;
                                                                        color: #ccc;
                                                                        font-size: .875rem;
                                                                        
                                                                    ">Chất lượng sản phẩm: <span style="color: #000; font-size: .875rem;">{{ $t }}</span></span>
                                                                    </div>

                                                                    <div class="">
                                                                    
                                                                        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        
                                                    </div>
                                                @endforeach

                                                <div id="pagination">
                                                    <nav aria-label="Page navigation example">
                                                        <ul class="pagination">
                                                            <li class="page-item">
                                                                <a class="page-link" href="#"
                                                                    aria-label="Previous">
                                                                    <i class="fas fa-chevron-left"></i>
                                                                </a>
                                                            </li>
                                                            <li class="page-item"><a
                                                                    class="page-link page_active" href="#">1</a>
                                                            </li>
                                                            <li class="page-item"><a class="page-link"
                                                                    href="#">2</a></li>
                                                            <li class="page-item"><a class="page-link"
                                                                    href="#">3</a></li>
                                                            <li class="page-item"><a class="page-link"
                                                                    href="#">4</a></li>
                                                            <li class="page-item">
                                                                <a class="page-link" href="#" aria-label="Next">
                                                                    <i class="fas fa-chevron-right"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                </div>
                                        
                                                                
                                            @else
                                                <div class="">Chưa có đánh giá nào</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                               
                              
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--============================
        PRODUCT DETAILS END
    ==============================-->

    


    <!--============================
        RELATED PRODUCT START
    ==============================-->
    <section id="wsus__flash_sell">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__section_header">
                        <h3>Sản Phẩm Liên Quan</h3>
                    </div>
                </div>
            </div>
            <div class="row flash_sell_slider">

                @foreach ($relate_products as $item)  
                    <div class="col-xl-3 col-sm-6 col-lg-4">
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
                                        <li><a href=""  class="wishlist" data-id="{{ $item->id }}"> <i class="{{ $i }}" ></i></a></li>
                                    @else
                                        <li><a href=""  class="wishlist" data-id="{{ $item->id }}"> <i class="fal fa-heart" ></i></a></li>
                                        
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
               
                

            </div>
        </div>
    </section>
    <!--============================
        RELATED PRODUCT END
    ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.shopping-cart-form').on('submit', function(e){
                e.preventDefault();
                var colorId = $('.item-variant.active .color-item').data('id');

                if ($('.item-variant.active').length === 0) {
                    toastr.error('Vui lòng chọn màu sắc sản phẩm!');
                    return; 
                }
                let formData = $(this).serialize();
                formData += '&color_id=' + colorId;
                console.log(formData);
                $.ajax({
                    method: 'POST',
                    data: formData,
                    url: "{{ route('add-to-cart') }}",
                    success: function(data){
                        if(data.status === 'success'){
                            getCartCount();
                            
                            toastr.success(data.message);
                        }else if(data.status === 'error'){
                            toastr.error(data.message);

                        }
                    },
                    error: function(data){

                    },
                });
            });

            function getCartCount(){
                $.ajax({
                    method: 'GET',
                    url: "{{ route('cart.cart-count') }}",
                    success: function(data){
                        $('#cart-count').text(data);
                    },
                    error: function(data){

                    },
                });
            }
        });

        $(document).ready(function() {
            var colorList = document.getElementById("color-list");

            if (colorList) {
                var colorItems = colorList.querySelectorAll(".item-variant");

                colorItems.forEach(function(item) {
                    item.addEventListener("click", function() {
                        // Xác định màu sắc được chọn
                        var colorId = this.querySelector('.color-item').getAttribute('data-id');
                        document.getElementById('color_id').value = colorId;
                        
                        // Kiểm tra xem người dùng đã nhập số lượng trước khi chọn màu chưa
                        var inputQuantity = parseInt(document.getElementById('quantity_input').value);
                        var maxQuantity = parseInt(this.getAttribute('data-quantity'));

                        // Nếu số lượng nhập lớn hơn số lượng thực tế của màu sắc
                        if (inputQuantity > maxQuantity) {
                            // Cập nhật lại số lượng và hiển thị thông báo
                            document.getElementById('quantity_input').value = maxQuantity;
                            alert("Chỉ có " + maxQuantity + " sản phẩm tại cửa hàng.");
                        }

                        // Tiến hành các thao tác khác như bạn đã thực hiện trước đó
                        colorItems.forEach(function(item) {
                            item.classList.remove("active");
                        });
                        this.classList.add("active");

                        // Cập nhật thông tin sản phẩm
                        var temp = parseFloat(this.getAttribute('data-temp'));
                        var offerPrice = parseFloat("{{ $product->offer_price }}") + temp;
                        $('input[name="product_price"]').val(offerPrice);
                        document.getElementById('offer_price').innerHTML = offerPrice.toLocaleString('vi-VN') + '₫';
                        
                        var quantity = parseInt(this.getAttribute('data-quantity'));
                        document.getElementById('stock_quantity').innerText = quantity;
                        document.getElementById('quantity_input').setAttribute('max', quantity);
                    });
                });
            }
            
        });


        // $(document).ready(function() {
          
        //     var colorList = document.getElementById("color-list");

        //     if (colorList) {
             
        //         var colorItems = colorList.querySelectorAll(".item-variant");

                
        //         colorItems.forEach(function(item) {
        //             item.addEventListener("click", function() {
                       
        //                 colorItems.forEach(function(item) {
        //                     item.classList.remove("active");
        //                 });
                       
        //                 this.classList.add("active");
        //                 var colorId = this.querySelector('.color-item').getAttribute('data-id');
                       
        //                 document.getElementById('color_id').value = colorId;

        //                 var temp = parseFloat(this.getAttribute('data-temp'));

                       
        //                 var offerPrice = parseFloat("{{ $product->offer_price }}") + temp;
        //                 $('input[name="product_price"]').val(offerPrice);


                     
        //                 document.getElementById('offer_price').innerHTML = offerPrice.toLocaleString('vi-VN') + '₫';

                        
                     
        //                 var quantity = parseInt(this.getAttribute('data-quantity'));
        //                 document.getElementById('stock_quantity').innerText = quantity;
                        

        //                 document.getElementById('quantity_input').setAttribute('max', quantity);
                       
        //             });
        //         });
        //     }
        // });
    </script>
@endpush