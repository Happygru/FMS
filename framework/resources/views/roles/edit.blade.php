@extends('layouts.app')
@section("breadcrumb")
<li class="breadcrumb-item">{{ link_to_route('roles.index', __('fleet.roles'))}}</li>
<li class="breadcrumb-item active">@lang('fleet.edit_role')</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-success">
      <div class="card-header">
        <h3 class="card-title">@lang('fleet.edit_role')</h3>
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

        {!! Form::open(['route' => ['roles.update',$data->id],'method'=>'PATCH']) !!}
        {!! Form::hidden('id',$data->id) !!}
        <div class="row">
          <div class="form-group col-md-6">
            {!! Form::label('name', __('fleet.name'), ['class' => 'form-label']) !!}
            {!! Form::text('name', $data->name,['class' => 'form-control','required']) !!}
          </div>
        </div>
        <div class="row">
          {!! Form::label('permission',__('fleet.module_permission').":", ['class' => 'col-xs-5 control-label']) !!}
        </div>
        <div class="row">  
        @foreach($modules as $row)
          <div class="col-md-4">
            <div class="form-group">
              {!! Form::label('permission',$row, ['class' => 'col-xs-5 control-label']) !!}
              <br>
              @if(!in_array($row,["Inquiries","Reports","Settings"]))
                <input type="checkbox" name="{{ $row." list" }}" value="1" class="flat-red form-control" @if($data->hasPermissionTo($row." list")) checked @endif>&nbsp; List &nbsp; &nbsp;&nbsp;&nbsp;
              @endif
              @if(!in_array($row,["Inquiries","Reports","Settings"]))
                <input type="checkbox" name="{{ $row." add" }}" value="1" class="flat-red form-control" @if($data->hasPermissionTo($row." add")) checked @endif>&nbsp; Add &nbsp; &nbsp;&nbsp;&nbsp;
              @endif
              @if(!in_array($row,["Inquiries","Reports","Transactions","ServiceReminders","Settings"]))
                <input type="checkbox" name="{{ $row." edit" }}" value="1" class="flat-red form-control" @if($data->hasPermissionTo($row." edit")) checked @endif>&nbsp; Edit &nbsp; &nbsp; &nbsp;&nbsp;
              @endif
              @if(!in_array($row,["Inquiries","Reports","Settings"]))
                <input type="checkbox" name="{{ $row." delete" }}" value="1" class="flat-red form-control" @if($data->hasPermissionTo($row." delete")) checked @endif>&nbsp; Delete &nbsp; &nbsp;&nbsp;&nbsp;
              @endif
              @if(in_array($row,["Drivers","Customer","Vendors"]))
                <input type="checkbox" name="{{ $row." import" }}" value="1" class="flat-red form-control" @if($data->hasPermissionTo($row." import")) checked @endif>&nbsp; Import Excel &nbsp; &nbsp;&nbsp;&nbsp;
              @endif
              @if(in_array($row,["Inquiries","Reports","Settings"]))
                <input type="checkbox" name="{{ $row." list" }}" value="1" class="flat-red form-control" @if($data->hasPermissionTo($row." list")) checked @endif>&nbsp; All 
              @endif
            </div>
          </div>
        @endforeach 
        </div> 
      </div>
      <div class="card-footer">
        <div class="row">
          <div class="form-group col-md-4">
            {!! Form::submit(__('fleet.update'), ['class' => 'btn btn-success']) !!}
          </div>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">

  //Flat red color scheme for iCheck
  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass   : 'iradio_flat-green'
  })
</script>
@endsection