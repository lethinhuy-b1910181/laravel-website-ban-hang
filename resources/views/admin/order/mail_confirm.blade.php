<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gửi mail </title>
    <style>
        body{
            font-family: Arial;
            font-size: 14px;
            color: black;
        }
        .coupon{
           padding: 10px;
            width: 80%;
            /* border-radius: 15px; */
            margin: 0 auto;
            max-width: 700px;
        }
       .title-text{
            text-transform: uppercase;
            font-weight: 600;
            color: black;
       }
       .text{
        padding-left: 10px;
        color: black;
        margin-bottom: 5px !important;
       }
       .content{
        margin-bottom: 15px;
       }
       .text-space{
            display: flex;
            margin-bottom: 10px;
            padding-left: 15px;
            color: black;
            justify-content: space-between;
       }
       .name{
        text-decoration: none;
        font-size: 16px;
        color: blue;
       }
       .text-price{
        font-weight: 600;
        /* padding-top: 10px; */
        color: black;
        
       }
       .note{
        padding-top: 20px;
        font-size: 12px;
        color: red;
        text-align: center;
        
       }
       .col-12,.row{
        width: 100%;
       }
       .content{
        display: flex;

       }
       .col-6{
        width: 50%;
       }
       .col-2{
        width: 20%;
       }
       .col-10{
        width: 80%;
       }

       .col-3{
        width: 5%;
       }
       .col-9{
        width: 95%;
       }
       .total{
        padding-left: 100px;
        color: black;
       }
      
    </style>
   
</head>
<body>
    <div class="coupon">
        <div class="head">
            <p class="text">Xin chào <b>{{ $info_array['customer_name'] }}</b>,</p>
            <p class="text">Cảm ơn Anh/chị đã đặt hàng tại <a href="http://127.0.0.1:8000/" target="_blank" rel="noopener noreferrer">Camera Shop</a>!</p>
            <p class="text">Đơn hàng của Anh/chị đã được tiếp nhận, chúng tôi sẽ nhanh chóng liên hệ với Anh/chị.</p>
        </div>
        <br>
        <hr>
        <div class="nav">
            <div class="row content col-12">
                <div class="col-6">
                    <div class="title-text">Thông tin mua hàng</div>
                    <p class="text">{{ $info_array['customer_name'] }}</p>
                    <p class="text">{{ $info_array['customer_phone'] }}</p>
                    <p class="text">{{ $info_array['customer_email'] }}</p>
                </div>
                <div class="col-6">
                    <div class="title-text">Thông tin người nhận</div>
                    <p class="text">{{ $info_array['customer_name'] }}</p>
                    <p class="text">{{ $info_array['customer_phone'] }}</p>
                    <p class="text">{{ $info_array['customer_address'] }}</p>
                    <p class="text">{{ $info_array['customer_address_ward'] }},{{ $info_array['customer_address_district'] }}, {{ $info_array['customer_address_city'] }}.</p>
                </div>
            </div>
       
    
            <div class="row content col-12">
                <div class="col-6">
                    <div class="title-text">Phương thức thanh toán</div>
                    @php
                        if($info_array['order_payment_method'] != 'VNPay')
                            $t = 'Thanh toán khi giao hàng (COD)';
                        else $t = 'Thanh toán VNPay';
                    @endphp
                    <p class="text">{{ $t }}</p>
                    
                </div>
                <div class="col-6">
                    <div class="title-text">Phương thức vận chuyển</div>
                    <p class="text">GIAO NHANH 2-4 NGÀY</p>
                    
                </div>
            </div>
         
            <div class="row  col-12">
               
                <div class="title-text">Thông tin đơn hàng</div>
                
                    
                
            </div>
    
            <div class="row content col-12">
                <div class="col-6">
                    
                    <p class="text">Mã đơn hàng: {{ $info_array['order_id'] }}</p>
                    
                </div>
                <div class="col-6">
                    <div class="title-text"></div>
                    <p class="text">Ngày đặt hàng: {{ $info_array['order_date'] }}</p>
                    
                </div>
            </div>
            <hr>
            @foreach ($cart_array as $item)
            <div class="row content col-12">
                    
                   
                    <div class="col-10" style="padding-left: 40px;">
                        <div class=""><a href="" class="name" target="_blank" rel="noopener noreferrer">{{ $item['product_name'] }}</a></div>
                        <div style="
                            color: gray;
                            padding-top:10px;
                        ">Phân loại hàng: {{ $item['color'] }}</div>
                        <br>
                        <div class="text-space  " > 
                            <div class="col-6" >{{number_format($item['unit_price'], 0, ',', '.')   }}&#8363; x {{ $item['qty'] }}</div>
                            <div class="col-6"style="text-align: right;">{{number_format($item['total_price'], 0, ',', '.')   }}&#8363; </div>
                        </div>
                        
                    </div>
                
                
            </div>
            <hr>
            @endforeach
            <br>
            <div class="row col-12 content" >
                
                <div class="col-10">
                    <div class="text-space " >
                        <div class="col-6">Tổng tiền hàng: </div>
                        <div class="text-price col-6"style="text-align: right;">{{number_format($info_array['order_sub_total'], 0, ',', '.')   }}&#8363;</div>
                        
                    </div>
                    <div class="text-space" >
                        <div class="col-6">Giảm giá:</div>
                        @if ($discount_array == '')
                            <div class="text-price col-6"style="text-align: right;">0</div>
                        @else
                            @php
                                if($discount_array['coupon_type'] == 0){
                                    $price = $discount_array['coupon_min_price'];
                                    $icon = '%';
                                }else{
                                    $price = number_format($discount_array['coupon_min_price'], 0, ',', '.');
                                    $icon = '₫';
                                }
                            @endphp
                            <div class="text-price col-6"style="text-align: right;" >{{ $price }}{{ $icon }}</div>
                        @endif
                        
                    </div>
                    <div class="text-space" >
                        <div class="col-6">Tổng tiền giảm: </div>
                        @if ($discount_array == '')
                            <div class="text-price col-6"style="text-align: right;">- 0</div>
                        @else
                            <div class="text-price col-6"style="text-align: right;">- {{number_format($info_array['order_discount'], 0, ',', '.')   }}&#8363;</div>
                        @endif
                        
                    </div>
    
                    <div class="text-space" >
                        <div class="col-6" >Phí vận chuyển:</div>
                        <div class="text-price col-6"style="text-align: right;">0</div>
                        
                    </div>
                    <div class="text-space" >
                        <div class="col-6">Thành tiền: </div>
                        <div class="text-price col-6"style="text-align: right;">{{number_format($info_array['order_amount'], 0, ',', '.')   }}&#8363;</div>
                        
                    </div>
                </div>
                <div class="col-2"></div>
            </div>
        
            <div class="row">
                <p>Nếu có thắc mắc, vui lòng liên hệ Bộ phận Chăm sóc khách hàng tại website: <a href="http://127.0.0.1:8000/" target="_blank" rel="noopener noreferrer">Camera Shop</a>, hoặc liên hệ qua số hotline: 0909 688 485. Xin cảm ơn quý khách đã đặt hàng tại shop chúng tôi!</p>
                <p>Trân trọng,</p>
            </div>
            <hr>
            <div class="row col-12">
                <p class="note">Chú ý: Đây là email tự động từ dịch vụ CameraShop. Vui lòng không trả lời lại email này!</p>
            </div>
        </div>
    </div>
</body>
</html>