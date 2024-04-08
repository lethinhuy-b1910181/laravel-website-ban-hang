

@extends('frontend.layouts.master')

@section('content')
<div class="container BtZOqO">
    @include('frontend.sidebar')

    <div class="order-content">
        <div class="row">
            <div class="">
                @include('frontend.account.order.header')
            </div>
            <div class="" style="padding:10px">
                <form action="{{ route('user.orders.index') }}"  method="GET">
                    @csrf
                    <div class="box-search-order" >
                        
                            <button type="submit" class="btn"><i class="  far fa-search"></i></button>
                            <input  placeholder="Bạn có thể tìm kiếm theo ID đơn hàng " value="{{ request()->search }}" name="search">

                    </div>
                </form>
            </div>
        </div>
        @if ($orders != '')
            @foreach ($orders as $order)
                @php
                    $orderDetail = \App\Models\OrderProduct::where('order_id', $order->id)->get();
                @endphp
                <div class="order-content-detail">
                    @php
                        if($order->order_status == 0){
                            $text = 'Chờ xác nhận';
                        }else if($order->order_status == 1 && $order->shipper_status ==0){
                            $text = 'Chờ vận chuyển';
                        }else if($order->order_status == 2 && $order->shipper_status ==1){
                            $text = 'Đang giao hàng';
                        }else if($order->order_status == 3 ){
                            $text = 'Hoàn thành';
                        }else if($order->order_status == 4 ){
                            $text = 'Đã hủy';
                        }
                    @endphp
                    <div class="bv3eJE" tabindex="0">{{ $text }}</div>
                    <div class="kG_yF0"></div>
                    @foreach ($orderDetail as $item)
                        @php
                            $product = \App\Models\Product::where('id', $item->product_id)->first();
                        @endphp
                    <div class="">
                        <a class="col-12"  href="{{ route('user.orders.show', $order->id) }}">
                            <div>
                                <div class="bdAfgU">
                                    <div class="FNHV0p">
                                        <div>
                                            <section>
                                                <div class="mZ1OWk">
                                                    <div class="dJaa92">
                                                        <img src="{{ asset($product->image) }}" class="gQuHsZ" alt="" tabindex="0">
                                                        <div class="nmdHRf">
                                                            <div>
                                                                <div class="zWrp4w">
                                                                    <span class="DWVWOJ" tabindex="0">{{ $item->product_name }}</span>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="rsautk" tabindex="0">Phân loại hàng: Xanh da trời,Massage + Sưởi ấm</div>
                                                                <div class="j3I_Nh" tabindex="0">x{{ $item->qty }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ylYzwa" tabindex="0">
                                                        <div class="YRp1mm">
                                                            <span class="nW_6Oi PNlXhK">{{ number_format($item->unit_price, 0, ',', '.') }}&#8363;</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                        <div class="PB3XKx"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                    <div class="kG_yF0"></div>
                    <div class="LwXnUQ">
                        <div class="NWUSQP">
                            <label class="juCcT0">Thành tiền:</label>
                            <div class="t7TQaf" tabindex="0" aria-label="Thành tiền: ₫289.000">{{ number_format($order->amount, 0, ',', '.') }}&#8363;</div>
                        </div>
                        @if ($order->order_status == 3)
                        <div class="NWUSQP">
                            <a href="" class="btn btn-info text-light">Đánh giá</a>
                        </div>
                        @endif
                       
                    </div>
                    
                        
                </div>
            @endforeach
        @endif
        
        
    </div>
</div>

@endsection

@push('scripts')
{{-- {{ $dataTable->scripts(attributes: ['type'=>'module']) }} --}}

@endpush