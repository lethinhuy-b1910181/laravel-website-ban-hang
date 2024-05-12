<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <title>Camera Shop</title>
    <link rel="icon" type="image/png" href="{{asset('frontend/images/favicon.png')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery.nice-number.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery.calendar.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/add_row_custon.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/mobile_menu.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery.exzoom.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/multiple-image-video.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/ranger_style.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery.classycountdown.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/venobox.min.css')}}">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css">

    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/responsive.css')}}">

  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!--Start of Fchat.vn--><script type="text/javascript" src="https://cdn.fchat.vn/assets/embed/webchat.js?id=663e23d4d8f27413fc3e4423" async="async"></script><!--End of Fchat.vn-->
    <!-- <link rel="stylesheet" href="css/rtl.css"> -->
</head>

<body>

    <!--============================
        HEADER START
    ==============================-->
    @include('frontend.layouts.header-top')
       
    <!--============================
        HEADER END
    ==============================-->


    <!--============================
        MAIN MENU START
    ==============================-->
  @include('frontend.layouts.menu')
    <!--============================
        MAIN MENU END
    ==============================-->
    {{-- @include('frontend.layouts.header') --}}
    <!--==========================
        POP UP START
    ===========================-->
    <!-- <section id="wsus__pop_up">
        <div class="wsus__pop_up_center">
            <div class="wsus__pop_up_text">
                <span id="cross"><i class="fas fa-times"></i></span>
                <h5>get up to <span>75% off</span></h5>
                <h2>Sign up to E-SHOP</h2>
                <p>Subscribe to the <b>E-SHOP</b> market newsletter to receive updates on special offers.</p>
                <form>
                    <input type="email" placeholder="Your Email" class="news_input">
                    <button type="submit" class="common_btn">go</button>
                    <div class="wsus__pop_up_check_box">
                    </div>
                </form>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault11">
                    <label class="form-check-label" for="flexCheckDefault11">
                        Don't show this popup again
                    </label>
                </div>
            </div>
        </div>
    </section> -->
    <!--==========================
        POP UP END
    ===========================-->
    <!--==========================
        Main Content Start
    ===========================-->

    @yield('content')
    <!--==========================
        Main Content end
    ===========================-->

    <!--============================
        FOOTER PART START
    ==============================-->
    {{-- <iframe src="https://chat.socialintents.com/c/chat-1714567044771" width="100%" style="height:100%;min-height:550px;" frameborder="0"></iframe> --}}
    <footer class="footer_2">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-xl-3 col-sm-7 col-md-6 col-lg-3">
                    <div class="wsus__footer_content">
                        <a class="wsus__footer_2_logo" href="{{ route('home') }}">
                            <img src="{{ asset('frontend/images/logo.png') }}" alt="logo">
                        </a>
                        <a class="action" href="callto:+8896254857456"><i class="fas fa-phone-alt"></i>
                            +84 909 688 485</a>
                        <a class="action" href="mailto:example@gmail.com"><i class="far fa-envelope"></i>
                            shopcamera243@gmail.com</a>
                        <p><i class="fal fa-map-marker-alt"></i> Ninh Kiều, TP. Cần Thơ</p>
                        <ul class="wsus__footer_social">
                            <li><a class="facebook" href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a class="twitter" href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a class="whatsapp" href="#"><i class="fab fa-whatsapp"></i></a></li>
                            <li><a class="pinterest" href="#"><i class="fab fa-pinterest-p"></i></a></li>
                            <li><a class="behance" href="#"><i class="fab fa-behance"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-5 col-md-4 col-lg-2">
                    <div class="wsus__footer_content">
                        <h5>VỀ CHÚNG TÔI</h5>
                        <ul class="wsus__footer_menu">
                            <li><a href="{{ route('home') }}"><i class="fas fa-caret-right"></i>Trang chủ</a></li>
                            <li><a href="{{ route('home.shop') }}"><i class="fas fa-caret-right"></i>Cửa hàng</a></li>
                            <li><a href="#"><i class="fas fa-caret-right"></i>Tin tức</a></li>
                            <li><a href="#"><i class="fas fa-caret-right"></i>Liên hệ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-5 col-md-4 col-lg-2">
                    <div class="wsus__footer_content">
                        <h5>CHÍNH SÁCH</h5>
                        <ul class="wsus__footer_menu">
                            <li><a href="#"><i class="fas fa-caret-right"></i>Chính sách thanh toán</a></li>
                            <li><a href="#"><i class="fas fa-caret-right"></i>Chính sách bảo mật</a></li>
                            <li><a href="#"><i class="fas fa-caret-right"></i>Chính sách bảo hành</a></li>
                            <li><a href="#"><i class="fas fa-caret-right"></i>Chính sách đổi trả</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-7 col-md-8 col-lg-5">
                    <div class="wsus__footer_content wsus__footer_content_2">
                        <h3>CHI NHÁNH</h3>
                        <p>Chi nhánh: 355/9 Sư Vạn Hạnh - P7 - Q10 - HCM</p>
                        <p>Chi nhánh: 355/9 Sư Vạn Hạnh - P7 - Q10 - HCM</p>
                        <p>Chi nhánh: 355/9 Sư Vạn Hạnh - P7 - Q10 - HCM</p>
                        
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="wsus__footer_bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="wsus__copyright d-flex justify-content-center">
                            <p>Copyright © LTNY.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--============================
        FOOTER PART END
    ==============================-->


    <!--============================
        SCROLL BUTTON START
    ==============================-->
    <div class="wsus__scroll_btn">
        <i class="fas fa-chevron-up"></i>
    </div>
    <!--============================
        SCROLL BUTTON  END
    ==============================-->


    <!--jquery library js-->
    <script src="{{asset('frontend/js/jquery-3.6.0.min.js')}}"></script>
    <!--bootstrap js-->
    <script src="{{asset('frontend/js/bootstrap.bundle.min.js')}}"></script>
    <!--font-awesome js-->
    <script src="{{asset('frontend/js/Font-Awesome.js')}}"></script>
    <!--select2 js-->
    <script src="{{asset('frontend/js/select2.min.js')}}"></script>
    <!--slick slider js-->
    <script src="{{asset('frontend/js/slick.min.js')}}"></script>
    <!--simplyCountdown js-->
    <script src="{{asset('frontend/js/simplyCountdown.js')}}"></script>
    <!--product zoomer js-->
    <script src="{{asset('frontend/js/jquery.exzoom.js')}}"></script>
    <!--nice-number js-->
    <script src="{{asset('frontend/js/jquery.nice-number.min.js')}}"></script>
    <!--counter js-->
    <script src="{{asset('frontend/js/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.countup.min.js')}}"></script>
    <!--add row js-->
    <script src="{{asset('frontend/js/add_row_custon.js')}}"></script>
    <!--multiple-image-video js-->
    <script src="{{asset('frontend/js/multiple-image-video.js')}}"></script>
    <!--sticky sidebar js-->
    <script src="{{asset('frontend/js/sticky_sidebar.js')}}"></script>
    <!--price ranger js-->
    <script src="{{asset('frontend/js/ranger_jquery-ui.min.js')}}"></script>
    <script src="{{asset('frontend/js/ranger_slider.js')}}"></script>
    <!--isotope js-->
    <script src="{{asset('frontend/js/isotope.pkgd.min.js')}}"></script>
    <!--venobox js-->
    <script src="{{asset('frontend/js/venobox.min.js')}}"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <!--classycountdown js-->
    <script src="{{asset('frontend/js/jquery.classycountdown.js')}}"></script>

    <!--main/custom js-->
    <script src="{{asset('frontend/js/main.js')}}"></script>

    <script>
        @if($errors->any())
            @foreach($errors->all() as $error)
              toastr.error("{{ $error }}")
            @endforeach
        @endif
      </script>
      <script type="text/javascript">
        $(document).ready(function(){
            $('#fileElem').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
   {{-- <script>
    window.fbAsyncInit = function() {
        FB.init({
            appId: "1784956665094089",
            xfbml: true,
            version: "v2.6"
        });
    };
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) { return; }
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<div class="fb-customerchat" page_id="302435969619023"></div> --}}
<!-- Start of LiveChat (www.livechat.com) code -->
{{-- <script>
    window.__lc = window.__lc || {};
    window.__lc.license = 17808990;
    ;(function(n,t,c){function i(n){return e._h?e._h.apply(null,n):e._q.push(n)}var e={_q:[],_h:null,_v:"2.0",on:function(){i(["on",c.call(arguments)])},once:function(){i(["once",c.call(arguments)])},off:function(){i(["off",c.call(arguments)])},get:function(){if(!e._h)throw new Error("[LiveChatWidget] You can't use getters before load.");return i(["get",c.call(arguments)])},call:function(){i(["call",c.call(arguments)])},init:function(){var n=t.createElement("script");n.async=!0,n.type="text/javascript",n.src="https://cdn.livechatinc.com/tracking.js",t.head.appendChild(n)}};!n.__lc.asyncInit&&e.init(),n.LiveChatWidget=n.LiveChatWidget||e}(window,document,[].slice))
</script> --}}
{{-- <noscript><a href="https://www.livechat.com/chat-with/17808990/" rel="nofollow">Chat with us</a>, powered by <a href="https://www.livechat.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a></noscript> --}}
<!-- End of LiveChat code -->


    {{-- <script src="//www.socialintents.com/api/chat/socialintents.1.3.js#2c9fa6a68f2fe733018f3428dea30413" async="async"></script> --}}
    {{-- <script>
        $(document).ready(function(){
      
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $('body').on('click', '.delete-item', function(event){
            event.preventDefault();
            let deleteUrl = $(this).attr('href');
            Swal.fire({
            title: "Xác nhận",
            text: "Xóa dòng dữ liệu này!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Xác nhận",
            cancelButtonText: "Hủy",
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                type: 'DELETE',
                url:deleteUrl,
                success: function(data){
                  if(data.status == 'success'){
                    Swal.fire({
                      title: "Xóa thành công!",
                      text: data.message
                    });
                  window.location.reload();
                  }
                  else if(data.status=='error'){
                    Swal.fire({
                      title: "Không thể xóa!",
                      text: data.message
                    });
                  window.location.reload();
                  }
                }, 
                error: function(xrr, status, error){
                  console.log(error);
                }
              });
            }
          });
        });
      });
    </script> --}}
    <script>
        $(document).ready(function(){
            // Thiết lập token CSRF cho tất cả các yêu cầu Ajax
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        
            // Bắt sự kiện click vào nút xóa
            $('body').on('click', '.delete-item', function(event){
                event.preventDefault();
                let deleteUrl = $(this).attr('href');
                Swal.fire({
                    title: "Xác nhận",
                    text: "Xóa dòng dữ liệu này!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Xác nhận",
                    cancelButtonText: "Hủy",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Gửi yêu cầu Ajax với phương thức DELETE
                        $.ajax({
                            type: 'DELETE',
                            url: deleteUrl,
                            success: function(data){
                                if(data.status == 'success'){
                                    Swal.fire({
                                        title: "Xóa thành công!",
                                        text: data.message
                                    });
                                    window.location.reload();
                                }
                                else if(data.status=='error'){
                                    Swal.fire({
                                        title: "Không thể xóa!",
                                        text: data.message
                                    });
                                    window.location.reload();
                                }
                            }, 
                            error: function(xhr, status, error){
                                // Xử lý lỗi
                                console.log(error);
                                Swal.fire({
                                    title: "Có lỗi xảy ra!",
                                    text: "Không thể thực hiện yêu cầu xóa."
                                });
                            }
                        });
                    }
                });
            });
        });
        </script>

        
        
    {{-- <script>
      document.getElementById('file-input').addEventListener('change', function() {
          var fileName = this.files[0].name;
          document.getElementById('file-name').innerHTML = fileName;
      });
    </script> --}}
    @include('frontend.layouts.scripts')
    @stack('scripts')
    
</body>

</html>