

@extends('frontend.layouts.master')

@section('content')
<div class="container BtZOqO">
    @include('frontend.sidebar')

    <div class="order-content">
        <div class="row">
            <div class="">
                @include('frontend.account.order.header')
            </div>
            {{-- <div class="" style="padding:10px">
                <div class="box-search-order" >
                    <button type="submit" class="btn"><i class="  far fa-search"></i></button>
                    <input aria-label="" role="search" autocomplete="off" placeholder="Bạn có thể tìm kiếm theo ID đơn hàng hoặc Tên Sản phẩm" value="">
                
                </div>
            </div> --}}
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
                    </div>
                        <div class="NWUSQP">
                            <a href="" class="btn btn-info text-light" data-bs-toggle="modal" data-bs-target="#reviewModal-{{ $order->id }}">Đánh giá</a>
                        </div>
                  
                        
                </div>
            @endforeach
        @endif
        
        
    </div>
</div>

@endsection

 <!--==========================
      REVIEW MODAL VIEW START
    ===========================-->
    @foreach ($orders as $order)
    @php
        $orderDetail = \App\Models\OrderProduct::where('order_id', $order->id)->get();
    @endphp
    <section class="review_popup_modal">
        <div class="modal fade" id="reviewModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                class="far fa-times"></i></button>
                        <div class="col-12">
                            <h4>Đánh giá sản phẩm</h4>
                            <br>
                            <div class="col-12">
                                @foreach ($orderDetail as $item)
                                    @php
                                        $product = \App\Models\Product::where('id', $item->product_id)->first();
                                    @endphp
                                    <div class="" style="background: aliceblue ">
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
                                    <div class="" >
                                        <div class="input-star row">
                                            <input type="text" name="" value="so sao" id="">
                                        </div>
                                        
                                        <div class="input-star row">
                                            <textarea name="" id="" cols="10" rows="4"></textarea>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                @endforeach
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-success text-light">Hoàn thành</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach
    <!--==========================
      REVIEW MODAL VIEW END
    ===========================-->


@push('scripts')
{{-- {{ $dataTable->scripts(attributes: ['type'=>'module']) }} --}}

@endpush