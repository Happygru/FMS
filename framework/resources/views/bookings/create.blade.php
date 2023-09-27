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
<li class="breadcrumb-item active">@lang('fleet.new_booking')</li>
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-success">
      <div class="card-header">
        <h3 class="card-title">
            @lang('fleet.new_booking')
        </h3>
      </div>
      <div class="card-body">
        <div class="step general_infomation step-1">
          <h3>@lang('fleet.general_information')</h3>
          <div class="row">
            <div class="col-md-12 set-datetime">
              <div class="form-group">
                <div class="radio">
                  <label>
                    <input type="radio" name="dateTimeOption" value="system_date" checked>
                    @lang('fleet.use_system_datetime')
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="dateTimeOption" value="input_date">
                    @lang('fleet.enter_datetime')
                  </label>
                </div>
                <div class="view_datetime">
                   @lang('fleet.current_system_datetime'): <span></span>
                </div>
              </div>
            </div>
          </div>
          <div class="row" id="general_date">
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
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">Yoks Branch</label>
                <select class="form-control">
                  @foreach($branches as $branch)
                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label"> @lang('fleet.service_type') </label>
                <select class="form-control" id="service">
                  <option value="C">Chauffeur-Driven</option>
                  <option value="S">Self-Driven</option>
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
                    <option value="{{$customer->id}}">{{$customer->name}}</option>
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
                  <input type="text" id="pickup_date" class="form-control datetimepicker" value="{{date('Y-m-d H:i:s')}}">
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
                  <input type="text" id="dropoff_date" class="form-control datetimepicker" value="{{date('Y-m-d H:i:s')}}">
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 wholeday_component">
              <div class="form-group">
                <label class="form-label">
                  @lang('fleet.final_destination_outside_accra')?
                </label>
                <select id="destination" class="form-control">
                  <option value="Y">Yes</option>
                  <option value="N">No</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 hourly_component">
              <div class="form-group">
                <label class="form-label">@lang('fleet.number_of_hours')</label>
                <select id="number_hours" class="form-control">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 col-sm-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.airport_pickup')?</label>
                <select id="airport_pickup" class="form-control">
                  <option value="Y">Yes</option>
                  <option value="N" selected>No</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-6" id="driver_list">
              <div class="form-group">
                <label class="form-label">@lang('fleet.selectDriver')</label>
                <select class="form-control">
                  @foreach($drivers as $driver)
                    <option value="{{$driver->id}}">{{$driver->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.no_travellers')</label>
                <input type="number" id="traveller_count" class="form-control" min="1" value="1">
              </div>
            </div>
            <div class="col-md-3 col-sm-6 wholeday_component">
              <div class="form-group">
                <label class="form-label">@lang('fleet.destination_outside_accra')</label>
                <input type="text" id="final_destination" class="form-control" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 col-sm-12">
              <div class="row">
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                    <label class="form-label">@lang('fleet.pickup_addr')</label>
                    <input type="text" class="form-control" name="" id="pickup_addr" />
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                    <label class="form-label">@lang('fleet.dropoff_addr')</label>
                    <input type="text" name="" id="dropoff_addr" class="form-control">
                  </div>
                </div>
                <div class="col-md-6 col-sm-12 airport">
                  <div class="form-group">
                    <label class="form-label">@lang('fleet.airport_arrival_datetime')</label>
                    <div class='input-group mb-3 date'>
                      <div class="input-group-prepend">
                          <span class="input-group-text"> <span class="fa fa-calendar"></span></span>
                      </div>
                      <input type="text" id="airport_date" class="form-control datetimepicker" value="{{date('Y-m-d H:i:s')}}">
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12 airport">
                  <div class="form-group">
                    <label class="form-label">@lang('fleet.airport_pickup_flight_details')</label>
                    <input type="text" class="form-control" id="airport_detail">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="form-group">
                <label class="form-label">@lang('fleet.note')</label>
                <textarea id="note" rows="5" class="form-control" placeholder="Enter Note for this booking"></textarea>
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
                <label class="form-label">@lang('fleet.selectVehicle')</label>
              </div>
              <select id="vehicle_list" class="form-control">
                @foreach($vehicles as $vehicle)
                  <option value="{{$vehicle->vehicle_id}}">{{$vehicle->make_name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <img src="{{asset('uploads/vehicles/'.$vehicles[0]->vehicle_image)}}" style="width: 100%;" alt="vehicle_img" id="vehicle_img" />
              <input type="hidden" id="vehicles_data_string" value="{{$vehicles}}">
            </div>
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-4 col-sm-6">
                  <p><i class="fa fa-user-group"></i> - <span id="vehicle_seats">{{$vehicles[0]->seats}}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                  <p><i class="fa fa-window-maximize"></i> - <span id="vehicle_doors">{{$vehicles[0]->doors}}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                  <p><i class="fa fa-luggage-cart"></i> - <span id="vehicle_luggage">{{$vehicles[0]->luggage}}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                  <p><i class="fa fa-snowflake"></i> - <span id="vehicle_aircondition">{{$vehicles[0]->aircondition == 'Y' ? 'Yes' : 'No'}}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                  <p><i class="fa fa-sliders"></i> - <span id="vehicle_transmission">{{$vehicles[0]->transmission_type}}</span></p>
                </div>
              </div>
              <div class="row vehicle_detail">
                <div class="col-md-6">
                  <span>@lang('fleet.daily_km_allowance')</span>
                </div>
                <div class="col-md-6">
                  <p>150</p>
                </div>
                <div class="col-md-6">
                  <span>Cost per extra km</span>
                </div>
                <div class="col-md-6">
                  <p>0.25USD / 2.875GHS</p>
                </div>
                <div class="col-md-6">
                  @lang('fleet.extra_km_payable')
                </div>
                <div class="col-md-6 vehicle">
                  <p>Estimated km to & from acc: 60 km</p>
                  <hr />
                  <p>Total km Allowance : 0 km</p>
                  <hr />
                  <p>Estimated amount : 15 USD / 172.5GHS</p>
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
                  <option value="Tours">Tours</option>
                  <option value="Extras">Extras</option>
                  <option value="Amenities">Amenities</option>
                  <option value="Tickets">Tickets</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">@lang('fleet.addon')</label>
                <select id="addon_list" class="form-control">
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">@lang('fleet.quantity')</label>
                <input type="number" id="addon_quantity" class="form-control" value="1" min="1" />
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

    $(document).ready(function() {
      set_datetime();
      get_reservation_list();
      setInterval(set_datetime, 60000);
      get_addon_list('Tours');
      $(".step-1").show();
      $("#general_date").hide();
      $(".wholeday_component").hide();
      $(".airport").hide();
      vehicle_list = JSON.parse($("#vehicles_data_string").val());

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
        $("#vehicle_img").attr("src", "{{asset('uploads/vehicles/')}}" + "/" + data.vehicle_image);
        $("#vehicle_seats").html(data.seats);
        $("#vehicle_doors").html(data.doors);
        $("#vehicle_luggage").html(data.luggage);
        $("#vehicle_aircondition").html(data.aircondition == 'Y' ? 'Yes' : 'No');
        $("#vehicle_transmission").html(data.transmission_type);
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
        } else {
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
        addon_list.map((item) => {
          str += `<option value="${item.id}">${item.name}</option>`
        })
        $("#addon_list").html(str);
        $("#addon_img").attr("src", "{{asset('uploads/addons')}}" + "/" + addon_list[0].image);
        $("#addon_description").text(addon_list[0].description);
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
          str += `<option value="${reservation.id}">${reservation.name}</option>`;
        })
        $("#reservation_list").html(str);
      })
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

        if($("#final_destination").val() == '' && $("#reservation_list").val() != 1) {
          new PNotify({
            title: 'Error',
            text: "@lang('fleet.destination_outside_accra_not_empty')",
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
  </script>
@endsection