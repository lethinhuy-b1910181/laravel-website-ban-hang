<section id="wsus__flash_sell" class="wsus__flash_sell_2">
    <div class=" container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bd-tl" >
                    <div class="wsus__flash_coundown">
                        <span>Lượt Xem Nhiều Nhất</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row flash_sell_slider">
            @foreach ($view_products as $item)
            <div class="col-xl-3 col-sm-6 col-lg-4">
                <div class="wsus__product_item">
                    {{-- <span class="wsus__new">New</span> --}}
                    @if ($item->product_type == 'new')
                    <span class="wsus__minus">New</span>
                    @endif
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
                                <li><a href="#"  data-id="{{ $item->id }}" class="wishlist"><i class="fal fa-heart"></i></a></li>
                                
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
                                $colorStar = \App\Models\ProductReview::where( 'product_id', $item->id)->where('status', 1)->count();
                                $star = \App\Models\ProductReview::where( 'product_id', $item->id)->where('status', 1)->avg('star');

                                
                                // Lấy trung bình cộng của đánh giá
                                $average_star = \App\Models\ProductReview::where('product_id', $item->id)->where('status', 1)->avg('star');
                                
                                // Tạo một biến để lưu trữ số sao nguyên
                                $full_stars = floor($average_star);
                                
                                // Kiểm tra xem trung bình có phần thập phân không
                                $has_half_star = $average_star - $full_stars > 0;
                            @endphp
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
                        </p>
                        {{-- <p class="wsus__pro_rating">
                            
                            @for ($i = 1; $i <= 5; $i++)
                                
                                @php
                                    $colorStar = \App\Models\ProductReview::where( 'product_id', $item->id)->first();

                                    
                                    if($colorStar){
                                        $count = $colorStar->count();
                                        if($i <= $colorStar->star){
                                            $colorIcon = 'color:#ffcc00;';
                                        }else{
                                            $colorIcon = 'color:#ccc;';

                                        }
                                    }else {
                                        $colorIcon = 'color:#ccc;'; 
                                        $count = 0;
                                    }
                                @endphp
                                    <i class="fas fa-star" style="{{  $colorIcon }}"></i>
                                @endfor
                            <span>{{ $count }} Đánh giá</span>
                       
                        </p> --}}
                        <a class="wsus__pro_name wsus__pro_name-home"  data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->name }}" href="{{ route('product-detail',$item->slug) }}">{{ $item->name }}</a>
                        <p class="wsus__price text-danger"  >{{ number_format($item->offer_price, 0, ',', '.') }}&#8363;</p>
                        {{-- <a class="add_cart" href="#">Thêm vào giỏ hàng</a> --}}
                    </div>
                </div>
            </div>
            @endforeach
            
           

        </div>
    </div>
