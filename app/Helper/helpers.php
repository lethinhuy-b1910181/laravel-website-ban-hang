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
                    ->join('products', 'cart_users.product_id', '=', 'products.id')
                    ->sum(\Illuminate\Support\Facades\DB::raw('cart_users.qty * products.offer_price'));
    return $total;
}