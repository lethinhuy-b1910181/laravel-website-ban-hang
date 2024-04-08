@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Hồ sơ cá nhân</h1>
      
    </div>
    <div class="section-body">
      <div class="row mt-sm-4">
        
        <div class="col-12 col-md-12 col-lg-7">
          <div class="card">
            <form method="post" class="needs-validation" novalidate="">
              <div class="card-header">
                <h4>Cập nhật hồ sơ</h4>
              </div>
              <div class="card-body">
                  <div class="row">      
                    <div class="form-group col-md-6 col-12">
                        <label>Email</label>
                        <input type="text" class="form-control" disabled  required="" value="{{ Auth::guard('admin')->user()->email }}">
                        
                      </div>                         
                    <div class="form-group col-md-6 col-12">
                      <label>Họ và Tên</label>
                      <input type="text" class="form-control"  required="" value="{{ Auth::guard('admin')->user()->name }}">
                      
                    </div>
                    
                  </div>
                  <div class="row">
                    <div class="form-group col-md-7 col-12">
                      <label>Email</label>
                      <input type="email" class="form-control" value="ujang@maman.com" required="">
                      <div class="invalid-feedback">
                        Please fill in the email
                      </div>
                    </div>
                    <div class="form-group col-md-5 col-12">
                      <label>Phone</label>
                      <input type="tel" class="form-control" value="">
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="form-group mb-0 col-12">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" id="newsletter">
                        <label class="custom-control-label" for="newsletter">Subscribe to newsletter</label>
                        <div class="text-muted form-text">
                          You will get new information about products, offers and promotions
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-primary">Cập nhật</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection