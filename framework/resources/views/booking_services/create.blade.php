@extends('layouts.app')

@section('extra_css')
<style>
  .icon_file_select_form {
    display: flex;
  }

  .icon_file_select_form > a {
    padding: 8px 12px;
  }

  #select_service_icon {
    cursor: not-allowed;
  }

  .big-checkbox {
    transform: scale(1.5);
  }

  .form-check {
    cursor: pointer;
  }
</style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('booking-services.index') }}">@lang('menu.booking_services')</a></li>
<li class="breadcrumb-item active">@lang('fleet.add_booking_service')</li>
@endsection
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-6">
		<div class="card card-info">
			<div class="card-header with-border">
				<h3 class="card-title">
					@lang('fleet.add_booking_service')
				</h3>
			</div>
			<div class="card-body">
				<div class="col-md-12">
          <div class="form-group">
            <label class="form-label">@lang('fleet.name')</label>
            <input type="text" class="form-control" placeholder="@lang('fleet.enter_service_name')" id="service_name" />
          </div>
          <div class="form-group">
            <label class="form-label">@lang('fleet.service_icon')</label>
            <div class="icon_file_select_form">
              <input type="text" class="form-control" placeholder="@lang('fleet.enter_service_icon')" id="select_service_icon" disabled />
              <a class='btn btn-info btn-sm'>...</a>
            </div>
            <input type="file" style="display: none" accept=".jpg, .png, .bmp, .gif" id="select_file" />
          </div>
          <div class="form-group">
            <label class="form-label">@lang('fleet.description')</label>
            <textarea id="service_description" rows="10" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input big-checkbox" type="checkbox" value="" id="website_checkbox">
              <label class="form-check-label" for="website_checkbox">
                Check me out
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input big-checkbox" type="checkbox" value="" id="backend_checkbox">
              <label class="form-check-label" for="backend_checkbox">
                Check me out
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input big-checkbox" type="checkbox" value="" id="corporate_checkbox">
              <label class="form-check-label" for="corporate_checkbox">
                Check me out
              </label>
            </div>
          </div>
        </div>
			</div>
		</div>
	</div>
</div>
@endsection
@section("script")

@endsection