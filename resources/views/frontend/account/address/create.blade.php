


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
                            Thêm Địa Chỉ Mới
                        </h1>
                    </div>
                    
                    <div class="RCnc9v">
                        <div class="HrBg9Q">
                          <form action="{{ route('user.address.store') }}" method="POST" >
                            @csrf
                                <div class="row">
                                  <div class="col-xl-6 col-md-6">
                                    <div class="wsus__add_address_single">
                                      <label>Họ và Tên <b>*</b></label>
                                      <input type="text" placeholder="Họ và Tên người nhận" name="name">
                                    </div>
                                  </div>
                                  <div class="col-xl-6 col-md-6">
                                    <div class="wsus__add_address_single">
                                      <label>Số điện thoại<b>*</b></label>
                                      <input type="text" placeholder="Số điện thoại người nhận" name="phone">
                                    </div>
                                  </div>
                                  
                                  <div class="col-xl-4 col-md-4">
                                    <div class="wsus__add_address_single">
                                      <label>Thành phố/Tỉnh <b>*</b></label>
                                      <div class="wsus__topbar_select">
                                        <select class="select_2 city" name="city_id">
                                          <option value="">Chọn Tỉnh/Thành phố</option>
                                          @foreach ($cities as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-xl-4 col-md-4">
                                    <div class="wsus__add_address_single">
                                      <label>Quận, Huyện <b>*</b></label>
                                      <div class="wsus__topbar_select">
                                        <select class="select_2 district" name="district_id">
                                          <option>Chọn Quận/Huyện</option>
                                          
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-xl-4 col-md-4">
                                    <div class="wsus__add_address_single">
                                      <label>Xã, Phường, Thị Trấn <b>*</b></label>
                                      <div class="wsus__topbar_select">
                                        <select class="select_2 ward" name="ward_id">
                                          <option>Chọn Xã/Phường/Thị Trấn</option>
                                          
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-xl-12">
                                    <div class="wsus__add_address_single">
                                      <label>Địa chỉ cụ thể</label>
                                      <textarea cols="3" rows="2" placeholder="Nhập địa chỉ cụ thể" name="address"></textarea>
                                    </div>
                                  </div>
                                  <div class="col-xl-6">
                                    <button type="submit" class="common_btn">Thêm địa chỉ</button>
                                  </div>
                                </div>
                              </form>
                        </div>

                    </div>


                </div>
            </div>
               
                       
            
        </div>
       
    </div>
</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  $(document).ready(function(){
      $('.city').change(function(){
          var city_id = $(this).val();
          console.log(city_id);
          $.ajax({
              url: "{{ route('user.get-district', '') }}/" + city_id,
              type: 'GET',
              success:function(response){
         
                  var options = '<option value="">Chọn Quận/Huyện</option>';
                  $.each(response, function(index, district){
                      options += '<option value="'+district.id+'">'+district.name+'</option>';
                  });
                  $('.district').html(options);
              }
          });
      });

      $('.district').change(function(){
        var district_id = $(this).val();
        $.ajax({
            url: "{{ route('user.get-ward', '') }}/" + district_id,
            type: 'GET',
            success:function(response){
                var options = '<option value="">Chọn Xã/Phường/Thị Trấn</option>';
                $.each(response, function(index, ward){
                    options += '<option value="'+ward.id+'">'+ward.name+'</option>';
                });
                $('.ward').html(options);
            }
        });
    });

  });
</script>
