<section class="QmO3Bu" aria-role="tablist">
    <h2 class="a11y-hidden"></h2>
    <a class="KI5har {{ setActiveHead(['admin.order.index']) }}" href="{{ route('admin.order.index') }}">
        <span class="NoH9rC">Tất cả</span>
    </a>
    <a class="KI5har {{ setActiveHead(['admin.order.new-order']) }}" href="{{ route('admin.order.new-order') }}">
        <span class="NoH9rC">Đơn mới</span>

        @php
        $orderCount = \App\Models\Order::where('order_status', 0)->count();
        
        @endphp
        @if ($orderCount !=0)
        <span class="jcg0Gr text-danger">({{ $orderCount }})</span>
            
        @endif
    </a>
    <a class="KI5har {{ setActiveHead(['admin.order.wait-ship']) }}"  href="{{ route('admin.order.wait-ship') }}">
        <span class="NoH9rC">Chờ vận chuyển</span>
        @php
        $orderCount = \App\Models\Order::where('order_status', 1)->count();
        
        @endphp
        @if ($orderCount !=0)
        <span class="jcg0Gr text-danger">({{ $orderCount }})</span>
            
        @endif
    </a>
    <a class="KI5har {{ setActiveHead(['admin.order.shipping']) }}"  href="{{ route('admin.order.shipping') }}">
        <span class="NoH9rC">Đang giao</span>
        @php
        $orderCount = \App\Models\Order::where('order_status', 2)->where('shipper_status', 1)->count();
        
        @endphp
        @if ($orderCount !=0)
        <span class="jcg0Gr text-danger" id="order-count">({{ $orderCount }})</span>
        @endif
       
    </a>
  
    <a class="KI5har {{ setActiveHead(['admin.order.completed']) }}"  href="{{ route('admin.order.completed') }}">
        <span class="NoH9rC">Hoàn thành</span>
        @php
        $orderCount = \App\Models\Order::where('order_status', 3)->count();
        
        @endphp
        @if ($orderCount !=0)
        <span class="jcg0Gr text-danger " >({{ $orderCount }})</span>
            
        @endif
    </a>

    <a class="KI5har {{ setActiveHead(['admin.order.canceled']) }}"  href="{{ route('admin.order.canceled') }}">
        <span class="NoH9rC">Đã hủy</span>
        @php
        $orderCount = \App\Models\Order::where('order_status', 4)->count();
        
        @endphp
        @if ($orderCount !=0)
        <span class="jcg0Gr text-danger">({{ $orderCount }})</span>
            
        @endif
    </a>
    
</section>