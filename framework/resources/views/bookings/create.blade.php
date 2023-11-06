@extends('layouts.app')
@section('extra_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
<style>
  
  #reviewModal table,
  #reviewModal thead,
  #reviewModal tbody {
    width: 100%:
  }

  #reviewModal th {
    background-color: #dedede;
  }

  .addon_item {
    margin-top: 15px;
    display: flex;
    flex-direction: column;
    gap: 5px;
  }
  
  .addon_item .form-group {
    display: flex;
    gap: 5px;
    align-items: center;
  }

  .addon_item .description {
    position: relative;
  }

  .addon_item .form-group select.form-control {
    width: max-content
  }

  .addon_item .select_btn {
    width: 30px;
    height: 30px;
    position: absolute;
    top: 0;
    right: 0;
  }

  .addon_item .price {
    font-size: 18px;
    font-weight: bold;
  }

  .addon_item .title {
    font-weight: bold;
  }

  .addon_item > div{
    display: flex;
    gap: 10px;
  }

  .addon_item img{
    width: 100%;
    max-width: 350px;
  }
  
  #general_date {
    display: none;
  }

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

  .step-1 {
    display: block;
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

  #full_loader .loader {
    position: relative;
    width: 164px;
    height: 164px;
    border-radius: 50%;
    animation: rotate 0.75s linear infinite;
  }
  #full_loader .loader::before {
    content: '';
    position: absolute;
    width: 20px;
    height: 40px;
    border: 1px solid #FF3D00;
    border-width: 12px 2px 7px;
    border-radius: 2px 2px 1px 1px;
    box-sizing: border-box;
    transform: rotate(45deg) translate(24px, -10px);
    background-image: linear-gradient(#FF3D00 20px, transparent 0),
    linear-gradient(#FF3D00 30px, transparent 0),
    linear-gradient(#FF3D00 30px, transparent 0);
    background-size: 10px 12px , 1px 30px, 1px 30px;
    background-repeat: no-repeat;
    background-position: center , 12px 0px , 3px 0px;
  }
  #full_loader .loader::after {
    content: '';
    position: absolute;
    height: 4px;
    width: 4px;
    left: 20px;
    top: 47px;
    border-radius: 50%;
    color: #Fff;
    box-shadow: -4px 7px 2px, -7px 16px 3px 1px,
    -11px 24px 4px 1px, -6px 24px 4px 1px,
    -14px 35px 6px 2px, -5px 36px 8px 2px,
    -5px 45px 8px 2px, -14px 49px 8px 2px,
    6px 60px 11px 1px, -11px 66px 11px 1px,
    11px 75px 13px, -1px 82px 15px;
  }

  @keyframes rotate {
    to{transform:rotate(360deg)}
  }

  #full_loader {
    position: fixed;
    top: 0;
    left: 0;
    transition: all;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    background-color: rgba(255,255,255,0.9);
    width: 100vw;
    height: 100vh;
  }

  #reviewModal .modal-dialog {
    margin: 0;
  }

  #reviewModal .modal-content {
    width: 100vw;
    border-radius: 0;
  }
  
  #reviewModal .modal-body {
    padding: 0;
  }

  #reviewModal .title {
    background-color: #024273;
    width: 100%;
    text-align: center;
    padding: 10px;
    font-size: 24px;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
  }

  #reviewModal .cost_bar {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    font-size: 20px;
    font-weight: bold;
    gap: 30px;
  }

  #reviewModal .total_cost {
    font-size: 20px;
    width: 170px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #ed8b00;
    font-weight: bold;
  }

  .px {
    padding-inline: 10%;
  }
  .py {
    padding-block: 30px;
  }
  #reviewModal h4 {
    font-weight: bold;
    font-size: 22px;
  }
