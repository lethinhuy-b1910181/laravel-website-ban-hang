@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Khách Hàng</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.customer.index') }}">Khách Hàng</a></div>
        <div class="breadcrumb-item">Xem Chi Tiết</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-13 col-lg-12">
          <div class="card">
            
            <div class="card-body">
               <div class="row">
                <div class="col-4">
                    <div class="owl-item" style="margin-right: 20px; padding-top:20px;"><div>
                        <div class="user-item">

                          <img alt="image" style="
                          width: 150px;
                        
                      " src="{{ $user->image ? asset($user->image) :  asset('uploads/default.png')}}" class="rounded-circle profile-widget-picture">
                          <div class="user-details">
                            <div class="user-name">{{ $user->name }}</div>
                            
                          </div>  
                        </div>
                      </div></div>
                </div>
                <div class="col-8">
                    <div class="card-header">
                        <h4>Tổng quan</h4>
                      </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">Email<span class="text-danger">(*)</span></label>
                            <input type="email" class="form-control" name="email" disabled value="{{ $user->email }}">
                        </div>
                        <div class="form-group col-6">
                            <label for="">Tổng tiền<span class="text-danger">(*)</span></label>
                            <input type="email" class="form-control" name="email" disabled value="{{ $user->total_money }}">
                        </div>
                        
                       
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">Tên Khách Hàng<span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" name="name" disabled value="{{ $user->name }}">
                        </div>
                   
                        <div class="form-group col-6">
                            <label for="">Số điện thoại<span class="text-danger">(*)</span></label>
                            <input type="number" class="form-control" name="phone" disabled value="{{ $user->phone }}">
                        </div>
                       
                    </div>
                </div>
               </div>

                    
          
               
            </div>
            
          </div>
        </div>
      </div>
      
    </div>
  </section>
@endsection

@push('scripts')

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
    
@endpush