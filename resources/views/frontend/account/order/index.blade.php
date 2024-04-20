

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
                            $lido = '';
                        }else if($order->order_status == 1 && $order->shipper_status ==0){
                            $text = 'Chờ vận chuyển';
                            $lido = '';
                        }else if($order->order_status == 1 && $order->shipper_status ==2){
                            $text = 'Chờ vận chuyển';
                            $lido = '';
                        }
                        else if($order->order_status == 2 && $order->shipper_status ==1){
                            $text = 'Đang giao hàng';
                            $lido = '';
                        }else if($order->order_status == 3 ){
                            $text = 'Hoàn thành';
                            $lido = '';
                        }else if($order->order_status == 4 ){
                            $text = 'Đã hủy';
                            $lido = $order->fail_reason;
                        }else if($order->order_status == 5 ){
                            $text = 'Giao hàng không thành công';
                            $lido = $order->fail_reason;
                        }
                    @endphp
                    @if ($order->order_status == 0)
                        
                    <div class="bv3eJE" >
                        
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Huỷ đơn hàng
                        </button>
  
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="" method="post">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Lý do hủy đơn</h5>
                                        <button type="button" class="close btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="text-light">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                        <p><textarea  rows="5" placeholder="Nhập lí do hủy đơn hàng...(bắt buộc)" style="
                                            padding: 10px;
                                        " class="form-control lidohuydon"></textarea></p>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" id="{{ $order->id }}" onclick="huydonhang(this.id)" class="btn btn-success">Gửi lý do hủy</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <span class="text-info">
                            {{ $text }} </span>
                        </span>
                       
                    </div>
                    @elseif($order->order_status == 4)
                        
                        <div class="bv3eJE" >
                            <span class="text-danger">
                                {{ $text }} - <span style="
                                color: grey;
                                font-size: 14px;
                                text-transform: capitalize;
                            ">Lí do: {{ $lido }}
                            </span>
                        
                        </div>
                    @elseif($order->order_status == 5)
                    
                    <div class="bv3eJE" >
                        <span class="text-danger">
                            {{ $text }} - <span style="
                            color: grey;
                            font-size: 14px;
                            text-transform: capitalize;
                        ">Lí do: {{ $lido }}
                        </span>
                    
                    </div>
                    @elseif($order->order_status == 3)
                    <div class="bv3eJE" >
                        <span class="text-success">
                            {{ $text }} 
                        </span>
                    
                    </div>
                    @else
                    <div class="bv3eJE" >
                        <span class="text-info">
                            {{ $text }} 
                        </span>
                    
                    </div>
                    @endif
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
                                                                @php

                                                                    $color = \App\Models\Color::where('id', $item->color_id)->first();
                                                                    
                                                                @endphp
                                                                <div class="rsautk" tabindex="0">Phân loại hàng: {{ $color->name }}</div>
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
                          
                            @if($order->amount < $order->sub_total)
                            <b class="wsus__price text-danger " style="font-size: 19px;">Tổng tiền: {{ number_format($order->amount, 0, ',', '.') }}&#8363; <del style="font-size: 16px; color:grey"> {{ number_format($order->sub_total, 0, ',', '.') }}&#8363;</del></b>
                            @else
                            <b class="wsus__price text-danger " style="font-size: 19px;">Tổng tiền: {{ number_format($order->amount, 0, ',', '.') }}&#8363; </b>
                            @endif
                            {{-- <label class="juCcT0">Thành tiền:</label>
                            <div class="t7TQaf" tabindex="0" aria-label="Thành tiền: ₫289.000">{{ number_format($order->amount, 0, ',', '.') }}&#8363;</div> --}}
                        </div>
                        {{-- @if ($order->order_status == 3)
                        <div class="NWUSQP">
                            <a href="" class="btn btn-info text-light">Đánh giá</a>
                        </div>
                        @endif --}}
                       
                    </div>
                    
                        
                </div>
            @endforeach
        @endif
        
        
    </div>
</div>

@endsection

@push('scripts')
{{-- {{ $dataTable->scripts(attributes: ['type'=>'module']) }} --}}
<script>
    function huydonhang(id){
        var id = id;
        var lydo = $('.lidohuydon').val();
        var order_status = 4;
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('user.orders.chang-status-cancel') }}",
            method: "POST",

            data: {id: id, lydo: lydo, order_status: order_status, _token: _token},
            success: function(data){
                alert('Hủy đơn hàng thành công!');
                location.reload();
            }
        });
    }
</script>
@endpush