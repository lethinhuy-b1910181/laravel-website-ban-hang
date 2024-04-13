@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12" >
        <div class="card card-statistic-2">
          <div class="card-stats">
            <div class="card-stats-title">Thống Kê Đơn Hàng - 
              <div class="dropdown d-inline">
                <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month" style="
                cursor: pointer; color:blue"></a>
                <ul class="dropdown-menu dropdown-menu-sm" id="month-dropdown">
                  <li class="dropdown-title">Chọn tháng</li>
                  <li data-id="1"><a href="#" class="dropdown-item">Tháng 1</a></li>
                  <li data-id="2"><a href="#" class="dropdown-item">Tháng 2</a></li>
                  <li data-id="3"><a href="#" class="dropdown-item">Tháng 3</a></li>
                  <li data-id="4"><a href="#" class="dropdown-item">Tháng 4</a></li>
                  <li data-id="5"><a href="#" class="dropdown-item">Tháng 5</a></li>
                  <li data-id="6"><a href="#" class="dropdown-item">Tháng 6</a></li>
                  <li data-id="7"><a href="#" class="dropdown-item">Tháng 7</a></li>
                  <li data-id="8"><a href="#" class="dropdown-item">Tháng 8</a></li>
                  <li data-id="9"><a href="#" class="dropdown-item">Tháng 9</a></li>
                  <li data-id="10"><a href="#" class="dropdown-item">Tháng 10</a></li>
                  <li data-id="11"><a href="#" class="dropdown-item">Tháng 11</a></li>
                  <li data-id="12"><a href="#" class="dropdown-item">Tháng 12</a></li>
                </ul>
              </div>
            </div>
            <div class="card-stats-items ">
                <div class="card-stats-item new-orders">
                    <div class="card-stats-item-count" id="new-orders">{{ $newOrders }}</div>
                    <div class="card-stats-item-label">Đơn Mới</div>
                </div>

                <div class="card-stats-item shipping-orders">
                    <div class="card-stats-item-count" id="shipping-orders">{{ $shippingOrders }}</div>
                    <div class="card-stats-item-label">Đang Giao</div>
                </div>
                
                <div class="card-stats-item completed-orders">
                    <div class="card-stats-item-count" id="completed-orders">{{ $completedOrders }}</div>
                    <div class="card-stats-item-label">Hoàn Thành</div>
                </div>

                <div class="card-stats-item d-none canceled-orders">
                  <div class="card-stats-item-count" id="canceled-orders">{{ $canceledOrders }}</div>
                  <div class="card-stats-item-label">Đã Hủy</div>
              </div>
            </div>
          </div>
          <div class="card-icon shadow-primary bg-primary">
            <i class=" text-light fa fa-shopping-cart"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Tổng Đơn Hàng</h4>
            </div>
            <div class="card-body " id="total-orders">
              {{ $total_order }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12" >
        <div class="card card-statistic-2" style="
        height: 196px;background: aliceblue;
    ">
          <div class="card-chart">
            <div class="card-header" style="
            padding-top: 5px;
            display: flex;
            padding-bottom: 40px;
        ">
              <h4 style="
              color: #103679;
              font-size: 24px !important;
          ">Tổng Doanh Thu</h4>
            </div>
          </div>
          <div class="card-icon shadow-primary bg-primary">
            <i class="text-light fa fa-signal"></i>
          </div>
          <div class="card-wrap" >
            
            <div class="card-body" style="
            color: #103679;
        ">
              {{ number_format($total_sale, 0, ',', '.') }}&#8363;
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12">
      
        <div class="card card-statistic-2" style="
        height: 196px;background: white;
    ">
          <div class="card-chart">
            <div class="card-header" style="
            padding-top: 5px;
            display: flex;
            padding-bottom: 40px;
        ">
              <h4 style="
              color: #103679;
              font-size: 24px !important;
          ">Tổng Lợi Nhuận</h4>
            </div>
          </div>
          <div class="card-icon shadow-primary bg-primary">
            <i class="text-light fa fa-shopping-bag"></i>
          </div>
          <div class="card-wrap" >
            
            <div class="card-body" style="
            color: #103679;
        ">
              {{ number_format($total_profit, 0, ',', '.') }}&#8363;
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row ">
      <div class="card col-12 sale-container">
        <div class="card-header sale-title">
          <span >Thống kê doanh thu</span>
        </div>
        <div class="card-body">
          <form action="">
            <div class="row">
             
              <div class="form-group col-2"  >
                <label >Từ ngày:</label>
                <input type="text" class="form-control"  id="datepicker" >
              </div>
              <div class="form-group col-2">
                <label for="">Đến ngày:</label>
                <input type="text" class="form-control"  id="datepicker2" >
              </div>

              <div class=" col-2 sale-btn-submit">
                <button type="button" id="btn-dashboard-filter" class="btn btn-primary">Lọc kết quả</button>
              </div>
              <div class="col-3"></div>
              <div class="col-3">
                <p>
                  <span >Lọc theo:</span>
                  <select class="dashboard-filter selectric form-control" name="" id="">
                    <option >--------Chọn-------</option>
                    <option value="7ngay">7 ngày qua</option>
                    <option value="thangtruoc">Tháng trước</option>
                    <option value="thangnay">Tháng này</option>
                    <option value="365ngayqua">365 ngày qua</option>
                  </select>
                </p>
              </div>
            </div>
          </form>
          <div class="col-md-12">
            
            <h5 style="
            display: flex;
            justify-content: center;
            text-transform: capitalize;
            color: #003b46;
        "></h5>
            <div id="myfirstchart" style="height: 250px">
            </div>
           

          </div>
        </div>
      </div>
    </div>


    <div class="row ">
      <div class="card col-12 sale-container">
        <div class="card-header sale-title">
          <span >Sản phẩm bán chạy nhất | 7 ngày qua </span>
        </div>
        <div class="card-body">
         
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#ID</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Đã bán</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($products as $product)
              <tr>
                <th >{{ $product->id }}</th>
                <td><img width='55px' height='55px' src="{{ asset($product->image) }}"> </img></td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->sales }}</td>
              </tr>
              @endforeach
              
             
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
   
