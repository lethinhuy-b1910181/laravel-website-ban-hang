
<nav class="wsus__main_menu d-none d-lg-block">
    <header>
        <div class="container">
            <div class="row">
                <div class="col-2 col-md-1 d-lg-none">
                    <div class="wsus__mobile_menu_area">
                        <span class="wsus__mobile_menu_icon"><i class="fal fa-bars"></i></span>
                    </div>
                </div>
                <div class="col-xl-2 col-7 col-md-8 col-lg-2">
                    <div class="wsus_logo_area">
                        <a class="wsus__header_logo" href="index.html">
                            <img src="{{ asset('frontend/images/logo_2.png') }}" alt="logo" class="img-fluid w-100">
                        </a>
                    </div>
                </div>
                
                <div class="col-xl-7 col-md-6 col-lg-4 d-none d-lg-block">
                    <div class="row">
                        <div class="wsus__search  col-12">
                            <form id="search-form" action="{{ route('home.shop') }}" autocomplete="off" method="GET">
                                @csrf
                                <input type="text" id="keywords" name="search" placeholder="Tìm kiếm sản phẩm" value="{{ request()->search }}">
                                
                                <button type="submit"><i class="  far fa-search"></i></button>
                                
                            </form>
                        </div>
                        {{-- <div class="col-2">
                            <span class="microphone mt-2" style="width: 20px">
                                <i class="fas fa-microphone"></i>
                                <span class="recording-icon"></span>
                            </span>
                        </div> --}}
    
                    </div>
                    
                    <div id="search-ajax"></div>
                </div>
                <div class="col-xl-3 col-3 col-md-3 col-lg-6">
                    <div class="wsus__call_icon_area">
                        <ul class="wsus__icon_area">
                            @php
                                $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();


                            @endphp
                            @if ($user )
                            @php
                                $cartCount = \App\Models\CartUser::where('user_id', $user->id)->get();
                                
                            @endphp
                            <li><a href="{{ route('user.wishlist.index') }}"><i class="fal fa-heart"></i><span>05</span></a></li>
                            <li>
                                <a class="wsus__cart_icon " 
                                href="{{ route('cart-details') }}" 
                                
                                 >
                                 <i class="fal fa-shopping-cart "></i><span id="cart-count">{{ $cartCount->count() }}</span></a></li>
                            @else
                            <li><a href="{{ route('user.wishlist.index') }}" data-bs-toggle="modal" data-bs-target="#whist-list-modal"><i class="fal fa-heart"></i></a></li>
                            <li><a class="wsus__cart_icon " href="#" data-bs-toggle="modal" data-bs-target="#cart-modal"><i
                                        class="fal fa-shopping-cart "></i></a></li>
                            @endif
                            
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="wsus__mini_cart">
            <h4>Giỏ hàng <span class="wsus_close_mini_cart"><i class="far fa-times"></i></span></h4>
            <ul  class="mini_cart_wrapper">
                
                @foreach ($cartItems as $item)
                @php
                    $product = \App\Models\Product::where('id', $item->product_id)->first();
                    
                @endphp
                    <li>
                        <div class="wsus__cart_img">
                            <a href="{{ route('product-detail', $product->slug) }}"><img src="{{ asset($product->image) }}" alt="product" class="img-fluid w-100"></a>
                            <a class="wsis__del_icon remove_sidebar_product" data-rowId="{{ $item->id }}" href="#" ><i class="fas fa-minus-circle"></i></a>
                        </div>
                        <div class="wsus__cart_text">
                            <a class="wsus__cart_title" href="{{ route('product-detail', $product->slug) }}">{{ $product->name }}</a>
                            <p>{{ number_format($product->offer_price, 0, ',', '.') }}&#8363;  </p>
                        </div>
                    </li>
                @endforeach
                
                
            </ul>
            <h5>Tổng tiền: <span>$3540</span></h5>
            <div class="wsus__minicart_btn_area">
                <a class="common_btn" href="{{ route('cart-details') }}">Xem giỏ hàng</a>
                <a class="common_btn" href="check_out.html">Thanh toán</a>
            </div>
        </div> --}}
    
    </header>

</nav>

{{--  --}}
<div class="modal fade" id="cart-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" class="justify-content-center d-flex">
          <h5 class="modal-title" id="exampleModalLongTitle">Thông báo</h5>
          <button type="button" class="close btn" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <p class="justify-content-center d-flex">Đăng nhập để xem giỏ hàng của bạn đi nào!</p> 
         <br>
         <div class="justify-content-center d-flex" >
            <a href="{{ route('login') }}" type="button" class="btn btn-danger">Đăng nhập ngay</a>

         </div>

        </div>
        
      </div>
    </div>
</div>

<div class="modal fade" id="whist-list-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" class="justify-content-center d-flex">
          <h5 class="modal-title" id="exampleModalLongTitle">Thông báo</h5>
          <button type="button" class="close btn" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <p class="justify-content-center d-flex">Đăng nhập để xem sản phẩm yêu thích của bạn đi nào!</p> 
         <br>
         <div class="justify-content-center d-flex" >
            <a href="{{ route('login') }}" type="button" class="btn btn-danger">Đăng nhập ngay</a>

         </div>

        </div>
        
      </div>
    </div>
</div>