</section>


    <!--==========================
      PRODUCT MODAL VIEW START
    ===========================-->
    @foreach ($view_products as $product)
    @php
        

        $tong = \App\Models\ReceiptProduct::where('product_id', $product->id)->sum('quantity');
    @endphp
        <section class="product_popup_modal">
        <div class="modal fade" id="exampleModal-{{ $product->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                class="far fa-times"></i></button>
                        <div class="row">
                            <div class="col-xl-6 col-12 col-sm-10 col-md-8 col-lg-6 m-auto display">
                                <div class="wsus__quick_view_img">
                                    @if ($product->video_link)
                                    <a class="venobox wsus__pro_det_video" data-autoplay="true" data-vbtype="video"
                                    href="{{ $product->video_link }}">
                                    <i class="fas fa-play"></i>
                                </a>
                                        
                                    @endif
                                    <div class="row modal_slider">
                                        <div class="col-xl-12">
                                            <div class="modal_slider_img">
                                                <img src="{{ $product->image }}" alt="product" class="img-fluid w-100">
                                            </div>
                                        </div>
                                        @foreach ($product->productImage as $item)
                                        <div class="col-xl-12">
                                            <div class="modal_slider_img">
                                                <img src="{{ asset('uploads/'.$item->multi_img) }}" alt="product" class="img-fluid w-100">
                                            </div>
                                        </div>
                                        @endforeach
                                        
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="wsus__pro_details_text">
                                    <a class="title" href="#">{{ $product->name }}</a>
                                    <p class="wsus__stock_area">Tình trạng: Còn <b>{{ $tong  }}</b> hàng trong kho </p>
                                <h4>{{ number_format($product->offer_price, 0, ',', '.') }}&#8363;</h4>
                                    <p class="wsus__stock_area"></p>
                                    <p class="review">
                                        @for ($i = 1; $i <= 5; $i++)
                                            
                                            @php
                                                $colorStar = \App\Models\ProductReview::where( 'product_id', $product->id)->first();

                                               
                                                if($colorStar){
                                                    $count = $colorStar->count();
                                                    if($i <= $colorStar->star){
                                                        $colorIcon = 'color:#ffcc00;';
                                                    }else{
                                                        $colorIcon = 'color:#ccc;';

                                                    }
                                                }else {
                                                    $colorIcon = 'color:#ccc;'; 
                                                    $count = 0;
                                                }
                                            @endphp
                                                <i class="fas fa-star" style="{{  $colorIcon }}"></i>
                                            @endfor
                                        <span>{{ $count }} Đánh giá</span>
                                    </p>
                                    <p class="description">{!! $product->short_description !!}</p>
                                    <p class="brand_model"><span>Mã sản phẩm :</span> #{{ $product->id }}</p>
                                    <p class="brand_model"><span>Thương hiệu :</span> {{ $product->brand->name }}</p>
                                    <p class="brand_model"><span>Danh mục :</span> {{ $product->category->name }}</p>

                                    @php
                                    $colors= App\Models\ColorDetail::where('product_id', $product->id)->get();
                                @endphp
                                @if ($colors != NULL)
                                <p style="padding-bottom: 5px; font-weight: 600">Chọn màu để xem giá:</p>
                                <div class="box-content">
                                    <ul class="list-variants" id="color-list">
                                        
                                        @foreach ($colors as $color)
                                        @php
                                            $min_price_product = App\Models\ReceiptProduct::where(['product_id' => $product->id])->min('price');
                                            $receiptPrice = App\Models\ReceiptProduct::where(['product_id' => $product->id, 'color_id' => $color->color_id])->max('price');
                                            if($receiptPrice == NULL){
                                                $receiptPrice = 0;
                                            }

                                            if($min_price_product == NULL){
                                                $min_price_product = 0;
                                            }

                                            $temp = $receiptPrice - $min_price_product;
                                            if($receiptPrice > $min_price_product)
                                            {
                                                if($product->offer_price + $temp  == $product->offer_price){
                                                    $t = 'active';

                                                }else $t = '';
                                            }else $t ='';
                                            
                                            if($color->quantity - $color->sale == 0){
                                                $d = 'disable';
                                            }else $d = '';

                                            $quantity = $color->quantity - $color->sale;

                                        @endphp
                                        <li class="item-variant {{ $t }} {{ $d }}" data-temp="{{ $temp }}" data-quantity="{{ $quantity }}">
                                            <input type="hidden" class="color-item" data-id="{{ $color->color_id }}"  >
                                            <div class="is-flex is-flex-direction-column">
                                                <strong class="item-variant-name">{{ $color->color->name}}</strong>
                                                <span>{{ number_format($product->offer_price + $temp , 0, ',', '.') }}₫</span>
                                            </div>
                                        </li>
                                        
                                        @endforeach
                                    </ul>
                                </div>
                                    
                                @endif
                                    
                                    
                                    <div class="wsus__quentity">
                                        <h5>Số lượng :</h5>
                                        <div class="select_number">
                                            <input class="number_area" type="text" min="1" max="100" value="1" />
                                        </div>
                                    </div>

                                    <ul class="wsus__button_area">
                                        <li><button type="submit" class="add_cart" href="#" >Thêm giỏ hàng</button></li>
                                        {{-- <li><a class="buy_now" href="#">buy now</a></li> --}}
                                        @if (Auth::guard('customer')->check())
                                            @php
                                            
                                            $check = \App\Models\Wishlist::where('user_id',Auth::guard('customer')->user()->id)->where('product_id',$product->id)->first();
                                            if($check){
                                                $i = 'fas fa-heart text-danger';
                                            }else {
                                                $i = 'fal fa-heart';
                                            }
                                        @endphp
                                        <li><a href="#"  data-id="{{ $product->id }}" class="wishlist"><i class="{{ $i }}" ></i></a></li>
                                    @else
                                    <li><a href="#"  data-id="{{ $product->id }}" class="wishlist"><i class="fal fa-heart" ></i></a></li>
                                        
                                    @endif
                                        <li><a href="#"><i class="far fa-random"></i></a></li>
                                    </ul>
                               
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach
    
    <!--==========================
      PRODUCT MODAL VIEW END
    ===========================-->