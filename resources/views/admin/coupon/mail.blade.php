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
        }
        .coupon{
            border: 5px dashed #bbb;
            width: 80%;
            /* border-radius: 15px; */
            margin: 0 auto;
            max-width: 600px;
        }
        .container{
            padding: 10px 16px;
            background: aliceblue;

        }
        .promo{
            background: #ccc;
            padding: 3px;
            color: darkblue;
            font-size: 20px;
            font-weight: 600;
        }
        .expire{
            color: red;
        }
        .code{
            text-align: center;
            font-size: 20px;
            padding: 10px;
            
        }
        .expire{
            /* padding-top: 10px; */
            text-align: center;
            font-size: 14px;
        }
        h2.note{
            text-align: center;
            font-size: 20px;
            color: darkblue;
            
        }
        h3.note{
            text-align: center;
            font-size: 18px;
            color: darkblue;
            
        }
        .price{
            color: red;
            font-size: 22px;
            font-weight: 600;
        }
        .min_price{
            color: red;
            font-size: 18px;
            font-weight: 600;
        }
        .date{
            font-weight: 600;
        }
        .text{
            text-align: center;
            color: #103679;
            font-size: 18px;
        }
        .text_mini{
            text-align: center;
            color: #103679;
            font-size: 16px;
            font-style: italic
        }
    </style>
</head>
<body>
    
    @php
    if($coupon['type'] == 0) {
        $c = 'Giảm theo phần trăm';
        $v = '%';
    }
    else {
        $c = 'Giảm theo giá tiền';
        $v = '₫';
    }
@endphp
    <div class="coupon">
        <div class="container">
            <h1 style="
                color: #103679;
                font-size: 24px;
                text-align: center;
                text-transform: capitalize;
        ">{{ $coupon['name'] }} từ <a href="http://127.0.0.1:8000/" target="_blank" rel="noopener noreferrer">Camera Shop</a></h1>
        </div> 
        <div class="container" style="background: white">
            <h2 class="note">
                Giảm <span class="price">{{ $coupon['min_price'] }}{{ $v }}</span> Giảm tối đa <span class="price">{{number_format( $coupon['max_price'], 0, ',', '.') }}&#8363;</span>
            </h2>
            <h3 class="note" >Đơn tối thiểu <span class="min_price"> {{number_format( $coupon['min_order'], 0, ',', '.') }}&#8363;</span></h3>
            
        </div> 
        <div class="container">
            <div class="code">Sử dụng Code sau: <span class="promo">{{ $coupon['code'] }}</span></div>
           
            <p class="text_mini">Mã chỉ được áp dụng khi đặt hàng online tại <a href="http://127.0.0.1:8000/" target="_blank" rel="noopener noreferrer">Camera Shop</a>. Lượt sử dụng có hạn. Nhanh tay kẻo lỡ bạn nhé!</p>
            <div class="expire">Hạn sử dụng mã: từ ngày <span class="date"> {{ \Carbon\Carbon::parse($coupon['start_date'])->format('d-m-Y') }}</span> đến hết ngày <span class="date">{{ \Carbon\Carbon::parse($coupon['end_date'])->format('d-m-Y') }}</span></div>
        </div>
    </div>
</body>
</html>