</style>
@endsection
@section('breadcrumb')
<li class="breadcrumb-item "><a href="{{ route('bookings.index') }}">@lang('menu.bookings')</a></li>
<li class="breadcrumb-item active">@lang('fleet.new_booking')</li>
@endsection
@section('content')
<div id="full_loader"><span class="loader"></span></div>
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
                <select class="form-control" id="branch">
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
                <select class="form-control" id="reservation">
                  @foreach($reservations as $reservation)
                    <option value="{{$reservation->id}}">{{ $reservation->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row step_button_group">
            <button class="btn btn-info" onclick="gostep(2, 'next')"> @lang('fleet.next') <i class="fa fa-angle-right"></i></button>
          </div>
        </div>
        <div class="step step-2">
          <h3>@lang('fleet.booking_detail') <span class="wholeday_component">(@lang('fleet.whole_day_service'))</span><span class="hourly_component">(@lang('fleet.hourly_service'))</span></h3>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label class="form-label">@lang('fleet.select_customer')</label>
                <select id="customer" class="form-control">
                  @foreach($customers as $customer)
                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
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
            <div class="col-lg-3 col-md-6 col-sm-12">
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
            <div class="col-lg-3 col-md-6 col-sm-12 hourly_component">
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
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label class="form-label">@lang('fleet.selectDriver')</label>
                <select class="form-control" id="driver">
                  @foreach($drivers as $driver)
                    <option value="{{$driver->id}}">{{$driver->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label class="form-label">@lang('fleet.no_travellers')</label>
                <input type="number" id="traveller_count" class="form-control" min="1" value="1">
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 wholeday_component">
              <div class="form-group">
                <label class="form-label">
                  @lang('fleet.final_destination_outside_accra')?
                </label>
                <select id="final_destination" class="form-control">
                  <option value="Y">Yes</option>
                  <option value="N">No</option>
                </select>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 wholeday_component">
              <div class="form-group">
                <label class="form-label">@lang('fleet.destination_outside_accra')</label>
                <input type="text" id="destination_outside" class="form-control" />
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label class="form-label">@lang('fleet.pickup_addr')</label>
                <input type="text" class="form-control" name="" id="pickup_addr" />
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label class="form-label">Dropoff Location Same as Pickup?</label>
                <select id="dropoff_pickup_show" class="form-control">
                  <option value="Y">Yes</option>
                  <option value="N" selected>No</option>
                </select>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label class="form-label">@lang('fleet.dropoff_addr')</label>
                <input type="text" name="" id="dropoff_addr" class="form-control">
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label class="form-label">@lang('fleet.airport_pickup')?</label>
                <select id="airport_pickup" class="form-control">
                  <option value="Y">Yes</option>
                  <option value="N">No</option>
                </select>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 airport_component">
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
            <div class="col-lg-3 col-md-6 col-sm-12 airport_component">
              <div class="form-group">
                <label class="form-label">@lang('fleet.airport_pickup_flight_details')</label>
                <input type="text" class="form-control" id="airport_detail">
              </div>
            </div>
            <!-- <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label class="form-label">@lang('fleet.note')</label>
                <textarea id="note" class="form-control"></textarea>
              </div>
            </div> -->
          </div>
          <div class="row step_button_group">
            <button class="btn btn-info" onclick="gostep(1, 'prev')"> <i class="fa fa-angle-left"></i> @lang('fleet.prev')</button>
            <button class="btn btn-info" onclick="gostep(3, 'next')"> @lang('fleet.next') <i class="fa fa-angle-right"></i></button>
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
                  <option value="{{$vehicle_type->id}}">{{$vehicle_type->displayname}}</option>
                @endforeach
              </select>
              <div class="form-group mt-4">
                <label class="form-label">@lang('fleet.selectVehicle')</label>
              </div>
              <select id="vehicles" class="form-control"></select>
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
              <div class="row vehicle_detail wholeday_component">
                <div class="col-md-6">
                  <span>@lang('fleet.daily_km_allowance')</span>
                </div>
                <div class="col-md-6">
                  <p id="daily_km_allowance">{{$vehicles[0]->wdwa_dka}}</p>
                </div>
                <div class="col-md-6">
                  <span>@lang('fleet.cost_per_extra_km')</span>
                </div>
                <div class="col-md-6">
                  <p id="daily_extra_per_cost">GH₵{{$vehicles[0]->wdwa_dkr}}</p>
                </div>
                <div class="col-md-6">
                  @lang('fleet.extra_km_payable')
                </div>
                <div class="col-md-6 vehicle">
                  <p>@lang('fleet.estimated_km_to_from_acc'): <span id="estimated_km_to">60</span>km</p>
                  <hr />
                  <p>@lang('fleet.estimated_amount'): GH₵<span id="estimated_amount"></span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="row step_button_group">
            <button class="btn btn-info" onclick="gostep(2, 'prev')"><i class="fa fa-angle-left"></i> @lang('fleet.prev') </button>
            <button class="btn btn-info" onclick="gostep(4, 'next')"> @lang('fleet.next') <i class="fa fa-angle-right"></i></button>
          </div>
        </div>
        <div class="step step-4">
          <h3>Select Addon</h3>
          <div class="row">
            <div class="col-lg-4 col-md-12">
              <div class="form-group">
                <label class="form-label">@lang('fleet.addon_type')</label>
                <select id="addon_types" class="form-control">
                  <option value="Tours">Tours</option>
                  <option value="Extras">Extras</option>
                  <option value="Amenities">Amenities</option>
                  <option value="Tickets">Tickets</option>
                </select>
              </div>
            </div>
            <div class="col-lg-8 col-md-12" id="addon_list">

            </div>
          </div>
          <div class="row step_button_group">
            <button class="btn btn-info" onclick="gostep(3, 'prev')"><i class="fa fa-angle-left"></i> @lang('fleet.prev') </button>
            <button class="btn btn-info" onclick="gostep(5, 'next')"><i class="fa fa-save"></i>@lang('fleet.review') & @lang('fleet.save')</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="reviewModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h4 class="modal-title">@lang('fleet.review') & @lang('fleet.save')</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> -->
      <div class="modal-body">
        <div class="title">booking information</div>
        <div class="px py">
          <div class="row">
            <div class="col-md-6 col-sm-12">
              <h4>Reservation Type</h4>
              <p id="review_reservation"></p>
            </div>
            <div class="col-md-6 col-sm-12">
              <h4>Service Type</h4>
              <p id="review_service"></p>
            </div>
            <div class="col-md-6 col-sm-12">
              <h4>Start Date/Time</h4>
              <p id="review_start_date"></p>
            </div>
            <div class="col-md-6 col-sm-12">
              <h4>End Date/Time</h4>
              <p id="review_end_date"></p>
            </div>
            <div class="col-md-6 col-sm-12">
              <h4>Duration</h4>
              <p id="review_duration"></p>
            </div>
            <div class="col-md-6 col-sm-12">
              <h4>Base Rate/Day</h4>
              <p id="review_base_rate"></p>
            </div>
            <div class="col-md-6 col-sm-12">
              <h4>Pickup Location</h4>
              <p id="review_pickup_location"></p>
            </div>
            <div class="col-md-6 col-sm-12">
              <h4>Dropoff Location</h4>
              <p id="review_dropoff_location"></p>
            </div>
            <div class="col-md-6 col-sm-12">
              <h4>Vehicle Category</h4>
              <p id="review_vehicle_category"></p>
            </div>
            <div class="col-md-6 col-sm-12">
              <h4>Vehicle Daily Insurance Rate</h4>
              <p id="review_vehicle_daily_insurance_rate"></p>
            </div>
          </div>
        </div>
        <div class="title">add-on information</div>
        <div class="px">
          <div class="row">
            <div class="col-md-12">
              <table class="table">
                <thead>
                  <tr>
                    <th>Addon</th>
                    <th>Addon Type</th>
                    <th>Qty</th>
                    <th>Unit Price(GH₵)</th>
                    <th>Amount(GH₵)</th>
                  </tr>
                </thead>
                <tbody id="addon_table">
                  
                </tbody>
              </table>
            </div>
          </div>
          <div class="cost_bar">
            <span>Total</span>
            <div class="total_cost addon_total_cost">
              2023
            </div>
          </div>
        </div>
        <div class="title">billing details</div>
        <div class="px">
          <div class="row">
            <div class="col-md-12">
              <table class="table">
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Amount(GH₵)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Vehicle Reservation</td>
                    <td id="vehicle_reservation_amount"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="cost_bar">
            <span>Total</span>
            <div class="total_cost vehicle_amount">
              2023
            </div>
          </div>
        </div>
        <div class="px">
          <div style="width: 100%; height: 49px; background: #dedede;"></div>
          <div style="width: 100%; margin-top: 30px">
            <table class="table">
              <tbody id="tax_table">

              </tbody>
            </table>
          </div>
          <div class="cost_bar">
            <span>Total</span>
            <div class="total_cost vehicle_tax_amount">
              2023
            </div>
          </div>
        </div>
        <!-- <div class="px">
          <div style="width: 100%; height: 49px; background: #dedede;"></div>
          <div class="row">
            <div class="col-md-2 col-sm-12"></div>
            <div class="col-md-8 col-sm-12">
              <div class="form-group">
                <label class="form-label">@lang('fleet.note')</label>
                <textarea id="review_note" rows="5" class="form-control"></textarea>
              </div>
            </div>
            <div class="col-md-2 col-sm-12"></div>
          </div>
        </div> -->
        <div class="px" style="padding-top: 30px;">
          <div class="cost_bar" style="justify-content: center;">
            <span>Grant Total</span>
            <div class="total_cost total_amount">
              2023
            </div>
          </div>
          <div style="width: 100%; height: 49px; background: #024273;"></div>
        </div>
        <div class="row">
          <div class="col-md-12" style="display: flex; justify-content: center; align-items: center; gap: 20px; padding-block: 20px;">
            <a class="btn btn-info" href="javascript:;" style="font-size: 20px; padding: 10px 20px;" onclick="save_booking()"> <i class="fa fa-save"></i> @lang('fleet.save')</a>
            <button type="button" class="btn btn-default" style="font-size: 20px; padding: 10px 20px;"> <i class="fa fa-print"></i> @lang('fleet.print')</button>
          </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <a class="btn btn-info" href="javascript:;"> <i class="fa fa-save"></i> @lang('fleet.save')</a>
        <button type="button" class="btn btn-default"> <i class="fa fa-print"></i> @lang('fleet.print')</button>
      </div> -->
    </div>
  </div>
</div>
<input type="hidden" value="{{$settings}}" id="settings">
@endsection
@section('script')

@if (Hyvikk::api('google_api') == '1')
  <script>
    function initMap() {

      $('#pickup_addr').attr("placeholder", "");
      $('#dropoff_addr').attr("placeholder", "");
      $("#destination_outside").attr("placeholder", "");

      // var input = document.getElementById('searchMapInput');
      var pickup_addr = document.getElementById('pickup_addr');
      new google.maps.places.Autocomplete(pickup_addr);

      var dropoff_addr = document.getElementById('dropoff_addr');
      new google.maps.places.Autocomplete(dropoff_addr);

      var destination_outside = document.getElementById('destination_outside');
      new google.maps.places.Autocomplete(destination_outside);

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

<script src="{{ asset('assets/js/moment.js') }}"></script>
<script src="{{ asset('assets/js/datetimepicker.js') }}"></script>
<script>

  var branch, service, reservation; //general information
  var customer, pickup_date, dropoff_date,
      is_outside, driver, children,is_airport,
      destination_outside, is_dropoff, pickup_addr,
      dropoff_addr, airport_date, airport_detail, hours,
      distance, distance_extra, note;
  var vehicles;
  var active_addons = [];
  var vehicle_total_cost = 0, addon_total_cost = 0;
  var tax = 0, tax_array = [];
  var vehicle_amount = 0, vehicle_tax_amount = 0;
  var addon_amount = 0;
  var estimated_amount, distance_extra, cost_per_km, allowance_distance, base_rate, insurance_rate = 0;
  var diff_days;
  var track_time = new Date();
  $(document).ready(function() {

    $('.datetimepicker').datetimepicker({
      format: 'YYYY-MM-DD HH:mm:ss',
      sideBySide: true,
      icons: {
          previous: 'fa fa-arrow-left',
          next: 'fa fa-arrow-right',
          up: "fa fa-arrow-up",
          down: "fa fa-arrow-down"
      }
    });

    $("#full_loader").hide();
    get_vehicles($("#vehicle_types").val());
    get_addons($("#addon_types").val());
    getTax();
    // general information, step-1
    set_datetime();
    setInterval(set_datetime, 60000);
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


    // Booking Detail, step-2
    $("#final_destination").change(function() {
      $("#destination_outside").val('');
      if($(this).val() == 'Y'){
        $("#destination_outside").parent().parent().show()
      }
      else
        $("#destination_outside").parent().parent().hide();
    })

    $("#airport_pickup").change(function() {
      $("#airport_detail").val('');
      if($(this).val() == 'Y') {
        $(".airport_component").show();
      } else {
        $(".airport_component").hide();
      }
    })

    $("#dropoff_pickup_show").change(function() {
      $("#dropoff_addr").val('');
      if($(this).val() == 'N') {
        $("#dropoff_addr").parent().parent().show();
      } else {
        $("#dropoff_addr").parent().parent().hide();
      }
    })

    // Vehicle Detail, step - 3
    $("#vehicles").change(function() {
      var id = $(this).val();
      var data = vehicles.filter(function(item){
        return item.vehicle_id == id; 
      })[0];
      set_vehicle(data);
    })

    $("#vehicle_types").change(function() {
      get_vehicles($(this).val());
    })

    // Addon
    $("#addon_types").change(function() {
      get_addons($(this).val());
    })
  })

  function gostep(step, dir) {
    switch(step) {
      case 1:
        firststep(dir);
        break;
      case 2:
        branch = $("#branch").val();
        service = $("#service").val();
        reservation = $("#reservation").val();
        secondstep(dir);
        break;
      case 3:
        thirdstep(dir);
        break;
      case 4:
        fourthstep(dir);
        break;
      case 5:
        review();
    }
  }

  function firststep(dir) {
    $(".step").hide();
    $(".step-1").show();
  }

  function secondstep(dir) {
    $(".step").hide();
    $(".step-2").show();
    $(".wholeday_component, .hourly_component").hide();
    if(reservation == 1)
      $(".hourly_component").show();
    else
      $(".wholeday_component").show();
  }

  async function thirdstep(dir) {
    if(dir == 'next') {
      // Initialize variables.
      customer = $("#customer").val();
      pickup_date = $("#pickup_date").val();
      dropoff_date = $("#dropoff_date").val();
      is_outside = $("#final_destination").val();
      driver = $("#driver").val();
      children = $("#traveller_count").val();
      is_airport = $("#airport_pickup").val();
      destination_outside = $("#destination_outside").val();
      is_dropoff = $("#dropoff_pickup_show").val();
      pickup_addr = $("#pickup_addr").val();
      dropoff_addr = $("#dropoff_addr").val();
      airport_date = $("#airport_date").val();
      airport_detail = $("#airport_detail").val();
      hours = $("#number_hours").val();
      note = $("#note").val();

      if(pickup_addr == '') {
        new PNotify({
          title: 'Error',
          text: "@lang('fleet.pickup_address_not_empty')",
          type: 'error'
        });
        return;
      }

      if(reservation != 1 && is_outside == 'Y' && destination_outside == '') {
        new PNotify({
          title: 'Error',
          text: "@lang('fleet.destination_outside_accra_not_empty')",
          type: 'error'
        });
        return;
      }

      if(is_airport == 'Y' && airport_detail == '') {
        new PNotify({
          title: 'Error',
          text: "@lang('fleet.airport_detail_not_empty')",
          type: 'error'
        });
        return;
      }

      if(is_dropoff == 'N' && dropoff_addr == '') {
        new PNotify({
          title: 'Error',
          text: "@lang('fleet.dropoff_address_not_empty')",
          type: 'error'
        });
        return;
      }

      let calculate_success = true;
      $("#full_loader").show();
      if(reservation != 1) {
        if(is_outside == 'Y') {
          let obj_distance = await get_distance(dropoff_addr, destination_outside);
          distance = obj_distance.distance;
          calculate_success = obj_distance.success
        } else {
          distance = 0;
          distance_extra = 0;
          calculate_success = true;
        }
      }
      $("#full_loader").hide();
      if(!calculate_success){
        new PNotify({
          title: 'Error',
          text: "@lang('fleet.address_invalid')",
          type: 'error'
        });
        return;
      }
    }
    $(".step").hide();
    $(".step-3").show();
  }

  function fourthstep(dir) {
    if(dir == 'next') {
      if($("#vehicles").val() == '-1') {
        new PNotify({
          title: 'Error',
          text: "@lang('fleet.vehicle') @lang('fleet.is_not_empty')",
          type: 'error'
        });
        return;
      }
    }
    $(".step").hide();
    $(".step-4").show();
  }

  function review() {
    setActiveAddons();
    $("#reviewModal").modal('show');
    $("#review_reservation").text($("#reservation :selected").text());
    $("#review_service").text($("#service :selected").text());
    $("#review_start_date").text(pickup_date);
    $("#review_end_date").text(dropoff_date);
    var date1 = new Date(pickup_date); // replace with your first date
    var date2 = new Date(dropoff_date); // replace with your second date

    var diffTime = Math.abs(date2 - date1);
    diff_days = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
    $("#review_duration").text(diff_days + "Day(s)");
    $("#review_base_rate").text("GH₵" + base_rate);
    $("#review_pickup_location").text(pickup_addr);
    $("#review_dropoff_location").text(dropoff_addr);
    $("#review_vehicle_category").text($("#vehicles :selected").text());
    $("#review_vehicle_daily_insurance_rate").text(insurance_rate);

    var str = "";
    active_addons.map(item => 
      {
        str += `
          <tr>
            <td>${item.name}</td>
            <td>${item.type}</td>
            <td>${item.quantity}</td>
            <td>${item.price}</td>
            <td>${item.price * item.quantity}</td>
          </tr>`;
          addon_amount += item.price * item.quantity;
      }
    );
    if(active_addons.length < 1){
      str = `<tr><td colspan="5" style="text-align: center;">No Data</td></tr>`
      addon_amount = 0;
    }
    $("#addon_table").html(str);
    $(".addon_total_cost").text("GH₵" + addon_amount);
    $("#vehicle_reservation_amount").text("GH₵" + vehicle_amount);

    $(".vehicle_amount").text("GH₵" + vehicle_amount);

    var tax_keys = Object.keys(tax_array);
    var str = "";
    tax_keys.map(item => {
      str += `
        <tr>
          <td>${item}(${tax_array[item]}%)</td>
          <td>${vehicle_amount * parseInt(tax_array[item]) / 100}</td>
        </tr>
      `
    })
    str += `<tr>
              <td>Insurance</td>
              <td>${insurance_rate}</td>
            </tr>`;
    $("#tax_table").html(str);
    vehicle_tax_amount += insurance_rate;
    $(".vehicle_tax_amount").text("GH₵" + vehicle_tax_amount);
    $("#review_note").val(note);

    $(".total_amount").text("GH₵" + (vehicle_amount + vehicle_tax_amount + addon_amount).toFixed(2));
  }

  // set current datetime
  function set_datetime() {
    $(".set-datetime .view_datetime > span").text(get_current_datetime());
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

  async function get_distance(origin, destination) {
    var token = "{{ csrf_token() }}";

    let response = await fetch("{{url('admin/get-distance')}}", {
      method: 'POST', 
      headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token
      },
      body: JSON.stringify({origin, destination})
    });
    let res = await response.json();
    
    if (res.success) {
      distance_between_two_points = (res.distance * 1.60934).toFixed(2);
      return { success: true, distance: distance_between_two_points };
    } else {
      distance_between_two_points = 0;
      return { success: false, distance: distance_between_two_points };
    }
  }

  function get_vehicles(id) {
    $.post("{{url('admin/fetch-vehicle-list-by-type')}}", { id, branch_id: $("#branch").val() }, function(res) {
      vehicles = res.data;
      let str = '';
      vehicles.map((item) => {
        str += '<option value="' + item.vehicle_id + '">' + item.make_name + '</option>';
      })
      if(vehicles.length < 1) {
        str = '<option value="-1">No Data</option>';
      }
      $("#vehicles").html(str);
      set_vehicle(vehicles[0]);
    })
  }

  function set_vehicle(data) {
    if(!data)
      return;
    $("#vehicle_img").attr("src", "{{asset('uploads/vehicles/')}}" + "/" + data.vehicle_image);
    $("#vehicle_seats").html(data.seats);
    $("#vehicle_doors").html(data.doors);
    $("#vehicle_luggage").html(data.luggage);
    $("#vehicle_aircondition").html(data.aircondition == 'Y' ? 'Yes' : 'No');
    $("#vehicle_transmission").html(data.transmission_type);
    if(reservation != 1) {
      allowance_distance = data.wdwa_dka;
      $("#daily_km_allowance").text(allowance_distance);
      cost_per_km = data.wdwa_dkr;
      $("#daily_extra_per_cost").text(cost_per_km);
      distance_extra = distance > allowance_distance ? distance - allowance_distance : 0;
      $("#estimated_km_to").text(distance_extra);
      estimated_amount = cost_per_km * distance_extra;
      $("#estimated_amount").text(estimated_amount);
      if(service == 'C')
        base_rate = data.wdwa_1_2;
      else
        base_rate = data.wdwa_1_2_sd;
      vehicle_amount = base_rate + estimated_amount;
    } else {
      if(service == 'S')
        base_rate = data.hourly_sd;
      else{
        switch(parseInt(hours)) {
          case 1:
            base_rate = data.hourly;
            break;
          case 2:
            base_rate = data.hourly_2;
            break;
          case 3:
            base_rate = data.hourly_3;
            break;
          case 4:
            base_rate = data.hourly_4;
            break;
          default:
            base_rate = data.hourly;
        }
        vehicle_amount = base_rate * hours;
      }
    }
    if(is_airport) {
      vehicle_amount += data.airport_rate;
    }
    vehicle_tax_amount = vehicle_amount * tax / 100;
    insurance_rate = data.ins_1_2;
    $("#total_amount").text("GH₵" + (vehicle_amount + vehicle_tax_amount));
  }

  function get_addons(type) {
    setActiveAddons();
    $.post("{{url('admin/get-addon-list')}}", { type }, function(res) {
      var addon_list = res.data;
      var str = '';
      addon_list.map(item => {
        var selected_obj = active_addons.find(obj => obj.id === item.id);
        quantity = 0;
        checked = false;
        if(selected_obj) {
          quantity = parseInt(selected_obj.quantity);
          checked = true;
        }
        str += `<div class="row addon_item">
                  <h4 class="title">${item.name}</h4>
                  <div>
                    <img src="{{url('uploads/addons')}}/${item.image}" />
                    <div class="description">
                      <p class="price">GH₵${item.price}</p>
                      <p>${item.description}</p>
                      <input class="form-control select_btn addon_check" data-name="${item.name}" data-type="${item.type}" data-id="${item.id}" data-price="${item.price}" ${ checked ? 'checked' : '' } type="checkbox"/>
                      <div class="form-group">
                        <label class="form-lable">@lang('fleet.quantity')</label>
                        <select class="form-control input-sm addon_quantity">
                          <option ${quantity == 1 ? 'selected' : ''}>1</option>
                          <option ${quantity == 2 ? 'selected' : ''}>2</option>
                          <option ${quantity == 3 ? 'selected' : ''}>3</option>
                          <option ${quantity == 4 ? 'selected' : ''}>4</option>
                          <option ${quantity == 5 ? 'selected' : ''}>5</option>
                          <option ${quantity == 6 ? 'selected' : ''}>6</option>
                          <option ${quantity == 7 ? 'selected' : ''}>7</option>
                          <option ${quantity == 8 ? 'selected' : ''}>8</option>
                          <option ${quantity == 9 ? 'selected' : ''}>9</option>
                          <option ${quantity == 10 ? 'selected' : ''}>10</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>`;
      })
      $("#addon_list").html(str);
    })
  }

  function setActiveAddons() {

    var unchecked_data = [];

    $(".addon_check").each(function() {
      var checked = $(this).get(0).checked;
      var id = $(this).data('id');
      var quantity = $(this).next('.form-group').find('.addon_quantity').val();
      var price = $(this).data('price');
      var name = $(this).data('name');
      var type = $(this).data('type');

      if(checked) {
        active_addons.push({ id, quantity, price, name, type });
      } else {
        unchecked_data.push({ id, quantity, price, name, type });
      }
    })
    data = active_addons
    .filter(obj => 
      !unchecked_data.some(obj2 => obj2.id === obj.id)
    )
    .filter((obj, index, self) =>
      index === self.map(el => el.id).lastIndexOf(obj.id)
    );
  }

  function getTax() {
    settings = JSON.parse($("#settings").val());
    let tax_setting = settings.find(setting => setting.name == 'tax_charge').value;
    tax_array = JSON.parse(tax_setting);
    if(tax_setting.length > 1) {
      tax = Object.values(tax_array).reduce(function(total, currentValue){
        return total + parseFloat(currentValue);
      }, 0); 
    } else {
      tax = 0;
    }
  }

  function save_booking() {
    addon_ids = active_addons.map(item => item.id);
    addon_ids = addon_ids.join(',');
    const postData = new FormData();
    postData.append('customer_id', customer);
    postData.append('user_id', "{{Auth::user()->id}}");
    postData.append('vehicle_id', $("#vehicles").val());
    postData.append('branch_id', branch);
    postData.append('reservation_type', reservation);
    postData.append('service_type', service);
    postData.append('addon_id', JSON.stringify(active_addons));
    // postData.append('addon_quantity', $("#addon_quantity").val());
    if($("#service").val() == "C")
      postData.append('driver_id', $("#driver select").val());
    postData.append('pickup', pickup_date);
    postData.append('dropoff', dropoff_date);
    postData.append('duration', diff_days);
    postData.append('pickup_addr', pickup_addr);
    postData.append('dest_addr', dropoff_addr);
    // postData.append('note', note);
    postData.append('travellers', children);
    postData.append('airport_pickup', is_airport);
    postData.append('airport_pickup_details', airport_detail);
    postData.append('airport_date', airport_date);
    postData.append('hours', hours);
    postData.append('final_destination', is_outside);
    postData.append('destination_outside', destination_outside);
    postData.append('tax_charge', vehicle_tax_amount);
    postData.append('tax_total', vehicle_amount + vehicle_tax_amount + addon_amount);
    postData.append('track_time', track_time);
    postData.append('tax_percent', tax)
    postData.append('base_rate', base_rate);
    postData.append('insurance_rate', insurance_rate);
    postData.append('vehicle_amount', vehicle_amount);
    postData.append('status', 0);
    postData.append('payment', 0);

    $.ajax({
      url: "{{url('admin/booking-create')}}",
      type: "POST",
      data: postData,
      processData: false,  // tell jQuery not to process the data
      contentType: false,  // tell jQuery not to set contentType
      success: function (res) {
        if(!res.success) {
          new PNotify({
            title: 'Error',
            text: "@lang('fleet.booking_created_failed')",
            type: 'error'
          });
          return;
        }
        new PNotify({
          title: 'Success',
          text: "@lang('fleet.booking_created_successfully')",
          type: 'success'
        });
        setTimeout(function(){ location.reload(''); }, 1000);
      }
    });
  }
</script>
@endsection