</section>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
      $(document).ready(function(){
        chart60days();
        chartmini();
        var chart = new Morris.Bar({
      
          element: 'myfirstchart',

          barColors: ['#eb3434', '#66a5ad', '#003b46', '#eb9f34'],
          
          parseTime: false,
          hideHover: 'auto',
          xkey: 'period',
          ykeys: ['order', 'sales' , 'profit', 'quantity'],
          labels: ['Đơn hàng', 'Doanh thu' , 'Lợi nhuận', 'Số lượng'],
          barLabel: 'Tên Biểu đồ'
        });

        var miniChart = new Morris.Bar({
      
          element: 'minichart',

          barColors: ['#eb3434', '#66a5ad', '#003b46', '#eb9f34'],
          
          parseTime: false,
          hideHover: 'auto',
          xkey: 'period',
          ykeys: ['order', 'sales' , 'profit', 'quantity'],
          labels: ['Đơn hàng', 'Doanh thu' , 'Lợi nhuận', 'Số lượng'],
        });

        function chartmini (){
          var _token = $('input[name="_token"]').val();
          $.ajax({
            url: "{{ route('admin.dashboard.filter-by-60-date') }}",
            method: "POST",
            data:{
              _token:_token
            },
            success:function(data){
              miniChart.setData(data);
              }
          });
        }

        function chart60days(){
          var _token = $('input[name="_token"]').val();
          $.ajax({
            url: "{{ route('admin.dashboard.filter-by-60-date') }}",
            method: "POST",
            data:{
              _token:_token
            },
            success:function(data){
              var chartTitle = "Biểu đồ thống kê doanh thu 60 ngày qua ";
              chart.options.barLabel = chartTitle;

              $('#myfirstchart').prev('h5').text(chartTitle);
              chart.options.barLabel = chartTitle;
                chart.setData(data);
              }
          });
        }

        $('#btn-dashboard-filter').click(function(){
          var _token = $('input[name="_token"]').val();
          var from_date = $('#datepicker').val();
          var to_date = $('#datepicker2').val();
          
          $.ajax({
            url: "{{ route('admin.dashboard.filter-by-date') }}",
            method: "POST",
            data:{
              from_date: from_date,
              to_date:to_date,
              _token:_token
            },
            success:function(data){
              var formatted_from_date = moment(from_date).format('DD-MM-YYYY');
              var formatted_to_date = moment(to_date).format('DD-MM-YYYY');
              var chartTitle = "Biểu đồ thống kê doanh thu từ " + formatted_from_date + " đến " + formatted_to_date;
            chart.options.barLabel = chartTitle;

            $('#myfirstchart').prev('h5').text(chartTitle);
            chart.options.barLabel = chartTitle;
              chart.setData(data);
            }
          });

        });
        
        $('.dashboard-filter').change(function(){
          var dashboard_value = $(this).val();
          var _token = $('input[name="_token"]').val();
          $.ajax({
            url: "{{ route('admin.dashboard.filter') }}",
            method: "POST",
            dataType: "JSON",
            data: {
              dashboard_value: dashboard_value,
              _token: _token
            },
            success: function(data){
              chart.setData(data);
              var chartTitle = "Biểu đồ thống kê doanh thu " + data[0]['selected_period']; // Sử dụng thông tin về thời gian đã chọn từ dữ liệu trả về
              chart.options.barLabel = chartTitle;
              $('#myfirstchart').prev('h5').text(chartTitle);
             
            }
          });
        });

      });
    </script>


