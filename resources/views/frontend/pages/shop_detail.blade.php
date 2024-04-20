@extends('frontend.layouts.master')

@section('content')

    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ul>
                            <li><a href="
                                {{ route('home') }}">Trang chủ</a></li>
                                <li><a href="
                                    {{ route('home.shop') }}">Cửa hàng</a></li>
                            <li><a href="{{ route('home.shop.detail', $brand->slug ) }}">Máy ảnh {{ $brand->name }}</a></li>
                            
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
        PRODUCT PAGE START
    ==============================-->
    <section id="wsus__product_page">
        <div class="container">
            <div class="row">
                
                <div class="col-xl-3 col-lg-4">
                    <div class="wsus__sidebar_filter ">
                        <p>filter</p>
                        <span class="wsus__filter_icon">
                            <i class="far fa-minus" id="minus"></i>
                            <i class="far fa-plus" id="plus"></i>
                        </span>
                    </div>
                    <div class="wsus__product_sidebar" id="sticky_sidebar">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Máy Ảnh {{ $brand->name }}
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul>
                                            @foreach ($category as $item)
                                            
                                                <li class="brand-content"><a href="{{ route('home.shop.detail',['slug' => $brand->slug,'category' => $item->category->slug]) }}" class="brand-link {{ $re_cate == $item->category->slug ? 'active' : '' }}"> {{ $item->category->name }} {{ $brand->name }}</a></li>
                                            @endforeach
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <h1 class="page-title" id="pageTitle">Máy Ảnh {{ $brand->name }}</h1>
                    <div class="jss596">
                        <div class="jss597">
                            <div>Mức giá:</div>
                            <ul class="jss598">
                                @if ($re_cate != '')
                                    <li class="jss599">
                                        <a href="{{ route('home.shop.detail',['slug' => $brand->slug,'category' => $re_cate, 'price_range' => 'Duoi20']) }}" class="jss604 "  >
                                            <span class="MuiButton-label MuiButton-root {{ $re_price == 'Duoi20' ? 'active' : '' }}">Dưới 1 triệu</span>
                                        </a>
                                    </li>
                                    <li class="jss599">
                                        <a href="{{ route('home.shop.detail',['slug' => $brand->slug,'category' => $re_cate,'price_range' => 'Tu20Den40']) }}" class="jss604"  >
                                            <span class="MuiButton-label MuiButton-root {{ $re_price == 'Tu20Den40' ? 'active' : '' }}">Từ 1-3 triệu</span>
                                        </a>
                                    
                                    </li>
                                    <li class="jss599">
                                        <a href="{{ route('home.shop.detail',['slug' => $brand->slug,'category' => $re_cate,'price_range' => 'Tu40Den70']) }}" class="jss604"  >
                                            <span class="MuiButton-label MuiButton-root {{ $re_price == 'Tu40Den70' ? 'active' : '' }}">Từ 3-5 triệu</span>
                                        </a>
                                        
                                    </li>
                                    <li class="jss599">
                                        <a href="{{ route('home.shop.detail',['slug' => $brand->slug,'category' => $re_cate,'price_range' => 'Tren70']) }}" class="jss604"  >
                                            <span class="MuiButton-label MuiButton-root {{ $re_price == 'Tren70' ? 'active' : '' }}">Trên 5 triệu</span>
                                        </a>
                                    
                                    </li>
                                @else
                                    <li class="jss599">
                                        <a href="{{ route('home.shop.detail',['slug' => $brand->slug, 'price_range' => 'Duoi20']) }}" class="jss604 "  >
                                            <span class="MuiButton-label MuiButton-root {{ $re_price == 'Duoi20' ? 'active' : '' }}">Dưới 1 triệu</span>
                                        </a>
                                    </li>
                                    <li class="jss599">
                                        <a href="{{ route('home.shop.detail',['slug' => $brand->slug,'price_range' => 'Tu20Den40']) }}" class="jss604"  >
                                            <span class="MuiButton-label MuiButton-root {{ $re_price == 'Tu20Den40' ? 'active' : '' }}">Từ 1-3 triệu</span>
                                        </a>
                                    
                                    </li>
                                    <li class="jss599">
                                        <a href="{{ route('home.shop.detail',['slug' => $brand->slug,'price_range' => 'Tu40Den70']) }}" class="jss604"  >
                                            <span class="MuiButton-label MuiButton-root {{ $re_price == 'Tu40Den70' ? 'active' : '' }}">Từ 3-5 triệu</span>
                                        </a>
                                        
                                    </li>
                                    <li class="jss599">
                                        <a href="{{ route('home.shop.detail',['slug' => $brand->slug,'price_range' => 'Tren70']) }}" class="jss604"  >
                                            <span class="MuiButton-label MuiButton-root {{ $re_price == 'Tren70' ? 'active' : '' }}">Trên 5 triệu</span>
                                        </a>
                                    
                                    </li>
                                    
                                @endif
                                
                            </ul>
                        </div>

                     
                        
                        
                    </div>
                    <div class="row">
                        <div class="col-xl-12 d-none d-md-block mt-md-4 mt-lg-0">
                            
                            <div class="filter-sort__list-filter">
                                <span style="color:black; padding-right:10px">Sắp xếp theo:</span>
                                @if ($re_cate != '' && $re_price != '')
                                    <a href="{{ route('home.shop.detail',['slug' => $brand->slug,'category' => $re_cate,'price_range' => $re_price,'sort' => 'sale' ]) }}" class="btn-filter button__sort {{ $re_sort == 'sale' ? 'active' : '' }}"><div class="icon">
                                    </div>
                                        Bán Chạy Nhất
                                    </a>
                                    <a href="{{ route('home.shop.detail',['slug' => $brand->slug,'category' => $re_cate,'price_range' => $re_price,'sort' => 'view' ]) }}" class="btn-filter button__sort {{ $re_sort == 'view' ? 'active' : '' }}">
                                        <div class="icon"></div>
                                        Xem Nhiều Nhất
                                    </a>
                                    <a class="btn-filter button__sort {{ $re_sort == 'price_asc' ? 'active' : '' }}" href="{{ route('home.shop.detail',['slug' => $brand->slug,'category' => $re_cate,'price_range' => $re_price,'sort' => 'price_asc' ]) }}">
                                        <div class="icon"></div>
                                        Giá Cao - Thấp
                                    </a><a class="btn-filter button__sort {{ $re_sort == 'price_desc' ? 'active' : '' }}" href="{{ route('home.shop.detail',['slug' => $brand->slug,'category' => $re_cate,'price_range' => $re_price,'sort' => 'price_desc' ]) }}"><div class="icon"></div>
                                        Giá Thấp - Cao
                                    </a>
                                @elseif($re_cate != '' && $re_price == '')
                                    <a class="btn-filter button__sort {{ $re_sort == 'sale' ? 'active' : '' }}" href="{{ route('home.shop.detail',['slug' => $brand->slug,'category' => $re_cate,'sort' => 'sale' ]) }}"><div class="icon">
                                    </div>
                                        Bán Chạy Nhất
                                    </a>
                                    <a class="btn-filter button__sort {{ $re_sort == 'view' ? 'active' : '' }}" href="{{ route('home.shop.detail',['slug' => $brand->slug,'category' => $re_cate,'sort' => 'view' ]) }}">
                                        <div class="icon"></div>
                                        Xem Nhiều Nhất
                                    </a>
                                    <a class="btn-filter button__sort {{ $re_sort == 'price_asc' ? 'active' : '' }}" href="{{ route('home.shop.detail',['slug' => $brand->slug,'category' => $re_cate,'sort' => 'price_asc' ]) }}">
                                        <div class="icon"></div>
                                        Giá Cao - Thấp
                                    </a><a class="btn-filter button__sort {{ $re_sort == 'price_desc' ? 'active' : '' }}" href="{{ route('home.shop.detail',['slug' => $brand->slug,'category' => $re_cate,'sort' => 'price_desc' ]) }}"><div class="icon"></div>
                                        Giá Thấp - Cao
                                    </a>
                                @elseif($re_cate == '' && $re_price != '')
                                    <a class="btn-filter button__sort {{ $re_sort == 'sale' ? 'active' : '' }}" href="{{ route('home.shop.detail',['slug' => $brand->slug,'price_range' => $re_price,'sort' => 'sale' ]) }}"><div class="icon">
                                    </div>
                                        Bán Chạy Nhất
                                    </a>
                                    <a class="btn-filter button__sort {{ $re_sort == 'view' ? 'active' : '' }}" href="{{ route('home.shop.detail',['slug' => $brand->slug,'price_range' => $re_price,'sort' => 'view' ]) }}">
                                        <div class="icon"></div>
                                        Xem Nhiều Nhất
                                    </a>
                                    <a class="btn-filter button__sort {{ $re_sort == 'price_asc' ? 'active' : '' }}" href="{{ route('home.shop.detail',['slug' => $brand->slug,'price_range' => $re_price,'sort' => 'price_asc' ]) }}">
                                        <div class="icon"></div>
                                        Giá Cao - Thấp
                                    </a><a class="btn-filter button__sort {{ $re_sort == 'price_desc' ? 'active' : '' }}" href="{{ route('home.shop.detail',['slug' => $brand->slug,'price_range' => $re_price,'sort' => 'price_desc' ]) }}"><div class="icon"></div>
                                        Giá Thấp - Cao
                                    </a>
                                @else 
                                    
                                    <a class="btn-filter button__sort {{ $re_sort == 'sale' ? 'active' : '' }}" href="{{ route('home.shop.detail',['slug' => $brand->slug,'sort' => 'sale' ]) }}"><div class="icon">
                                    </div>
                                        Bán Chạy Nhất
                                    </a>
                                    <a class="btn-filter button__sort {{ $re_sort == 'view' ? 'active' : '' }}" href="{{ route('home.shop.detail',['slug' => $brand->slug,'sort' => 'view' ]) }}">
                                        <div class="icon"></div>
                                        Xem Nhiều Nhất
                                    </a>
                                    <a class="btn-filter button__sort {{ $re_sort == 'price_asc' ? 'active' : '' }}" href="{{ route('home.shop.detail',['slug' => $brand->slug,'sort' => 'price_asc' ]) }}">
                                        <div class="icon"></div>
                                        Giá Cao - Thấp
                                    </a><a class="btn-filter button__sort {{ $re_sort == 'price_desc' ? 'active' : '' }}" href="{{ route('home.shop.detail',['slug' => $brand->slug,'sort' => 'price_desc' ]) }}"><div class="icon"></div>
                                        Giá Thấp - Cao
                                    </a>
                                    
                                @endif
                                
                                
                            </div>
                        </div>
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                aria-labelledby="v-pills-home-tab">
                                <div class="row" id="product-list">
                                    @foreach ($products as $item)
                                    <div class="col-xl-3 col-sm-6 col-lg-4">
                                        <div class="wsus__product_item">
                                            {{-- <span class="wsus__new">New</span> --}}
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
                                                <a class="wsus__pro_name wsus__pro_name-home"  data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->name }}" href="{{ route('product-detail',$item->slug) }}">{{ $item->name }}</a>
                                                <p class="wsus__price text-danger"  >{{ number_format($item->offer_price, 0, ',', '.') }}&#8363;</p>
                                                {{-- <a class="add_cart" href="#">Thêm vào giỏ hàng</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                aria-labelledby="v-pills-profile-tab">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="wsus__product_item wsus__list_view">
                                            <span class="wsus__new">New</span>
                                            <span class="wsus__minus">-20%</span>
                                            <a class="wsus__pro_link" href="product_details.html">
                                                <img src="images/pro4.jpg" alt="product"
                                                    class="img-fluid w-100 img_1" />
                                                <img src="images/pro4_4.jpg" alt="product"
                                                    class="img-fluid w-100 img_2" />
                                            </a>
                                            <div class="wsus__product_details">
                                                <a class="wsus__category" href="#">fashion </a>
                                                <p class="wsus__pro_rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span>(17 review)</span>
                                                </p>
                                                <a class="wsus__pro_name" href="#">men's casual fashion watch</a>
                                                <p class="wsus__price">$159 <del>$200</del></p>
                                                <p class="list_description">Ultrices eros in cursus turpis massa cursus
                                                    mattis. Volutpat ac tincidunt vitae semper quis lectus. Aliquam id
                                                    diam maecenas ultricies… </p>
                                                <ul class="wsus__single_pro_icon">
                                                    <li><a class="add_cart" href="#">add to cart</a></li>
                                                    <li><a href="#"><i class="far fa-heart"></i></a></li>
                                                    <li><a href="#"><i class="far fa-random"></i></a>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__product_item wsus__list_view">
                                            <span class="wsus__minus">-20%</span>
                                            <a class="wsus__pro_link" href="product_details.html">
                                                <img src="images/pro9.jpg" alt="product"
                                                    class="img-fluid w-100 img_1" />
                                                <img src="images/pro9_9.jpg" alt="product"
                                                    class="img-fluid w-100 img_2" />
                                            </a>
                                            <div class="wsus__product_details">
                                                <a class="wsus__category" href="#">fashion </a>
                                                <p class="wsus__pro_rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span>(5 review)</span>
                                                </p>
                                                <a class="wsus__pro_name" href="#">men's casual sholder bag</a>
                                                <p class="wsus__price">$60</p>
                                                <p class="list_description">Ultrices eros in cursus turpis massa cursus
                                                    mattis. Volutpat ac tincidunt vitae semper quis lectus. Aliquam id
                                                    diam maecenas ultricies… </p>
                                                <ul class="wsus__single_pro_icon">
                                                    <li><a class="add_cart" href="#">add to cart</a></li>
                                                    <li><a href="#"><i class="far fa-heart"></i></a></li>
                                                    <li><a href="#"><i class="far fa-random"></i></a>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__product_item  wsus__list_view">
                                            <span class="wsus__new">New</span>
                                            <a class="wsus__pro_link" href="product_details.html">
                                                <img src="images/headphone_1.jpg" alt="product"
                                                    class="img-fluid w-100 img_1" />
                                                <img src="images/headphone_2.jpg" alt="product"
                                                    class="img-fluid w-100 img_2" />
                                            </a>
                                            <div class="wsus__product_details">
                                                <a class="wsus__category" href="#">electronic </a>
                                                <p class="wsus__pro_rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span>(17 review)</span>
                                                </p>
                                                <a class="wsus__pro_name" href="#">bluetooth headphone</a>
                                                <p class="wsus__price">$40 <del>$50</del></p>
                                                <p class="list_description">Ultrices eros in cursus turpis massa cursus
                                                    mattis. Volutpat ac tincidunt vitae semper quis lectus. Aliquam id
                                                    diam maecenas ultricies… </p>
                                                <ul class="wsus__single_pro_icon">
                                                    <li><a class="add_cart" href="#">add to cart</a></li>
                                                    <li><a href="#"><i class="far fa-heart"></i></a></li>
                                                    <li><a href="#"><i class="far fa-random"></i></a>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__product_item wsus__list_view">
                                            <span class="wsus__new">New</span>
                                            <span class="wsus__minus">-20%</span>
                                            <a class="wsus__pro_link" href="product_details.html">
                                                <img src="images/tab_1.jpg" alt="product"
                                                    class="img-fluid w-100 img_1" />
                                                <img src="images/tab_2.jpg" alt="product"
                                                    class="img-fluid w-100 img_2" />
                                            </a>
                                            <div class="wsus__product_details">
                                                <a class="wsus__category" href="#">electronic </a>
                                                <p class="wsus__pro_rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span>(17 review)</span>
                                                </p>
                                                <a class="wsus__pro_name" href="#">apple 10 serise tab </a>
                                                <p class="wsus__price">$490 <del>$500</del></p>
                                                <p class="list_description">Ultrices eros in cursus turpis massa cursus
                                                    mattis. Volutpat ac tincidunt vitae semper quis lectus. Aliquam id
                                                    diam maecenas ultricies… </p>
                                                <ul class="wsus__single_pro_icon">
                                                    <li><a class="add_cart" href="#">add to cart</a></li>
                                                    <li><a href="#"><i class="far fa-heart"></i></a></li>
                                                    <li><a href="#"><i class="far fa-random"></i></a>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__product_item wsus__list_view">
                                            <span class="wsus__new">New</span>
                                            <a class="wsus__pro_link" href="product_details.html">
                                                <img src="images/kids_1.jpg" alt="product"
                                                    class="img-fluid w-100 img_1" />
                                                <img src="images/kids_2.jpg" alt="product"
                                                    class="img-fluid w-100 img_2" />
                                            </a>
                                            <div class="wsus__product_details">
                                                <a class="wsus__category" href="#">fashion </a>
                                                <p class="wsus__pro_rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span>(17 review)</span>
                                                </p>
                                                <a class="wsus__pro_name" href="#">kid's dress </a>
                                                <p class="wsus__price">$30 <del>$40</del></p>
                                                <p class="list_description">Ultrices eros in cursus turpis massa cursus
                                                    mattis. Volutpat ac tincidunt vitae semper quis lectus. Aliquam id
                                                    diam maecenas ultricies… </p>
                                                <ul class="wsus__single_pro_icon">
                                                    <li><a class="add_cart" href="#">add to cart</a></li>
                                                    <li><a href="#"><i class="far fa-heart"></i></a></li>
                                                    <li><a href="#"><i class="far fa-random"></i></a>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__product_item wsus__list_view">
                                            <span class="wsus__minus">-20%</span>
                                            <a class="wsus__pro_link" href="product_details.html">
                                                <img src="images/pro4.jpg" alt="product"
                                                    class="img-fluid w-100 img_1" />
                                                <img src="images/pro4_4.jpg" alt="product"
                                                    class="img-fluid w-100 img_2" />
                                            </a>
                                            <div class="wsus__product_details">
                                                <a class="wsus__category" href="#">fashion </a>
                                                <p class="wsus__pro_rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span>(17 review)</span>
                                                </p>
                                                <a class="wsus__pro_name" href="#">men's casual fashion watch</a>
                                                <p class="wsus__price">$159 <del>$200</del></p>
                                                <p class="list_description">Ultrices eros in cursus turpis massa cursus
                                                    mattis. Volutpat ac tincidunt vitae semper quis lectus. Aliquam id
                                                    diam maecenas ultricies… </p>
                                                <ul class="wsus__single_pro_icon">
                                                    <li><a class="add_cart" href="#">add to cart</a></li>
                                                    <li><a href="#"><i class="far fa-heart"></i></a></li>
                                                    <li><a href="#"><i class="far fa-random"></i></a>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <section id="pagination">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link page_active" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        PRODUCT PAGE END
    ==============================-->


        <!--==========================
      PRODUCT MODAL VIEW START
    ===========================-->
    @foreach ($products as $product)
        @php
            
            $sale = \App\Models\ColorDetail::where('product_id', $product->id)->sum('sale');
            $tong = \App\Models\ColorDetail::where('product_id', $product->id)->sum('quantity') - $sale;
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
                                    <p class="description">{!! $product->short_description !!}</p>

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
                                        <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                        <li><a href="#"><i class="far fa-random"></i></a></li>
                                    </ul>
                                    <p class="brand_model"><span>Mã sản phẩm :</span> #{{ $product->id }}</p>
                            <p class="brand_model"><span>Thương hiệu :</span> {{ $product->brand->name }}</p>
                            <p class="brand_model"><span>Danh mục :</span> {{ $product->category->name }}</p>
                                    
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
   
@endsection

@push('scripts')


@endpush

