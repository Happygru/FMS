<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{Hyvikk::get('app_name')}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
 <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/cdn/bootstrap.min.css')}}" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/css/cdn/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link href="{{ asset('assets/css/cdn/ionicons.min.css')}}" rel="stylesheet">
  <!-- Theme style -->
   <link href="{{ asset('assets/css/AdminLTE.min.css') }}" rel="stylesheet">]

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="{{ asset('assets/css/cdn/fonts.css')}}">
  <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
  <style type="text/css">
    body {
      height: auto;
    }
    @media print{@page {size: landscape}}
  </style>
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
    .customer {
      position: absolute;
      color: white;
      font-size: 22px;
      top: 0;
      right: 0;
      background-color: #ed8b00;
      padding: 30px;
      text-align: center;
      border-top-left-radius: 15px;
      border-bottom-left-radius: 15px;
    }

    .customer > p:last-child {
      font-weight: bold;
    }

    .subinfo {
      text-align: right;
      font-size: 22px;
    }
  </style>
</head>
<body onload="window.print();">
@php($date_format_setting=(Hyvikk::get('date_format'))?Hyvikk::get('date_format'):'d-m-Y')
<div>
  <div id="reviewModal">
    <div class="title" style="flex-direction: column; justify-content: flex-end;padding-top: 20px;position: relative;">
    <img src="{{asset('assets/images/invoice_logo.png')}}" style="height: 100%;position: absolute;top: 0;left: 0;" />
      <p class="subinfo">
        Invoice#{{ $booking->invoice_id }}
      </p>
      <p class="subinfo">
        Date: {{ (new DateTime($booking->created_at))->format('d-m-Y') }}
      </p>
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <p></p>
        <p>booking information</p>
        <p class="subinfo">Yoks Address, Ghana</p>
      </div>
    </div>
    <div class="px py" style="position: relative">
      <div class="customer">
        <p>Customer</p>
        <p>{{ $booking->user_name }}</p>
      </div>
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <h4>Reservation Type</h4>
          <p>{{$booking->reservation_name}}</p>
        </div>
        <div class="col-md-6 col-sm-12">
          <h4>Service Type</h4>
          <p>{{ $booking->service_type == 'C' ? 'Chauffenur-Driven' : 'Self-Driven' }}</p>
        </div>
        <div class="col-md-6 col-sm-12">
          <h4>Start Date/Time</h4>
          <p>{{ $booking->pickup }}</p>
        </div>
        <div class="col-md-6 col-sm-12">
          <h4>End Date/Time</h4>
          <p>{{ $booking->dropoff }}</p>
        </div>
        <div class="col-md-6 col-sm-12">
          <h4>Duration</h4>
          <p>{{ $booking->duration/60/24 }} day(s)</p>
        </div>
        <div class="col-md-6 col-sm-12">
          <h4>Base Rate/Day</h4>
          <p>{{ $booking->base_rate }}</p>
        </div>
        <div class="col-md-6 col-sm-12">
          <h4>Pickup Location</h4>
          <p>{{ $booking->pickup_addr }}</p>
        </div>
        <div class="col-md-6 col-sm-12">
          <h4>Dropoff Location</h4>
          <p>{{ $booking->dest_addr }}</p>
        </div>
        <div class="col-md-6 col-sm-12">
          <h4>Vehicle Category</h4>
          <p>{{ $booking->vehicletype }}</p>
        </div>
        <div class="col-md-6 col-sm-12">
          <h4>Vehicle Daily Insurance Rate</h4>
          <p>{{ $booking->insurance_rate ? $booking->insurance_rate : 0}}</p>
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
                <td>{{ $booking->vehicle_amount }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="cost_bar">
        <span>Total</span>
        <div class="total_cost vehicle_amount">
          GHS {{ $booking->vehicle_amount }}
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
          GHS {{ $booking->tax_charge }}
        </div>
      </div>
    </div>
    <div class="px" style="padding-top: 30px;">
      <div class="cost_bar" style="justify-content: space-between;">
        <span style="font-weight: normal; font-size: 15px;">
          {{ Hyvikk::get('invoice_text') }}
        </span>
        <div style="display: flex; align-items: center; gap: 15px;">
          <span style="white-space: nowrap;">Grant Total</span>
          <div class="total_cost total_amount">
            GHS {{ $booking->tax_total }}
          </div>
        </div>
      </div>
    </div>
    <div style="width: 100%; height: 49px; background: #024273;"></div>
  </div>
</div>
<input type="hidden" value="{{ Hyvikk::get('tax_charge') }}" id="tax_array">
<input type="hidden" value="{{ $booking->addon_id }}" id="addon_array">
<script>

  let tax_array = JSON.parse($("#tax_array").val());
  let addon_array = JSON.parse($("#addon_array").val());
  let vehicle_amount = {{ $booking->vehicle_amount }};
  let insurance_rate = {{ $booking->insurance_rate ? $booking->insurance_rate : 0 }};

  $(document).ready(function() {
    // initial addon
    let str = '';
    let addon_amount = 0;
    addon_array.map(item => 
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
    });
    if(addon_array.length < 1){
      str = `<tr><td colspan="5" style="text-align: center;">No Data</td></tr>`
      addon_amount = 0;
    }
    $("#addon_table").html(str);
    $(".addon_total_cost").text("GH₵" + addon_amount);

    // initial tax
    let tax_keys = Object.keys(tax_array);
    str = "";
    console.log(tax_array);
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
  });
</script>
</body>
</html>