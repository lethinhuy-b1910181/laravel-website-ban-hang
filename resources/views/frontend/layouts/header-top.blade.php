<div class="header__top">
    <div class="container">
        <div class="header__top--right">
          
            <ul class="header__top__nav">
                
                @php
                $check = \Illuminate\Support\Facades\Auth::guard('customer')->check();

                @endphp
              
                @if ($check)
                <li>
                    
                    <a href="{{ route('user.dashboard') }}"><i class="fa fa-user text-darklight"></i>{{ Auth::guard('customer')->user()->name }} </a>
                  </li>       
                @else
                    <li>
                    
                        <a href="{{ route('login') }}"><i class="fa fa-user text-darklight "></i> Đăng nhập/Đăng ký</a>
                      </li>   
                 @endif
                          
                 

            </ul>
        </div>
        <div class="header__top--left">
            <span><i class="fa fa-phone text-warning"></i> Gọi mua hàng:  0909.688.485 (8h - 21h)</span>
        </div>
        
    </div>
</div>