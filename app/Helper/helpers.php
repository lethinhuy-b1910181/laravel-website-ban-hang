<?php

/** Set sidebar item active */
function setActive(array $route){
    if(is_array($route)){
        foreach($route as $r){
            if(request()->routeIs($r)){
                return 'active';
            }
        }
    }
}

function setActiveHead(array $route){
    if(is_array($route)){
        foreach($route as $r){
            if(request()->routeIs($r)){
                return 'mRVNLm';
            }
        }
    }
}

// function is_duyedon() {
//     $user = Auth::guard('admin')->user(); // Lấy người dùng hiện tại đang đăng nhập
//     if ($user) {
//         // Kiểm tra xem người dùng có quyền duyệt đơn hay không
//         return $user->quyens()->where('name', 'order')->exists();
//     }
//     return false; // Nếu không có người dùng đăng nhập, trả về false
// }


// function getCartTotal($user_id){
//     // Sử dụng query builder để join bảng Cart và Product
//     $totals = \App\Models\CartUser::join('products', 'cart_users.product_id', '=', 'products.id')
//                 ->select('cart_users.user_id', \Illuminate\Support\Facades\DB::raw('SUM(cart_users.qty * products.offer_price) as total'))
//                 ->groupBy('cart_users.user_id')
//                 ->get();
    
//     // Trả về một collection chứa tổng tiền của từng user_id
//     return  $total->total;
// }

function getCartTotal($user_id){
    $total = \App\Models\CartUser::where('user_id', $user_id)
                    ->sum(\Illuminate\Support\Facades\DB::raw('cart_users.qty * cart_users.product_price'));
    return $total;
}

function getMainCartTotal($user_id){
    if(Session::has('coupon')){
        $coupon = Session::get('coupon');
        $subTotal = getCartTotal($user_id);
        if($coupon['coupon_type'] == 1){
            $total = $subTotal  - $coupon['coupon_min_price'];
            return $total;
        }elseif($coupon['coupon_type'] == 0){
            $discount = $subTotal * $coupon['coupon_min_price'] / 100;
            if($discount <= $coupon['coupon_max_price']){
                $discount = $subTotal * $coupon['coupon_min_price'] / 100;
                $total = $subTotal - $discount;
                return $total;

            }elseif($discount > $coupon['coupon_max_price']){
                $discount = $coupon['coupon_max_price'];
                $total = $subTotal - $discount;
                return $total;
            }
        }
    }else{
        return getCartTotal($user_id);
    }
}

function getCartDiscount($user_id){
    if(Session::has('coupon')){
        $coupon = Session::get('coupon');
        $subTotal = getCartTotal($user_id);
        if($coupon['coupon_type'] == 1){
            return $coupon['coupon_min_price'];
        }elseif($coupon['coupon_type'] == 0){
            $discount = $subTotal * $coupon['coupon_min_price'] / 100;
            if($discount <= $coupon['coupon_max_price']){
                $discount = $subTotal * $coupon['coupon_min_price'] / 100;
               
                return $discount;

            }elseif($discount > $coupon['coupon_max_price']){
                $discount = $coupon['coupon_max_price'];
                return $discount;
            }
        }
    }else{
        return 0;
    }
}
function getDiscountCode(){
    if(Session::has('coupon')){
        $coupon = Session::get('coupon');
        if($coupon['coupon_type'] == 1){
            $discount_code = number_format($coupon['coupon_min_price'], 0, ',', '.') . '₫';
            return $discount_code;
        }elseif($coupon['coupon_type'] == 0){
            $discount_code = $coupon['coupon_min_price'] . '%';
            return $discount_code;
        }
    }else{
        return 0;
    }
}

