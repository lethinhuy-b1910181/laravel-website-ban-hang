@php
    $user = Auth::guard('admin')->user(); // Lấy thông tin người dùng hiện tại đang đăng nhập
    $shipper = Auth::guard('shipper')->user(); // Lấy thông tin người dùng hiện tại đang đăng nhập
@endphp
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="index.html">Stisla</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">St</a>
      </div>
      <ul class="sidebar-menu">
        @if ($shipper && !$user )
        <li class="dropdown {{ setActive(['shipper.shipper.index']) }}">
          <a href="{{ route('shipper.shipper.index') }}" class="nav-link "><i class="icon-size fas fa-home"></i><span>Đơn hàng</span></a>
          
        </li>
        
        @endif
        @if ($user && $user->isSuperAdmin() )
        <li class="dropdown {{ setActive(['admin.dashboard']) }}">
          <a href="{{ route('admin.dashboard') }}" class="nav-link "><i class="icon-size fas fa-home"></i><span>Dashboard</span></a>
          
        </li>
        @endif
        @if ($user && ($user->isSuperAdmin() || $user->is_order()))
          <li class="dropdown {{ setActive(['admin.order.*']) }}">
            <a href="{{ route('admin.order.index') }}" class="nav-link  "><i class="icon-size fa fa-shopping-cart text-info"></i><span>Đơn hàng</span></a>
            
          </li>
        @endif
        @if ($user && ( $user->isSuperAdmin() || $user->is_product()))
          <li class="dropdown {{ setActive(['admin.product.*']) }}">
            <a href="{{ route('admin.product.index') }}" class="nav-link "><i class="icon-size text-danger fa fa-shopping-bag"></i><span>Sản phẩm</span></a>
            
          </li>
         
          <li class="dropdown {{ setActive(['admin.category.*']) }} ">
            <a href="{{ route('admin.category.index') }}" class="nav-link "><i class="icon-size fa fa-qrcode text-info"></i><span>Danh mục</span></a>
            
          </li>
          <li class="dropdown {{ setActive(['admin.brand.*']) }}">
            <a href="{{ route('admin.brand.index') }}" class="nav-link "><i class="icon-size fa fa-camera-retro text-dark"></i><span>Thương hiệu</span></a>
            
          </li>
          
          {{-- <li class="dropdown {{ setActive(['admin.product-color.*']) }}">
            <a href="{{ route('admin.product-color.index') }}" class="nav-link "><i class="icon-size fa fa-magic text-info"></i><span>Màu sắc</span></a>
            
          </li> --}}
        <li class="dropdown {{ setActive(['admin.provider.*']) }}">
          <a href="{{ route('admin.provider.index') }}" class="nav-link "><i class="icon-size fas fa-star text-warning"></i><span>Nhà cung cấp</span></a>
          
        </li>
        @endif
        @if ($user && ( $user->isSuperAdmin() || $user->is_receipt()))
        <li class="dropdown {{ setActive(['admin.receipt.*']) }}">
          <a href="{{ route('admin.receipt.index') }}" class="nav-link "><i class="ml-1 icon-size text-success bx bx-detail"></i><span>Nhập kho</span></a>
          
        </li>
        @endif
        @if ($user && $user->isSuperAdmin() )
        <li class="dropdown {{ setActive(['admin.coupon.*']) }}">
          <a href="{{ route('admin.coupon.index') }}" class="nav-link "><i class="icon-size fa fa-barcode text-dark"></i><span>Mã giảm giá</span></a>
          
        </li>
        <li class="dropdown {{ setActive(['admin.customer.*']) }}">
          <a href="{{ route('admin.customer.index') }}" class="nav-link " ><i class="icon-size fas fa-user"></i> <span>Khách hàng</span></a>
        </li>
        <li class="dropdown {{ setActive(['admin.staff.*']) }}">
          <a href="{{ route('admin.staff.index') }}" class="nav-link  " ><i class="icon-size fas fa-user-check"></i> <span>Nhân viên</span></a>
          
          
        </li>
        <li class="dropdown {{ setActive(['admin.shipper.*']) }}">
          <a href="{{ route('admin.shipper.index') }}" class="nav-link  " ><i class="icon-size fas fa-user-check"></i> <span>Người giao hàng</span></a>
          
          
        </li>
        <li class="dropdown {{ setActive(['admin.role.*']) }}">
          <a href="{{ route('admin.role.index') }}" class="nav-link  " ><i class="icon-size fas fa-user-cog"></i> <span>Phân quyền</span></a>
          
          
        </li>
        @endif
        @if ($user && ( $user->isSuperAdmin() || $user->is_blog()))
        <li><a class="nav-link" href="blank.html"><i class="icon-size far fa-edit text-info"></i> <span>Bài viết</span></a></li>
        <li class="dropdown {{ setActive(['admin.slider.*']) }}">
          <a href="#" class="nav-link has-dropdown"><i class="icon-size  fas fa-th text-primary"></i> <span>Cài đặt giao diện</span></a>
          <ul class="dropdown-menu">
            <li class="{{ setActive(['admin.slider.*']) }}"><a class="nav-link" href="{{ route('admin.slider.index') }}">Slider</a></li>
            <li><a class="nav-link" href="bootstrap-badge.html">Badge</a></li>
            <li><a class="nav-link" href="bootstrap-breadcrumb.html">Breadcrumb</a></li>
            
          </ul>
        </li>
        @endif
        
        
    </ul>

          </aside>
  </div>