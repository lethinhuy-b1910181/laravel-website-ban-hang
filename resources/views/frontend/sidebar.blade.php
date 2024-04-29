<div class="epUsgf">
    <div class="u6SDuY">
        <a href="" class="w37kB7">
            <div class="shop-avt">
                <div class="shop-avt__placeholder">

                </div>
                <img src="{{ Auth::guard('customer')->user()->image ? asset( Auth::guard('customer')->user()->image) : asset('uploads/default.png') }}" alt="" class="shop-avt__img">
            </div>
        </a>
        <div class="vDMlrj">
            <div class="HtUK6o">
               {{ Auth::guard('customer')->user()->name }} 
            </div>
            <div class="">
                <a  href="{{ route('user.dashboard') }}" class="Kytn1s">
                    <i class="fa fa-pencil" ></i> Sửa hồ sơ 
                </a>
            </div>
        </div>
    </div>
    <div class="WDmP96">
            <ul class="dashboard_link">
                
              <li><a  class="{{ setActive(['user.dashboard']) }}" href="{{ route('user.dashboard') }}"><i class="far fa-user"></i> Tài khoản của tôi</a></li>
              <li><a  class="{{ setActive(['user.address.*']) }}" href="{{ route('user.address.index') }}"><i class="fal fa-gift-card"></i> Địa chỉ</a></li>
              <li><a class="{{ setActive(['user.orders.*']) }}" href="{{ route('user.orders.index') }}"><i class="fas fa-list-ul"></i> Đơn mua</a></li>
              <li><a href="{{ route('user.wishlist.index') }}" class="{{ setActive(['user.wishlist.index']) }}"><i class="far fa-heart"></i> Yêu thích</a></li>
              <li><a href="{{ route('user.coupon.index') }}" class="{{ setActive(['user.coupon.index']) }}"><i class="far fa-cloud-download-alt"></i> Voucher</a></li>
              <li><a href="#"><i class="far fa-star"></i> Đổi mật khẩu</a></li>
              <li>
                {{-- <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                this.closest('form').submit();"><i class="far fa-sign-out-alt"></i> Đăng xuất</a>

                </form> --}}
                <a href="{{ route('user.logout') }}" 
             
                class=" has-icon text-danger"
              >
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
              </a>
                
            </li>
            </ul>
        
    </div>
</div>