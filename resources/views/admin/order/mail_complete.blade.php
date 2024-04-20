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
            <p class="text">Đơn hàng <a href="" target="_blank" rel="noopener noreferrer">#{{ $info_array['order_id'] }}</a> của bạn đã được giao thành công ngày {{ $info_array['order_date'] }}.</p>
            <p class="text">Hãy đăng nhập <a href="http://127.0.0.1:8000/" target="_blank" rel="noopener noreferrer">Camera Shop</a> và để lại đánh giá về chất lượng sản phẩm và phục vụ của shop nhé.
                </p>

                <p class="text">Nếu bạn chưa nhận được sản phẩm hoặc có thắc mắc, vui lòng liên hệ chúng tôi tại website: <a href="http://127.0.0.1:8000/" target="_blank" rel="noopener noreferrer">Camera Shop</a>, hoặc liên hệ qua số hotline: 0909 688 485.</p>
                <p class="text">Cảm ơn quý khách đã sử dụng dịch vụ của shop. Chúc quý khách nhiều sức khỏe và thành công! </p>
                <p class="text">Trân trọng,</p>
            
        </div>
        <hr>
        <div class="row col-12">
            <p class="note">Chú ý: Đây là email tự động từ dịch vụ CameraShop. Vui lòng không trả lời lại email này!</p>
        </div>
     
    </div>
</body>
</html>