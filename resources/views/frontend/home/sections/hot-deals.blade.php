<section id="wsus__flash_sell" class="wsus__flash_sell_2">
    <div class=" container">
        <div class="row">
            <div class="col-xl-12">
                <div class="" >
                    <div class="wsus__flash_coundown">
                        <span>Bán chạy nhất</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row flash_sell_slider">
            @foreach ($view_products as $item)
            <div class="col-xl-3 col-sm-6 col-lg-4">
                <div class="wsus__product_item">
                    {{-- <span class="wsus__new">New</span> --}}
                    <span class="wsus__minus">Hot</span>
                    <a class="wsus__pro_link" href="{{ route('product-detail',$item->slug) }}">
                        <img src="{{ asset($item->image) }}" alt="product" class="img-fluid  img_1" />
                        <img src="{{ asset($item->image) }}" alt="product" class="img-fluid  img_2" />
                    </a>
                    <ul class="wsus__single_pro_icon">
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $item->id }}"><i
                                    class="far fa-eye"></i></a></li>
                        <li><a href="#"><i class="far fa-heart"></i></a></li>
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
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span>(133 review)</span>
                        </p>
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
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span>20 review</span>
                                    </p>
                                    <p class="description">{!! $product->short_description !!}</p>

                                    <div class="wsus__selectbox">
                                        <div class="row">
                                            <div class="col-xl-6 col-sm-6">
                                                <h5 class="mb-2">Chọn màu:</h5>
                                                <select class="select_2" name="colors_item[]">
                                                    @foreach ($product->colors as $color)
                                                        <option value="{{ $color->id }}" >{{ $color->name }}</option>
                                                    
                                                    @endforeach
                                                
                                                </select>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="wsus__quentity">
                                        <h5>Số lượng :</h5>
                                        <div class="select_number">
                                            <input class="number_area" type="text" min="1" max="100" value="1" />
                                        </div>
                                    </div>

                                    <ul class="wsus__button_area">
                                        <li><button type="submit" class="add_cart" href="#" >Thêm giỏ hàng</button></li>
                                        {{-- <li><a class="buy_now" href="#">buy now</a></li> --}}
                                        <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                        <li><a href="#"><i class="far fa-random"></i></a></li>
                                    </ul>
                                    <p class="brand_model"><span>Mã sản phẩm :</span> #{{ $product->id }}</p>
                            <p class="brand_model"><span>Thương hiệu :</span> {{ $product->brand->name }}</p>
                            <p class="brand_model"><span>Danh mục :</span> {{ $product->category->name }}</p>
                                    <div class="wsus__pro_det_share">
                                        <h5>share :</h5>
                                        <ul class="d-flex">
                                            <li><a class="facebook" href="#"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a class="twitter" href="#"><i class="fab fa-twitter"></i></a></li>
                                            <li><a class="whatsapp" href="#"><i class="fab fa-whatsapp"></i></a></li>
                                            <li><a class="instagram" href="#"><i class="fab fa-instagram"></i></a></li>
                                        </ul>
                                    </div>
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