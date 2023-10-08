@extends('layouts.app')
@section('extra_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
<style>
  .step > h3 {
    text-align: center;
  }
  .step > h3 > span {
    font-size: 20px;
  }
  .set-datetime > .form-group {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
  }

  label {
    margin: 0;
  }

  .set-datetime > .form-group > .radio {
    margin-right: 20px;
  }

  .set-datetime > .form-group > .radio > label, .set-datetime > .form-group > .radio > input {
    cursor: pointer;
  }

  .set-datetime > .view_datetime {
    white-space: nowrap;
  }

  .set-datetime  .view_datetime  span {
    font-weight: bold;
  }

  .view_datetime_user {
    display: flex;
    align-items: center;
  }

  .step {
    display: none;
  }

  .step_button_group{
    display: flex;
    gap: 20px;
    margin-top: 20px;
    border-top: 1px solid #ccc;
    padding-top: 20px;
    padding-left: 20px;
  }

  .step_button_group > button {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
  }

  .vehicle_detail p {
    font-weight: bold;
  }

  .vehicle_detail span, .vehicle_detail p {
    font-size: 16px;
  }

  .vehicle_detail hr {
    border-top: 1px solid #ccc;
    margin-block: 15px;
  }
</style>
@endsection
@section('breadcrumb')
<li class="breadcrumb-item "><a href="{{ route('bookings.index') }}">@lang('menu.bookings')</a></li>
<li class="breadcrumb-item active">@lang('fleet.edit_booking')</li>
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-success">
      <div class="card-header">
        <h3 class="card-title">
            @lang('fleet.edit_booking')
        </h3>
      </div>
      <div class="card-body">
        <div class="step general_infomation step-1">
          <h3>@lang('fleet.general_information')</h3>
          <!-- <div class="row">
            <div class="col-md-12 set-datetime">
              <div class="form-group">
                <div class="radio">
                  <label>
                    <input type="radio" name="dateTimeOption" value="system_date">
                    @lang('fleet.use_system_datetime')
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="dateTimeOption" value="input_date" checked>
                    @lang('fleet.enter_datetime')
                  </label>
                </div>
                <div class="view_datetime">
                   @lang('fleet.current_system_datetime'): <span></span>
                </div>
              </div>
            </div>
          </div> -->
          <!-- <div class="row" id="general_date">
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label"> @lang('fleet.select_date') </label>
                <div class='input-group mb-3 date'>
                  <div class="input-group-prepend">
                      <span class="input-group-text"> <span class="fa fa-calendar"></span></span>
                  </div>
                  <input type="text" class="form-control datetimepicker" value="{{date('Y-m-d H:i:s')}}">
                </div>
              </div>
            </div>
          </div> -->
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">Yoks Branch</label>
                <select class="form-control" id="branch">
                  @foreach($branches as $branch)
                    <option value="{{$branch->id}}" @if($booking_detail->branch_id == $branch->id) selected @endif >{{$branch->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label"> @lang('fleet.service_type') </label>
                <select class="form-control" id="service">
                  <option value="C" @if($booking_detail->service_type == "C") selected @endif>Chauffeur-Driven</option>
                  <option value="S" @if($booking_detail->service_type == "S") selected @endif>Self-Driven</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">@lang('fleet.reservation')</label>
                <select class="form-control" id="reservation_list"></select>
              </div>
            </div>
          </div>
          <div class="row step_button_group">
            <button class="btn btn-info" onclick="gostep(2)"> @lang('fleet.next') <i class="fa fa-angle-right"></i></button>
          </div>
        </div>
        <div class="step step-2">
          <h3>@lang('fleet.booking_detail') <span class="wholeday_component">(@lang('fleet.whole_day_service'))</span><span class="hourly_component">(@lang('fleet.hourly_service'))</span></h3>
          <div class="row">
            <div class="col-md-3 col-sm-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.select_customer')</label>
                <select id="customer_list" class="form-control">
                  @foreach($customers as $customer)
                    <option value="{{$customer->id}}" @if($booking_detail->customer_id == $customer->id) selected @endif>{{$customer->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.pickup')</label>
                <div class='input-group mb-3 date'>
                  <div class="input-group-prepend">
                      <span class="input-group-text"> <span class="fa fa-calendar"></span></span>
                  </div>
                  <input type="text" id="pickup_date" class="form-control datetimepicker" value="{{ $booking_detail->pickup }}">
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.dropoff')</label>
                <div class='input-group mb-3 date'>
                  <div class="input-group-prepend">
                      <span class="input-group-text"> <span class="fa fa-calendar"></span></span>
                  </div>
                  <input type="text" id="dropoff_date" class="form-control datetimepicker" value="{{ $booking_detail->dropoff }}">
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 wholeday_component">
              <div class="form-group">
                <label class="form-label">
                  @lang('fleet.final_destination_outside_accra')?
                </label>
                <select id="final_destination" class="form-control">
                  <option value="Y" @if($booking_detail->final_destination == 'Y') selected @endif>Yes</option>
                  <option value="N" @if($booking_detail->final_destination == 'N') selected @endif>No</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 hourly_component">
              <div class="form-group">
                <label class="form-label">@lang('fleet.number_of_hours')</label>
                <select id="number_hours" class="form-control">
                  @for($i = 0; $i <  4; $i++)
                    <option value="{{$i + 1}}" @if($booking_detail->hours == ($i + 1)) selected @endif>{{$i + 1}}</option>
                  @endfor
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 col-sm-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.airport_pickup')?</label>
                <select id="airport_pickup" class="form-control">
                  <option value="Y" @if($booking_detail->airport_pickup == 'Y') selected @endif>Yes</option>
                  <option value="N" @if($booking_detail->airport_pickup == 'N') selected @endif>No</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-6" id="driver_list">
              <div class="form-group">
                <label class="form-label">@lang('fleet.selectDriver')</label>
                <select class="form-control">
                  @foreach($drivers as $driver)
                    <option value="{{$driver->id}}" @if($booking_detail->driver_id == $driver->id) selected @endif>{{$driver->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.no_travellers')</label>
                <input type="number" id="traveller_count" class="form-control" min="1" value="{{$booking_detail->travellers}}">
              </div>
            </div>
            <div class="col-md-3 col-sm-6 wholeday_component">
              <div class="form-group">
                <label class="form-label">@lang('fleet.destination_outside_accra')</label>
                <input type="text" id="destination_outside" class="form-control" value="{{$booking_detail->destination_outside}}" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 col-sm-12">
              <div class="row">
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                    <label class="form-label">@lang('fleet.pickup_addr')</label>
                    <input type="text" class="form-control" name="" id="pickup_addr" value="{{$booking_detail->pickup_addr}}" />
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                    <label class="form-label">@lang('fleet.dropoff_addr')</label>
                    <input type="text" name="" id="dropoff_addr" class="form-control" value="{{$booking_detail->dest_addr}}">
                  </div>
                </div>
                <div class="col-md-6 col-sm-12 airport">
                  <div class="form-group">
                    <label class="form-label">@lang('fleet.airport_arrival_datetime')</label>
                    <div class='input-group mb-3 date'>
                      <div class="input-group-prepend">
                          <span class="input-group-text"> <span class="fa fa-calendar"></span></span>
                      </div>
                      <input type="text" id="airport_date" class="form-control datetimepicker" value="{{$booking_detail->airport_date}}">
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12 airport">
                  <div class="form-group">
                    <label class="form-label">@lang('fleet.airport_pickup_flight_details')</label>
                    <input type="text" class="form-control" id="airport_detail" value="{{$booking_detail->airport_pickup_details}}">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="form-group">
                <label class="form-label">@lang('fleet.note')</label>
                <textarea id="note" rows="5" class="form-control" placeholder="Enter Note for this booking">{{$booking_detail->note}}</textarea>
              </div>
            </div>
          </div>
          <div class="row step_button_group">
            <button class="btn btn-info" onclick="gostep(1)"><i class="fa fa-angle-left"></i> @lang('fleet.prev') </button>
            <button class="btn btn-info" onclick="gostep(3)"> @lang('fleet.next') <i class="fa fa-angle-right"></i></button>
          </div>
        </div>
        <div class="step step-3">
          <h3>@lang('fleet.selectVehicle')</h3>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">@lang('fleet.vehicle_types')</label>
              </div>
              <select id="vehicle_types" class="form-control">
                @foreach($vehicle_types as $vehicle_type)
                  <option value="{{$vehicle_type->id}}" @if($booking_detail->vehicle_type == $vehicle_type->id) selected @endif>{{$vehicle_type->displayname}}</option>
                @endforeach
              </select>
              <div class="form-group mt-4">
                <label class="form-label">@lang('fleet.selectVehicle')</label>
              </div>
              <select id="vehicle_list" class="form-control"></select>
            </div>
            <div class="col-md-4">
              <img src="{{asset('uploads/vehicles/'.$vehicles[0]->vehicle_image)}}" style="width: 100%;" alt="vehicle_img" id="vehicle_img" />
            </div>
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12">
                  <h4><b id="total_amount"></b></h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 col-sm-6">
                  <p><i class="fa fa-user-group"></i> - <span id="vehicle_seats"></span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                  <p><i class="fa fa-window-maximize"></i> - <span id="vehicle_doors"></span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                  <p><i class="fa fa-luggage-cart"></i> - <span id="vehicle_luggage"></span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                  <p><i class="fa fa-snowflake"></i> - <span id="vehicle_aircondition"></span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                  <p><i class="fa fa-sliders"></i> - <span id="vehicle_transmission"></span></p>
                </div>
              </div>
              <div class="row vehicle_detail wholeday_component">
                <div class="col-md-6">
                  <span>@lang('fleet.daily_km_allowance')</span>
                </div>
                <div class="col-md-6">
                  <p id="daily_km_allowance"></p>
                </div>
                <div class="col-md-6">
                  <span>@lang('fleet.cost_per_extra_km')</span>
                </div>
                <div class="col-md-6">
                  <p id="daily_extra_per_cost"></p>
                </div>
                <div class="col-md-6">
                  @lang('fleet.extra_km_payable')
                </div>
                <div class="col-md-6 vehicle">
                  <p>@lang('fleet.estimated_km_to_from_acc'): <span id="estimated_km_to">60</span>km</p>
                  <hr />
                  <p>@lang('fleet.total_km_allowance'): <span id="total_km_allowance">0</span>km</p>
                  <hr />
                  <p>@lang('fleet.estimated_amount'): <span id="estimated_amount">15 USD / 172.5GHS</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="row step_button_group">
            <button class="btn btn-info" onclick="gostep(2)"><i class="fa fa-angle-left"></i> @lang('fleet.prev') </button>
            <button class="btn btn-info" onclick="gostep(4)"> @lang('fleet.next') <i class="fa fa-angle-right"></i></button>
          </div>
        </div>
        <div class="step step-4">
          <h3>Select Addon</h3>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">@lang('fleet.addon_type')</label>
                <select id="addon_type" class="form-control">
                  <option value="Tours" @if($addon_detail->type == 'Tours') selected @endif>Tours</option>
                  <option value="Extras" @if($addon_detail->type == 'Extras') selected @endif>Extras</option>
                  <option value="Amenities" @if($addon_detail->type == 'Amenities') selected @endif>Amenities</option>
                  <option value="Tickets" @if($addon_detail->type == 'Tickets') selected @endif>Tickets</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">@lang('fleet.addon')</label>
                <select id="addon_list" class="form-control">
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">@lang('fleet.quantity')</label>
                <input type="number" id="addon_quantity" class="form-control" value="{{$booking_detail->addon_quantity}}" min="1" />
              </div>
            </div>
            <div class="col-md-4">
              <img src="" style="width: 100%;" alt="addon_img" id="addon_img" />
            </div>
            <div class="col-md-4">
              <h4>@lang('fleet.description')</h4>
              <p id="addon_description"></p>
            </div>
          </div>
          <div class="row step_button_group">
            <button class="btn btn-info" onclick="gostep(3)"><i class="fa fa-angle-left"></i> @lang('fleet.prev') </button>
            <button class="btn btn-info" onclick="save_booking()"><i class="fa fa-save"></i> @lang('fleet.save_booking') </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<input type="hidden" value="{{$settings}}" id="settings">
@endsection
@section('script')
  <script src="{{ asset('assets/js/moment.js') }}"></script>
  <script src="{{ asset('assets/js/datetimepicker.js') }}"></script>
  <script>
    var getDriverRoute = '{{ url("admin/get_driver") }}';
    var getVehicleRoute = '{{ url("admin/get_vehicle") }}';
    var prevAddress = '{{ url("admin/prev-address") }}';
    var selectDriver = "@lang('fleet.selectDriver')";
    var selectCustomer = "@lang('fleet.selectCustomer')";
    var selectVehicle = "@lang('fleet.selectVehicle')";
    var addCustomer = "@lang('fleet.add_customer')";
    var prevAddressLang = "@lang('fleet.prev_addr')";

    var fleet_email_already_taken = "@lang('fleet.email_already_taken')";
  </script>
  <!-- <script src="{{asset('assets/js/bookings/create.js')}}"></script> -->
  @if (Hyvikk::api('google_api') == '1')
  <script>
    function initMap() {
      $('#pickup_addr').attr("placeholder", "");
      $('#dropoff_addr').attr("placeholder", "");
      // var input = document.getElementById('searchMapInput');
      var pickup_addr = document.getElementById('pickup_addr');
      new google.maps.places.Autocomplete(pickup_addr);

      var dropoff_addr = document.getElementById('dropoff_addr');
      new google.maps.places.Autocomplete(dropoff_addr);

      // autocomplete.addListener('place_changed', function() {
      //     var place = autocomplete.getPlace();
      //     document.getElementById('pickup_addr').innerHTML = place.formatted_address;
      // });
}
  </script>
  <script
    src="https://maps.googleapis.com/maps/api/js?key={{ Hyvikk::api('api_key') }}&libraries=places&callback=initMap"
    async defer></script>
  @endif

  <script>

    let vehicle_list;
    let addon_list;
    let distance_between_two_points = 200;
    let settings;
    let tax;
    let vehicle_amount;
    let track_time = new Date();
    let tax_charge;

    $(document).ready(function() {
      set_datetime();
      get_reservation_list();
      setInterval(set_datetime, 60000);
      get_addon_list('Tours');
      get_vehicle_list($("#vehicle_types").val());
      $(".step-1").show();
      $("#general_date").hide();
      $(".wholeday_component").hide();
      @if($booking_detail->airport_pickup == 'N') $(".airport").hide(); @endif

      settings = JSON.parse($("#settings").val());
      let tax_setting = settings.find(setting => setting.name == 'tax_charge').value;
      if(tax_setting.length > 1) {
        tax = Object.values(JSON.parse(tax_setting)).reduce(function(total, currentValue){
          return total + parseFloat(currentValue);
        }, 0); 
      } else {
        tax = 0;
      }
      $("#service").change(function() {
        if($(this).val() == 'C') {
          $("#driver_list").show();
        } else {
          $("#driver_list").hide();
        }
      })

      $("#vehicle_list").change(function() {
        var id = $(this).val();
        var data = vehicle_list.filter(function(item){
          return item.vehicle_id == id; 
        })[0];
        set_vehicle_detail(data);
      })

      $("#airport_pickup").change(function() {
        if($(this).val() == 'Y') {
          $(".airport").show();
        } else {
          $(".airport").hide();
        }
      })

      $(".set-datetime > .form-group > .radio  input").change(function() {
        if($(this).val() == 'system_date') {
          set_datetime();
          $(".view_datetime").show();
          $("#general_date").hide();
          track_time = new Date();
        } else {
          track_time = $("#general_date .datetimepicker").val();
          $(".view_datetime").hide();
          $("#general_date").show();
        }
      });

      $("#service").change(function() {
        get_reservation_list();
      })

      $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        sideBySide: true,
        icons: {
          previous: 'fa fa-arrow-left',
          next: 'fa fa-arrow-right',
          up: "fa fa-arrow-up",
          down: "fa fa-arrow-down"
        },
        minDate: "{{date('Y-m-d H:i:s')}}"
      });

      $("#addon_type").change(function() {
        get_addon_list($(this).val())
      })
      
    })

    function set_datetime() {
      $(".set-datetime .view_datetime > span").text(get_current_datetime());
    }

    function get_addon_list(type) {
      $.post("{{url('admin/get-addon-list')}}", { type }, function(res){
        addon_list = res.data;
        var str = "";
        var addon_key = 0;
        addon_list.map((item, index) => {
          if(item.id == "{{$booking_detail->addon_id}}"){
            str += `<option value="${item.id}" selected>${item.name}</option>`;
            addon_key = index;
          }
          else
          str += `<option value="${item.id}">${item.name}</option>`;
        })
        $("#addon_list").html(str);
        $("#addon_img").attr("src", "{{asset('uploads/addons')}}" + "/" + addon_list[addon_key].image);
        $("#addon_description").text(addon_list[addon_key].description);
        $("#addon_list").change(function(){
          var id = $(this).val();
          var data = addon_list.filter(function(item){
            return item.id == id; 
          })[0];
          let image = data.image;
          let description = data.description;
          if(addon_list.length < 1) {
            image = 'default.jpg';
            description = '';
          }
          $("#addon_img").attr("src", "{{asset('uploads/addons')}}" + "/" + image);
          $("#addon_description").text(description);
        })
      })
    }

    function get_vehicle_list(id) {
      $.post("{{url('admin/fetch-vehicle-list-by-type')}}", { id }, function(res) {
        vehicle_list = res.data;
        let str = '';
        vehicle_list.map((item) => {
          str += '<option value="' + item.vehicle_id + '">' + item.make_name + '</option>';
        })
        if(vehicle_list.length < 1) {
          str = '<option value="-1">No Data</option>';
        }
        $("#vehicle_list").html(str);
      })
    }

    function get_current_datetime() {
      var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      var date = new Date();
      var day = date.getDate();
      var month = months[date.getMonth()];
      var year = date.getFullYear();

      var hours = date.getHours();
      var minutes = date.getMinutes();
      var ampm = hours >= 12 ? 'pm' : 'am';
      hours = hours % 12;
      hours = hours ? hours : 12; // the hour '0' should be '12'
      minutes = minutes < 10 ? '0' + minutes : minutes;
      var strTime = hours + ':' + minutes + ' ' + ampm;

      return `${day} ${month}, ${year} at ${strTime}`;
    }

    function get_reservation_list() {
      $.post("{{url('admin/booking-service-fetch-condition')}}", { service_type: $("#service").val() }, function (data){
        const reservation_list = data.data;
        let str = "";
        reservation_list.map((reservation) => {
          if(reservation.id == {{$booking_detail->reservation_type}})
            str += `<option value="${reservation.id}" selected>${reservation.name}</option>`;
          else
            str += `<option value="${reservation.id}">${reservation.name}</option>`;
        })
        $("#reservation_list").html(str);
      })
    }

    function set_vehicle_detail(data) {
      $("#vehicle_img").attr("src", "{{asset('uploads/vehicles/')}}" + "/" + data.vehicle_image);
      $("#vehicle_seats").html(data.seats);
      $("#vehicle_doors").html(data.doors);
      $("#vehicle_luggage").html(data.luggage);
      $("#vehicle_aircondition").html(data.aircondition == 'Y' ? 'Yes' : 'No');
      $("#vehicle_transmission").html(data.transmission_type);
      $("#daily_km_allowance").text(data.wdwa_dka);
      $("#daily_extra_per_cost").text(data.wdwa_dkr + "GH₵");
      let diff_days = get_difference_days(pickup_date, dropoff_date);
      $("#estimated_km_to").text(distance_between_two_points - data.wdwa_dka * diff_days > 0 ? distance_between_two_points - data.wdwa_dka * diff_days : 0);
      $("#total_km_allowance").text(distance_between_two_points);
      if($("#reservation_list").val() == 1){
        let hours = $("#number_hours").val();
        let hourly_rate = 0;
        let property = 'hourly';

        // If hours is not equal to '1', modify the property string
        if(hours !== '1') {
            property = 'hourly_' + hours;
        }

        // Get the corresponding value from the data object
        hourly_rate = data[property];
        let fixed_amount = hourly_rate * hours;
        tax_charge = (fixed_amount * tax / 100).toFixed(2);
        vehicle_amount = fixed_amount;
        $("#total_amount").text((vehicle_amount + tax_charge) + "GH₵");
      } else {
        let pickup_date = $("#pickup_date").val();
        let dropoff_date = $("#dropoff_date").val();
        let diff_days = get_difference_days(pickup_date, dropoff_date);
        let daily_cost = 0;
        let reservation_mode = $("#service").val();
        let suffix = reservation_mode === 'C' ? '' : '_sd';
        if(diff_days == 0)
          diff_days = 1;
        if (diff_days > 0 && diff_days < 3)
          daily_cost = data['wdwa_1_2' + suffix];
        else if (diff_days >= 3 && diff_days < 7)
          daily_cost = data['wdwa_3_6' + suffix];
        else if (diff_days >= 7 && diff_days < 15)
          daily_cost = data['wdwa_7_15' + suffix];
        else
          daily_cost = data['wdwa_16_30' + suffix];
        $("#estimated_amount").text(daily_cost + "GH₵");
        let fixed_amount = daily_cost * diff_days;
        if(distance_between_two_points > data.wdwa_dka * diff_days){
          let diff_kms = distance_between_two_points - data.wdwa_dka * diff_days;
          fixed_amount += data.wdwa_dkr * diff_kms;
        }
        tax_charge = (fixed_amount * tax / 100).toFixed(2);
        vehicle_amount = fixed_amount;
        $("#total_amount").text((vehicle_amount + tax_charge) + "GH₵");
      }
    }

    function gostep(step) {
      if(step == 3) {
        if($("#pickup_addr").val() == ""){
          new PNotify({
            title: 'Error',
            text: "@lang('fleet.pickup_address_not_empty')",
            type: 'error'
          });
          return;
        }

        if($("#dropoff_addr").val() == ""){
          new PNotify({
            title: 'Error',
            text: "@lang('fleet.dropoff_address_not_empty')",
            type: 'error'
          });
          return;
        }

        if($("#note").val() == ""){
          new PNotify({
            title: 'Error',
            text: "@lang('fleet.note_not_empty')",
            type: 'error'
          });
          return;
        }

        if($("#airport_pickup").val() == "Y" && $("#airport_detail").val() == "") {
          new PNotify({
            title: 'Error',
            text: "@lang('fleet.airport_detail_not_empty')",
            type: 'error'
          });
          return;
        }

        if(!($("#destination_outside").val() == '' || ($("#reservation_list").val() != 1 || $("#final_destination") == 'Y'))) {
          new PNotify({
            title: 'Error',
            text: "@lang('fleet.destination_outside_accra_not_empty')",
            type: 'error'
          });
          return;
        }
        var id = $("#vehicle_list").val();
        var data = vehicle_list.filter(function(item){
          return item.vehicle_id == id; 
        })[0];
        set_vehicle_detail(data);

        // Get distance 
        // var origin = $("#pickup_addr").val();
        // var destination = $("#dropoff_addr").val();
        // $.post("{{url('admin/get-distance')}}", {origin, destination}, function(res) {
        //   console.log(res);
        // });
      }

      if(step == 4) {
        if(!parseInt($("#vehicle_list").val())) {
          new PNotify({
              title: 'Error',
              text: "@lang('fleet.vehicle') @lang('fleet.is_not_empty')",
              type: 'error'
          });
          return;
        }
      }

      $(".step").hide();
      $(".step-" + step).fadeIn();

      if($("#reservation_list").val() == 1) {
        $(".hourly_component").show();
        $(".wholeday_component").hide();
      } else {
        $(".hourly_component").hide();
        $(".wholeday_component").show();
      }
    }

    function get_difference_days(date1 = '0000-00-00 00:00:00', date2 = '0000-00-00 00:00:00') {
      // Define the two dates
      let from_date = new Date(date1);
      let to_date = new Date(date2);

      // Calculate the difference in milliseconds
      let differenceInMilliseconds = Math.abs(to_date - from_date);

      // Calculate the difference in days
      let differenceInDays = Math.floor(differenceInMilliseconds / (1000 * 60 * 60 * 24));

      return differenceInDays;
    }

    function save_booking() {
      const postData = new FormData();
      postData.append('id', '{{$booking_detail->id}}')
      postData.append('customer_id', $("#customer_list").val());
      postData.append('user_id', "{{Auth::user()->id}}");
      postData.append('vehicle_id', $("#vehicle_list").val());
      postData.append('reservation_type', $("#reservation_list").val());
      postData.append('hours', $("#number_hours").val());
      postData.append('service_type', $("#service").val());
      postData.append('addon_id', $("#addon_list").val());
      postData.append('addon_quantity', $("#addon_quantity").val());
      if($("#service").val() == "C")
        postData.append('driver_id', $("#driver_list select").val());
      postData.append('pickup', $("#pickup_date").val());
      postData.append('dropoff', $("#dropoff_date").val());
      postData.append('duration', get_difference_days($("#pickup_date").val(), $("#dropoff_date").val()) * 24 * 60);
      postData.append('pickup_addr', $("#pickup_addr").val());
      postData.append('dest_addr', $("#dropoff_addr").val());
      postData.append('note', $("#note").val());
      postData.append('travellers', $("#traveller_count").val());
      postData.append('airport_pickup', $("#airport_pickup").val());
      postData.append('airport_pickup_details', $("#airport_detail").val());
      postData.append('airport_date', $("#airport_date").val());
      postData.append('final_destination', $("#final_destination").val());
      postData.append('destination_outside', $("#destination_outside").val());
      postData.append('tax_charge', tax_charge);
      postData.append('tax_total', vehicle_amount);
      postData.append('track_time', track_time);
      postData.append('tax_percent', tax)

      $.ajax({
        url: "{{url('admin/booking-update')}}",
        type: "POST",
        data: postData,
        processData: false,  // tell jQuery not to process the data
        contentType: false,  // tell jQuery not to set contentType
        success: function (res) {
          if(!res.success) {
            new PNotify({
              title: 'Error',
              text: "@lang('fleet.booking_updated_failed')",
              type: 'error'
            });
            return;
          }
          new PNotify({
            title: 'Success',
            text: "@lang('fleet.booking_updated_successfully')",
            type: 'success'
          });
          setTimeout(function(){ location.reload(''); }, 1000);
        }
      });
    }
  </script>
@endsection