{{-- <section id="wsus__mobile_menu">
    <span class="wsus__mobile_menu_close"><i class="fal fa-times"></i></span>
    <ul class="wsus__mobile_menu_header_icon d-inline-flex">

        <li><a href="wishlist.html"><i class="far fa-heart"></i> <span>2</span></a></li>

        <li><a href="compare.html"><i class="far fa-random"></i> </i><span>3</span></a></li>
    </ul>
    <form>
        <input type="text" placeholder="Search">
        <button type="submit"><i class="far fa-search"></i></button>
    </form>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                role="tab" aria-controls="pills-home" aria-selected="true">Categories</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                role="tab" aria-controls="pills-profile" aria-selected="false">main menu</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="wsus__mobile_menu_main_menu">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <ul class="wsus_mobile_menu_category">
                        <li><a href="#"><i class="fas fa-star"></i> hot promotions</a></li>
                        <li><a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThreew" aria-expanded="false"
                                aria-controls="flush-collapseThreew"><i class="fal fa-tshirt"></i> fashion</a>
                            <div id="flush-collapseThreew" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul>
                                        <li><a href="#">men's</a></li>
                                        <li><a href="#">wemen's</a></li>
                                        <li><a href="#">kid's</a></li>
                                        <li><a href="#">others</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThreer" aria-expanded="false"
                                aria-controls="flush-collapseThreer"><i class="fas fa-tv"></i> electronics</a>
                            <div id="flush-collapseThreer" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul>
                                        <li><a href="#">Consumer Electronic</a></li>
                                        <li><a href="#">Accessories & Parts</a></li>
                                        <li><a href="#">other brands</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThreerrp" aria-expanded="false"
                                aria-controls="flush-collapseThreerrp"><i class="fas fa-chair-office"></i>
                                furnicture</a>
                            <div id="flush-collapseThreerrp" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul>
                                        <li><a href="#">home</a></li>
                                        <li><a href="#">office</a></li>
                                        <li><a href="#">restaurent</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThreerrw" aria-expanded="false"
                                aria-controls="flush-collapseThreerrw"><i class="fal fa-mobile"></i> Smart
                                Phones</a>
                            <div id="flush-collapseThreerrw" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul>
                                        <li><a href="#">apple</a></li>
                                        <li><a href="#">xiaomi</a></li>
                                        <li><a href="#">oppo</a></li>
                                        <li><a href="#">samsung</a></li>
                                        <li><a href="#">vivo</a></li>
                                        <li><a href="#">others</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="#"><i class="fas fa-home-lg-alt"></i> Home & Garden</a></li>
                        <li><a href="#"><i class="far fa-camera"></i> Accessories</a></li>
                        <li><a href="#"><i class="fas fa-heartbeat"></i> healthy & Beauty</a></li>
                        <li><a href="#"><i class="fal fa-gift-card"></i> Gift Ideas</a></li>
                        <li><a href="#"><i class="fal fa-gamepad-alt"></i> Toy & Games</a></li>
                        <li><a href="#"><i class="fal fa-gem"></i> View All Categories</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="wsus__mobile_menu_main_menu">
                <div class="accordion accordion-flush" id="accordionFlushExample2">
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li><a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree" aria-expanded="false"
                                aria-controls="flush-collapseThree">shop</a>
                            <div id="flush-collapseThree" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample2">
                                <div class="accordion-body">
                                    <ul>
                                        <li><a href="#">men's</a></li>
                                        <li><a href="#">wemen's</a></li>
                                        <li><a href="#">kid's</a></li>
                                        <li><a href="#">others</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="vendor.html">vendor</a></li>
                        <li><a href="blog.html">blog</a></li>
                        <li><a href="daily_deals.html">campain</a></li>
                        <li><a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree101" aria-expanded="false"
                                aria-controls="flush-collapseThree101">pages</a>
                            <div id="flush-collapseThree101" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample2">
                                <div class="accordion-body">
                                    <ul>
                                        <li><a href="404.html">404</a></li>
                                        <li><a href="faqs.html">faq</a></li>
                                        <li><a href="invoice.html">invoice</a></li>
                                        <li><a href="about_us.html">about</a></li>
                                        <li><a href="team.html">team</a></li>
                                        <li><a href="product_grid_view.html">product grid view</a></li>
                                        <li><a href="product_grid_view.html">product list view</a></li>
                                        <li><a href="team_details.html">team details</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="track_order.html">track order</a></li>
                        <li><a href="daily_deals.html">daily deals</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section> --}}



@push('scripts')
    <script>
        
        $(document).ready(function(){
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $('#keywords').keyup(function(){
            let query = $(this).val();
            if(query != ''){
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('home.autocomplete') }}",
                    method: "POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        $('#search-ajax').fadeIn();
                        $('#search-ajax').html(data);
                    }
                    
                });
            }else{
                $('#search-ajax').fadeOut();
            }
           
        });
        // $(document).on('click', '.li-search-ajax', function(){
        //     $('#keywords').val($(this).text().trim());
        //     $('#search-ajax').fadeOut();
        // });
    
    }); 

    // var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
    // var SpeechGrammarList = SpeechGrammarList || webkitSpeechGrammarList;

    // var grammar = '#JSGF V1.0';
    // var recognition = new SpeechRecognition();
    // var SpeechRecognitionList = new SpeechGrammarList();
    // SpeechRecognitionList.addFromString(grammar , 1);
    // recognition.grammars = SpeechRecognitionList;
    // recognition.interimResults = false;
    // recognition.onresult = function(event){
    //     var lastResult = event.results.length - 1;
    //     var content = event.results[lastResult][0].transcript;
    //     console.log(content);
    // }
    // recognition.onspeechend = function(){
    //     recognition.stop();
    // }
    // recognition.onerror = function(event){
    //     console.log(event.error);
    //     const microphone = document.querySelector('.microphone');
    //     microphone.classList.remove('recording');
    // }
    // document.querySelector('.microphone'){
    //     recognition.start();
    //     const microphone = document.querySelector('.microphone');
    //     microphone.classList.add('recording');
    // }
    </script>
@endpush