<script >

      document.addEventListener("DOMContentLoaded", function() {
        // Lấy ngày hiện tại
        var currentDate = new Date();
        var currentMonth = currentDate.getMonth() + 1; 
        
        // Cập nhật giá trị và lớp active cho tháng hiện tại
        var monthDropdown = document.getElementById("month-dropdown");
        var monthLinks = monthDropdown.getElementsByClassName("dropdown-item");
        for (var i = 0; i < monthLinks.length; i++) {
          var monthLink = monthLinks[i];
          var monthText = monthLink.textContent.trim();
          var monthNumber = parseInt(monthText.replace("Tháng ", ""));
          
          if (monthNumber === currentMonth) {
            monthLink.classList.add("active");
            document.getElementById("orders-month").textContent = monthText;
            break;
          }
        }
        
        // Thêm sự kiện click cho các tháng
        for (var i = 0; i < monthLinks.length; i++) {
          monthLinks[i].addEventListener("click", function(event) {
            // Loại bỏ lớp active từ tất cả các liên kết
            for (var j = 0; j < monthLinks.length; j++) {
                monthLinks[j].classList.remove("active");
              }
              
              // Thêm lớp active cho liên kết được click
              this.classList.add("active");
              
              // Cập nhật giá trị của nút chọn tháng
              var selectedMonth = this.textContent.trim();
              document.getElementById("orders-month").textContent = selectedMonth;
            });
          }
       });


      $(document).ready(function(){
            $('#month-dropdown').on('click', '.dropdown-item', function(event){
                event.preventDefault(); 
                var monthId = $(this).parent().data('id');
                $.ajax({
                    url: "{{route('admin.dashboard.total-order') }}", 
                    type: 'POST',
                    data: { month_id: monthId }, 
                    success: function(response){
                        var check = response.is_current_month;

                        if (check) {
                          $('#total-orders').text(response.total_orders);
                          $('#new-orders').text(response.new_orders);
                          $('#shipping-orders').text(response.shipping_orders);
                          $('#completed-orders').text(response.completed_orders);

                          $('.canceled-orders').addClass('d-none');
                          $('.new-orders').removeClass('d-none');
                          $('.shipping-orders').removeClass('d-none');
                          $('.completed-orders').removeClass('d-none');
                          // var check = response.is_current_month;
                      } else {
                        $('#total-orders').text(response.total_orders);
                          $('#new-orders').text(response.new_orders);
                          $('#shipping-orders').text(response.shipping_orders); // Cập nhật nhãn
                          $('#completed-orders').text(response.completed_orders);
                          $('#canceled-orders').text(response.canceled_orders);

                          $('.canceled-orders').removeClass('d-none');
                          $('.new-orders').addClass('d-none');
                          $('.shipping-orders').removeClass('d-none');
                          $('.completed-orders').removeClass('d-none');
                          // var check = response.is_current_month;

                      }

                    },
                    error: function(xhr, status, error){
                        console.error(error);
                    }
                });
            });
        });


</script>
@endpush