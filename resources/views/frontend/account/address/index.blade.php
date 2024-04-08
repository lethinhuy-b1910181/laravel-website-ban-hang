

@extends('frontend.layouts.master')

@section('content')
<div class="container BtZOqO">
    @include('frontend.sidebar')
    <div class="fkIi86">
        <div class="CAysXD">
            <div class="" style="display: contents;">
                <div class="utB99K">
                    <div class="SFztPl">
                        <h1 class="BVrKV_">
                            Địa Chỉ Của Tôi
                        </h1>
                        <a href="{{ route('user.address.create') }}" class="btn btn-primary">+ Thêm địa chỉ</a>
                    </div>
                    <div class="RCnc9v">
                         
                        <div class="address-content  col-12"> 
                           @foreach ($addresses as $item)
                            <div class="row address-bd">
                                
                                <div class="col-10">
                                    <div class="column">
                                        <h5>{{ $item->name }}</h5>
                                        <div class="head">
                                            <span >{{ $item->phone }}</span>
                                        </div>
                                        <div class="body-nav">
                                            <span>
                                                 {{ $item->address }}
                                            </span>
                                           
                                        </div>
                                        <div class="body-nav">
                                            <span>
                                                @php
                                                    $xa = App\Models\Ward::where('id',$item->ward_id)->first();
                                                    $quan = App\Models\District::where('id',$item->district_id)->first();
                                                    $ct = App\Models\City::where('id',$item->city_id)->first();
                                                @endphp
                                                {{ $xa->name }}, {{ $quan->name }}, {{ $ct->name }}
                                           </span>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-2">
                                    <button class="btn">
                                        <a href="{{ route('user.address.edit', $item->id) }}" class="ml-2 text-primary ">Cập nhật</a>

                                    </button>
                                    <button class="btn">
                                        <a href="{{ route('user.address.destroy', $item->id) }}" class=" delete-item text-danger ">Xóa</a>

                                    </button>
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