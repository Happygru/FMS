@extends('layouts.app')
@section('extra_css')
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker.min.css')}}">
@endsection
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{ route('customers.index')}}">@lang('fleet.customers')</a></li>
<li class="breadcrumb-item active"> @lang('fleet.edit_customer')</li>
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">
          @lang('fleet.edit_customer')
        </h3>
      </div>

      <div class="card-body">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        {!! Form::open(['route' => ['customers.update',$data->id],'method'=>'PATCH']) !!}
        {!! Form::hidden('id',$data->id) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('first_name', __('fleet.firstname'), ['class' => 'form-label']) !!}
              {!! Form::text('first_name', $data->getMeta('first_name'),['class' => 'form-control','required']) !!}
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('last_name', __('fleet.lastname'), ['class' => 'form-label']) !!}
              {!! Form::text('last_name', $data->getMeta('last_name'),['class' => 'form-control','required']) !!}
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('phone',__('fleet.phone'), ['class' => 'form-label']) !!}
              <div class=" input-group mb-3">
                <div class="input-group-prepend date">
                  <span class="input-group-text"><i class="fa fa-phone"></i></span>
                </div>
                {!! Form::number('phone', $data->getMeta('mobno'),['class' => 'form-control','required']) !!}
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('email', __('fleet.email'), ['class' => 'form-label']) !!}
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                </div>
                {!! Form::email('email', $data->email,['class' => 'form-control','required']) !!}
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('address', __('fleet.address'), ['class' => 'form-label']) !!}
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-home"></i></span>
                </div>
                {!! Form::textarea('address', $data->getMeta('address'),['class' => 'form-control','size'=>'30x2']) !!}
              </div>
            </div>
          </div>
          
          <div class="col-md-3">
            <div class="form-group">
              {!! Form::label('gender', __('fleet.gender') , ['class' => 'form-label']) !!}<br>
              <input type="radio" name="gender" class="flat-red gender" value="1" @if($data->gender == 1) checked @endif
              required> @lang('fleet.male')<br>
              <input type="radio" name="gender" class="flat-red gender" value="0" @if($data->gender == 0) checked @endif
              required> @lang('fleet.female')
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              {!! Form::label('customer_type', __('fleet.customer_type') , ['class' => 'form-label']) !!}<br>
              <input type="radio" name="customer_type" class="flat-red customer_type" value="1" @if($data->customer_type == 1) checked @endif
              required> @lang('fleet.individual')<br>
              <input type="radio" name="customer_type" class="flat-red customer_type" value="0" @if($data->customer_type == 0) checked @endif
              required> @lang('fleet.corporate')
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('birthday', __('fleet.birthday'), ['class' => 'form-label required']) !!}
              <div class="input-group date">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                {!! Form::text('birthday', $data->birthday, ['class' => 'form-control','required']) !!}
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          {!! Form::submit(__('fleet.update'), ['class' => 'btn btn-warning']) !!}
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>

@endsection
@section('script')
<script src="{{ asset('assets/js/moment.js') }}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">
  //Flat red color scheme for iCheck
  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass   : 'iradio_flat-green'
  })

  $('#birthday').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  });
</script>
@endsection