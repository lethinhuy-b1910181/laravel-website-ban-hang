<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Statistical;
use App\Models\OrderTotal;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function filterByDate(Request $request){
        
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $chart_data = [];
        $get = Statistical::whereBetween('order_date', [$from_date, $to_date])->orderBy('order_date', 'ASC')->get();
        foreach($get as $item){
            $chart_data[] = array(
                
                'period' => $item->order_date,
                'order' => $item->total_order,
                'sales' => $item->sales,
                'profit' => $item->profit,
                'quantity' => $item->quantity
            );
        }
        return response()->json($chart_data);
    }

    public function filterBy60Date(){
        

      
        $chart_data = [];

        $sub60days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(60)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        $get = Statistical::whereBetween('order_date', [$sub60days, $now])->orderBy('order_date', 'ASC')->get();
        foreach($get as $item){
            $chart_data[] = array(
                
                'period' => $item->order_date,
                'order' => $item->total_order,
                'sales' => $item->sales,
                'profit' => $item->profit,
                'quantity' => $item->quantity
            );
        }
        return response()->json($chart_data);
    }

    public function filter(Request $request){
        
        $data = $request->all();

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dauthangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoithangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $selected_period = '';
        if($data['dashboard_value'] == '7ngay'){
            $get = Statistical::whereBetween('order_date', [$sub7days, $now])->orderBy('order_date', 'ASC')->get();
            $selected_period = '7 ngày qua';
        }else if($data['dashboard_value'] == 'thangtruoc'){
            $get = Statistical::whereBetween('order_date', [$dauthangtruoc, $cuoithangtruoc])->orderBy('order_date', 'ASC')->get();
            $selected_period = 'Tháng trước';
        }else if($data['dashboard_value'] == 'thangnay'){
            $get = Statistical::whereBetween('order_date', [$dauthangnay, $now])->orderBy('order_date', 'ASC')->get();
            $selected_period = 'Tháng này';
        }else{
            $get = Statistical::whereBetween('order_date', [$sub365days, $now])->orderBy('order_date', 'ASC')->get();
            $selected_period = '365 ngày qua';
        }
        $chart_data = [];
        foreach($get as $item){
            $chart_data[] = array(
                
                'period' => $item->order_date,
                'order' => $item->total_order,
                'sales' => $item->sales,
                'profit' => $item->profit,
                'quantity' => $item->quantity,
                'selected_period' => $selected_period
            );
        }

        return response()->json($chart_data);
    }


    public function totalOrder(Request $request){
        $monthId = $request->input('month_id');
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
       
        $total_orders = Statistical::whereYear('order_date', '=', $currentYear)
        ->whereMonth('order_date', '=', $monthId)
        ->sum('total_order');
       

        // Lọc và tính tổng số đơn hàng mới (order_status = 0)
        $newOrders = OrderTotal::whereYear('created_at', $currentYear)
        ->whereMonth('created_at', $monthId)
        ->where('order_status', 0)
        ->count();

        // Lọc và tính tổng số đơn hàng đang giao (order_status = 2)
        $shippingOrders = OrderTotal::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $monthId)
            ->where('order_status', 2)
            ->count();

        // Lọc và tính tổng số đơn hàng đã hoàn thành (order_status = 3)
        $completedOrders = OrderTotal::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $monthId)
            ->where('order_status', 3)
            ->count();

            $canceledOrders = OrderTotal::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $monthId)
            ->where('order_status', 4)
            ->count();

            $isCurrentMonth = $monthId == $currentMonth;

           
        return response()->json([
            'total_orders' => $total_orders,
            'new_orders' => $newOrders,
            'shipping_orders' => $shippingOrders,
            'completed_orders' => $completedOrders,
            'is_current_month' => $isCurrentMonth,
            'canceled_orders' => $canceledOrders
        ]);
    }
}
