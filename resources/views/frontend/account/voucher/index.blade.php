

@extends('frontend.layouts.master')

@section('content')
<div class="container BtZOqO">
    @include('frontend.sidebar')
    <div class="fkIi86">
        <div class="CAysXD">
            <div class="" style="display: contents;">
                <div class="utB99K">
                    <div class="SFztPl d-flex justify-content-center">
                        <h1 class="BVrKV_ " >
                            Kho Voucher Của Bạn
                        </h1>
                        
                    </div>
                    <div class="RCnc9v">
                      

                        <div class="lqe2oF hYSKGf col-12 row">
                            @foreach ($coupons as $coupon)
                                @php
                                    if($coupon->status == 1){
                                        $o = 'XsKHMJ';
                                        $a = 'a4L4_I';
                                    }else if($coupon->discount->start_date > date('Y-m-d')){
                                        $o = 'XsKHMJ';
                                        $a = 'a4L4_I';
                                    }else if($coupon->discount->end_date < date('Y-m-d')){
                                        $o = 'XsKHMJ';
                                        $a = 'a4L4_I';
                                    }else {
                                        $o = '';
                                        $a = '';
                                    }
                                @endphp
                                <div class="FcXANd gj97Rr {{ $o }} BP5yjX tIXZdG ZrFksI col-6">
                                    <div class="q2pjG9">
                                        <div class="P8Mfoo" style="--vc-card-left-border-color: #08c; --vc-card-left-fill-color: #08c;">
                                            <div class="PcmVqR"></div>
                                        </div>
                                        <div class="hPIn_I"></div>
                                        <div class="MShxuW"></div>
                                        <div class="EAMMai" role="presentation">
                                            <div class="QqwAWp" role="presentation">
                                                
                                                <div class="GZ_QY_ wcZL9e" style="color: white; text-align: center; font-weight:600; padding-bottom:10px;">#{{ $coupon->discount->code }}</div>
                                                <div class="GZ_QY_ wcZL9e" style="color: white; font-size: 12px; text-align: center;">{{ $coupon->discount->name }} </div>

                                            </div>
                                            <div class="ZvtffU" role="presentation" style="
                                            padding: 15px;">
                                                <div class="XF46UZ">
                                                    <span aria-label=""></span>
                                                    <span aria-label=" Vui lòng mua hàng trên ứng dụng Shopee để sử dụng ưu đãi."></span>
                                                </div>
                                                <div class="xu9UIY">
                                                    @php
                                                        if($coupon->discount->type == 0){
                                                            $c = $coupon->discount->min_price;
                                                            $v = '%';
                                                        }else{
                                                            $c = number_format($coupon->discount->min_price, 0, ',', '.');
                                                            $v = '₫';
                                                        }
                                                    @endphp
                                                    <div class="UsdMJE ZbLqtU">Giá Trị Mã Giảm {{ $c }}{{ $v }}</div>
                                                </div>
                                                <div class="FI_cTo liTyw2">Đơn Tối Thiểu {{  number_format($coupon->discount->min_order, 0, ',', '.') }}₫</div>
                                                <div class="VWeV_W">
                                                    <div class="ljpBGw">
                                                        <div class="DOIpDy" aria-label="Tối đa 40K" style="color: red;">Giảm Tối Đa {{  number_format($coupon->discount->max_price, 0, ',', '.') }}₫</div>
                                                    </div>
                                                </div>
                                                <div class="MAHVi3">
                                                    <div class="QxJU53">
                                                        <div class="R3vm95 lVIsCZ">
                                                            <span class="eT2hlo" style="
                                                            font-size: 13px;
                                                        ">Hạn sử dụng: {{date('d-m-Y ' , strtotime($coupon->discount->end_date)) }}</span>
                                                        </div>
                                                    </div>
                                                
                                                </div>
                                            </div>
                                          
                                            <div class="cnFM7k owyP4s">
                                                <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg" class="izn8vl oHnnYi">
                                                    <path d="M1.50391 0.716797L2.50977 2.46973L3.53516 0.716797H4.8291L3.22754 3.30957L4.89258 6H3.59863L2.52441 4.17383L1.4502 6H0.151367L1.81152 3.30957L0.214844 0.716797H1.50391Z" fill="#EE4D2D"></path>
                                                </svg> 
                                                <div>1</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Xjagg4">
                                        <div class="iaxBQi aOZb2y" style="border-right: 0.0625rem dashed rgb(232, 232, 232); background: rgb(38, 170, 153);"></div>
                                    </div>
                                
                                </div>
                            @endforeach
                            
                          
                        </div>
                        

                    </div>


                </div>
            </div>
                
            
        </div>
       
    </div>
</div>

@endsection