<section class="QmO3Bu" aria-role="tablist">
    <h2 class="a11y-hidden"></h2>
    <a class="KI5har {{ setActiveHead(['user.orders.index']) }}" href="{{ route('user.orders.index') }}">
        <span class="NoH9rC">Tất cả</span>
    </a>
    <a class="KI5har {{ setActiveHead(['user.orders.wait-confirm']) }}" href="{{ route('user.orders.wait-confirm') }}">
        <span class="NoH9rC">Chờ xác nhận</span>

        @php
        $orderCount = \App\Models\OrderTotal::where('user_id', Auth::guard('customer')->user()->id)->where('order_status', 0)->count();
        
        @endphp
        @if ($orderCount !=0)
        <span class="jcg0Gr text-danger">({{ $orderCount }})</span>
            
        @endif
    </a>
    <a class="KI5har {{ setActiveHead(['user.orders.wait-ship']) }}"  href="{{ route('user.orders.wait-ship') }}">
        <span class="NoH9rC">Chờ vận chuyển</span>
        @php
        $orderCount = \App\Models\OrderTotal::where('user_id', Auth::guard('customer')->user()->id)->where('order_status', 1)->count();
        
        @endphp
        @if ($orderCount !=0)
        <span class="jcg0Gr text-danger">({{ $orderCount }})</span>
            
        @endif
    </a>
    <a class="KI5har {{ setActiveHead(['user.orders.shipping']) }}"  href="{{ route('user.orders.shipping') }}">
        <span class="NoH9rC">Đang giao hàng</span>
        @php
        $orderCount = \App\Models\OrderTotal::where('user_id', Auth::guard('customer')->user()->id)->where('order_status', 2)->where('shipper_status', 1)->count();
        
        @endphp
        @if ($orderCount !=0)
        <span class="jcg0Gr text-danger">({{ $orderCount }})</span>
        @endif
       
    </a>
  
    <a class="KI5har {{ setActiveHead(['user.orders.completed']) }}"  href="{{ route('user.orders.completed') }}">
        <span class="NoH9rC">Hoàn thành</span>
    </a>

    <a class="KI5har {{ setActiveHead(['user.orders.canceled']) }}"  href="{{ route('user.orders.canceled') }}">
        <span class="NoH9rC">Đã hủy</span>
    </a>
    
</section>