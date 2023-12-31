@extends('layouts.app')

@php($date_format_setting=(Hyvikk::get('date_format'))?Hyvikk::get('date_format'):'d-m-Y')
@section('extra_css')
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker.min.css')}}">
<style type="text/css">
  .checkbox,
  #chk_all {
    width: 20px;
    height: 20px;
  }
</style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item active">@lang('menu.bookings')</li>
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-info">
      <div class="card-header with-border">
        <h3 class="card-title"> @lang('fleet.manage_bookings') &nbsp;
          @can('Bookings add')<a href="{{route('bookings.create')}}" class="btn btn-success"
            title="@lang('fleet.new_booking')"><i class="fa fa-plus"></i></a>@endcan
        </h3>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-responsive display" id="ajax_data_table" style="padding-bottom: 35px; width: 100%">
            <thead class="thead-inverse">
              <tr>
                <th>
                  <input type="checkbox" id="chk_all">
                </th>
                <th style="width: 10% !important">@lang('fleet.customer')</th>
                <th style="width: 10% !important">@lang('fleet.vehicle')</th>
                <th style="width: 10% !important">@lang('fleet.pickup_addr')</th>
                <th style="width: 10% !important">@lang('fleet.dropoff_addr')</th>
                <th style="width: 10% !important">@lang('fleet.pickup')</th>
                <th style="width: 10% !important">@lang('fleet.dropoff')</th>
                <th style="width: 10% !important">@lang('fleet.passengers')</th>
                <th style="width: 10% !important">@lang('fleet.payment_status')</th>
                <th>@lang('fleet.booking_status')</th>
                <th style="width: 10% !important">@lang('fleet.amount')</th>
                <th>From</th>
                <th style="width: 10% !important">@lang('fleet.action')</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
              <tr>
                <th>
                  @can('Bookings delete')<button class="btn btn-danger" id="bulk_delete" data-toggle="modal"
                    data-target="#bulkModal" disabled title="@lang('fleet.delete')"><i
                      class="fa fa-trash"></i></button>@endcan
                </th>
                <th>@lang('fleet.customer')</th>
                <th>@lang('fleet.vehicle')</th>
                <th>@lang('fleet.pickup_addr')</th>
                <th>@lang('fleet.dropoff_addr')</th>
                <th>@lang('fleet.pickup')</th>
                <th>@lang('fleet.dropoff')</th>
                <th>@lang('fleet.passengers')</th>
                <th>@lang('fleet.payment_status')</th>
                <th>@lang('fleet.booking_status')</th>
                <th>@lang('fleet.amount')</th>
                <th>From</th>
                <th>@lang('fleet.action')</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- cancel booking Modal -->
<div id="cancelBooking" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">@lang('fleet.cancel_booking')</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>@lang('fleet.confirm_cancel')</p>
        {!! Form::open(['url'=>url('admin/cancel-booking'),'id'=>'cancel_booking']) !!}
        <div class="form-group">
          {!! Form::hidden('cancel_id',null,['id'=>'cancel_id']) !!}
          {!! Form::label('reason',__('fleet.addReason'),['class'=>"form-label"]) !!}
          <select name="reason" class="form-control">
            @foreach($reasons as $reason)
              <option value="{{$reason->reason}}">{{$reason->reason}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">@lang('fleet.submit')</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('fleet.close')</button>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- cancel booking Modal -->

<!-- complete journey Modal -->
<div id="journeyModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">@lang('fleet.complete')</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>@lang('fleet.confirm_journey')</p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-success" href="" id="journey_btn">@lang('fleet.submit')</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('fleet.close')</button>
      </div>
    </div>
  </div>
</div>
<!-- complete journey Modal -->

<!-- bulk delete Modal -->
<div id="bulkModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">@lang('fleet.delete')</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        {!! Form::open(['url'=>'admin/delete-bookings','method'=>'POST','id'=>'form_delete']) !!}
        <div id="bulk_hidden"></div>
        <p>@lang('fleet.confirm_bulk_delete')</p>
      </div>
      <div class="modal-footer">
        <button id="bulk_action" class="btn btn-danger" type="submit" data-submit="">@lang('fleet.delete')</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('fleet.close')</button>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- bulk delete Modal -->

<!-- single delete Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">@lang('fleet.delete')</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>@lang('fleet.confirm_delete')</p>
      </div>
      <div class="modal-footer">
        <button id="del_btn" class="btn btn-danger" type="button" data-submit="">@lang('fleet.delete')</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('fleet.close')</button>
      </div>
    </div>
  </div>
</div>
<!-- single delete Modal -->


<!-- generate invoic Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="card card-info">
        <div class="modal-header">
          <h3 class="modal-title">@lang('fleet.add_payment')</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
        </div>

        <div class="fleet card-body">
          {!! Form::open(['route' => 'bookings.complete','method'=>'post']) !!}
          <input type="hidden" name="status" id="status" value="1" />
          <input type="hidden" name="booking_id" id="bookingId" value="" />
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.incomeType')</label>
                <select id="income_type" name="income_type" class="form-control vehicles" required>
                  <option value="">@lang('fleet.incomeType')</option>
                  @foreach($types as $type)
                  <option value="{{ $type->id }}">{{$type->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <!-- <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.daytype')</label>
                <select id="day" name="day" class="form-control vehicles" required>
                  <option value="1" selected>Weekdays</option>
                  <option value="2">Weekend</option>
                  <option value="3">Night</option>
                </select>
              </div>
            </div> -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.trip_mileage') ({{Hyvikk::get('dis_format')}})</label>
                {!! Form::number('mileage',null,['class'=>'form-control sum', 'disabled','min'=>1,'id'=>'mileage']) !!}
              </div>
            </div>
          </div>
          <!-- <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.waitingtime')</label>
                {!! Form::number('waiting_time',0,['class'=>'form-control sum','min'=>0,'id'=>'waiting_time']) !!}
              </div>
            </div>
          </div> -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.total_tax') (%) </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text fa fa-percent"></span>
                  </div>
                  {!! Form::number('total_tax_charge',0,['class'=>'form-control
                  sum','readonly','id'=>'total_tax_charge','min'=>0,'step'=>'0.01']) !!}
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.total') @lang('fleet.tax_charge')</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">{{ Hyvikk::get('currency') }}</span>
                  </div>
                  {!! Form::number('total_tax_charge_rs',0,['class'=>'form-control
                  sum','readonly','id'=>'total_tax_charge_rs','min'=>0,'step'=>'0.01']) !!}
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.amount') </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">{{Hyvikk::get('currency')}}</span>
                  </div>
                  {!! Form::number('total',null,['class'=>'form-control','id'=>'total','required', 'readonly', 'min'=>0,
                  'step'=>'0.01']) !!}
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.total') @lang('fleet.amount') </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">{{Hyvikk::get('currency')}}</span>
                  </div>
                  {!! Form::number('tax_total',null,['class'=>'form-control','id'=>'tax_total','readonly','min'=>0,
                  'step'=>'0.01']) !!}
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">@lang('fleet.date')</label>
                <div class='input-group'>
                  <div class="input-group-prepend">
                    <span class="input-group-text"> <span class="fa fa-calendar"></span></span>
                  </div>
                  {!! Form::text('date',date('Y-m-d'),['class'=>'form-control','id'=>'date']) !!}
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              {!! Form::submit(__('fleet.invoice'), ['class' => 'btn btn-info']) !!}
            </div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
</div>
<!-- generate invoice modal -->

<div id="makePaymentModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">@lang('fleet.transactions')</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>@lang('fleet.confirm_payment')</p>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" onclick="payWithPaystack()">@lang('fleet.submit')</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('fleet.close')</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section("script")

<script src="{{ asset('assets/js/moment.js') }}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script type="text/javascript">
  @if(Session::get('msg'))
    new PNotify({
        title: 'Success!',
        text: '{{ Session::get('msg') }}',
        type: 'success'
      });
  @endif

  $(document).ready(function() {
    $('#date').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    });
  });
</script>
<script type="text/javascript">
  $(document).on("click", ".open-AddBookDialog", function () {
    var booking_id = $(this).data('booking-id');
    var tax = $(this).data('tax-percent');
    var tax_charge = $(this).data('tax-charge');
    var tax_total = $(this).data('tax-total');
    var distance = $(this).data('distance');
    var amount = 0, email = '';
    var redirect_url = '';

    $(".fleet #bookingId").val(booking_id);
    $('#total_tax_charge').val(tax);
    $('#total_tax_charge_rs').val(tax_charge);
    $('#total').val(tax_total);
    $("#tax_total").val(tax_total + tax_charge);
    $('#mileage').val(distance);
  });

  $(document).on("click", ".make_payment", function() {
    amount = $(this).data('price');
    email = $(this).data('email');
    redirect_url = $(this).data('redirect');
  })

  function payWithPaystack(){
    let handler = PaystackPop.setup({
      key: 'pk_test_a70c20fc7e2c5f4cb8cba81dca71522d6edcd422', // Replace with your public key
      email: email,
      amount: parseInt(amount * 100),
      ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      // label: "Optional string that replaces customer email"
      currency: "GHS",
      onClose: function(){
        alert('Window closed.');
      },
      callback: function(response){
        if (response.status == 'success') {
          alert('Payment successful. Reference: ' + response.reference);
          location.href = redirect_url;
        } else {
          alert('Payment failed. Error: ' + response.message);
        }
      }
    });
    handler.openIframe();
  }

  $("#del_btn").on("click",function(){
    var id=$(this).data("submit");
    $("#book_"+id).submit();
  });

  $('#myModal').on('show.bs.modal', function(e) {
    var id = e.relatedTarget.dataset.id;
    $("#del_btn").attr("data-submit",id);
  });

  $('#journeyModal').on('show.bs.modal', function(e) {
    var id = e.relatedTarget.dataset.id;
    $("#journey_btn").attr("href","{{ url('admin/bookings/complete/') }}/"+id);
  });

    $('#cancelBooking').on('show.bs.modal', function(e) {
    var id = e.relatedTarget.dataset.id;
    $("#cancel_id").val(id);
  });
</script>

<!-- testing total-->
<script type="text/javascript" language="javascript">
  $(document).on('click','input[type="checkbox"]',function(){
    if(this.checked){
      $('#bulk_delete').prop('disabled',false);

    }else { 
      if($("input[name='ids[]']:checked").length == 0){
        $('#bulk_delete').prop('disabled',true);
      } 
    } 
  });

  $(function(){
    
    var table = $('#ajax_data_table').DataTable({
      dom: 'Bfrtip',
      buttons: [
          {
        extend: 'print',
        text: '<i class="fa fa-print"></i> {{__("fleet.print")}}',

        exportOptions: {
           columns: ([1,2,3,4,5,6,7,8,9,10]),
        },
        customize: function ( win ) {
                $(win.document.body)
                    .css( 'font-size', '10pt' )
                    .prepend(
                        '<h3>{{__("fleet.bookings")}}</h3>'
                    );
                $(win.document.body).find( 'table' )
                    .addClass( 'table-bordered' );
                // $(win.document.body).find( 'td' ).css( 'font-size', '10pt' );

            }
          }
    ],
          "language": {
              "url": '{{ asset("assets/datatables/")."/".__("fleet.datatable_lang") }}',
          },
          processing: true,
          serverSide: true,
          ajax: {
            url: "{{ url('admin/bookings-fetch') }}",
            type: 'POST',
            data:{}
          },
          columns: [
            {data: 'check',   name: 'check', searchable:false, orderable:false},
            {data: 'customer',   name: 'customer.name'},
            {data: 'vehicle', name: 'vehicle'},
            {data: 'pickup_addr',    name: 'pickup_addr'},
            {data: 'dest_addr',    name: 'dest_addr'},
            {name: 'pickup',data: {_: 'pickup.display',sort: 'pickup.timestamp'}},
            {name: 'dropoff',data: {_: 'dropoff.display',sort: 'dropoff.timestamp'}},
            {data: 'travellers',  name: 'travellers'},
            {data: 'payment',  name: 'payment'},
            {data: 'ride_status',  name: 'ride_status'},
            {data: 'tax_total',  name: 'tax_total'},
            {data: 'source', name: 'source'},
            {data: 'action',  name: 'action', searchable:false, orderable:false}
        ],
        order: [[1, 'desc']],
        "initComplete": function() {
              table.columns().every(function () {
                var that = this;
                $('input', this.footer()).on('keyup change', function () {
                  // console.log($(this).parent().index());
                    that.search(this.value).draw();
                });
              });
            }
    });
  });

  $('#bulk_delete').on('click',function(){
    // console.log($( "input[name='ids[]']:checked" ).length);
    if($( "input[name='ids[]']:checked" ).length == 0){
      $('#bulk_delete').prop('type','button');
        new PNotify({
            title: 'Failed!',
            text: "@lang('fleet.delete_error')",
            type: 'error'
          });
        $('#bulk_delete').attr('disabled',true);
    }
    if($("input[name='ids[]']:checked").length > 0){
      // var favorite = [];
      $.each($("input[name='ids[]']:checked"), function(){
          // favorite.push($(this).val());
          $("#bulk_hidden").append('<input type=hidden name=ids[] value='+$(this).val()+'>');
      });
      // console.log(favorite);
    }
  });


  $('#chk_all').on('click',function(){
    if(this.checked){
      $('.checkbox').each(function(){
        $('.checkbox').prop("checked",true);
      });
    }else{
      $('.checkbox').each(function(){
        $('.checkbox').prop("checked",false);
      });
      $('#bulk_delete').prop('disabled',true);
    }
  });

  // Checkbox checked
  function checkcheckbox(){
    // Total checkboxes
    var length = $('.checkbox').length;
    // Total checked checkboxes
    var totalchecked = 0;
    $('.checkbox').each(function(){
        if($(this).is(':checked')){
            totalchecked+=1;
        }
    });
    // console.log(length+" "+totalchecked);
    // Checked unchecked checkbox
    if(totalchecked == length){
        $("#chk_all").prop('checked', true);
    }else{
        $('#chk_all').prop('checked', false);
    }
  }
</script>
@endsection