@extends('layouts.app')

@section('extra_css')
<style>
	#booking_services_list {
		font-weight: bold;
	}
</style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('booking-services.index') }}">@lang('menu.booking_services')</a></li>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card card-info">
			<div class="card-header with-border">
				<h3 class="card-title">
					@lang('fleet.all_services')
				</h3>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-responsive" id="booking_services_list" style="padding-bottom: 35px; width: 100%">
						<thead class="thead-inverse">
							<tr>
								<th style="width: 60px; text-align: center;">No</th>
								<th style="width: 20%;min-width:100px">@lang('fleet.icon')</th>
								<th>@lang('fleet.name')</th>
								<th style="width: 40%;">@lang('fleet.description')</th>
								<th style="width: 90px;white-space:nowrap;">@lang('fleet.action')</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
						<tfoot>
							<tr>
                <th style="width: 60px; text-align: center;"></th>
                <th style="width: 20%;min-width:100px">@lang('fleet.icon')</th>
                <th>@lang('fleet.name')</th>
                <th style="width: 40%;">@lang('fleet.description')</th>
                <th style="width: 90px;white-space:nowrap;">@lang('fleet.action')</th>
              </tr>
            </tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section("script")
<script type="text/javascript">
	$(document).ready(function() {
		$.get("{{url('admin/booking-services-fetch')}}", function (res) {
			for(let i = 0; i < res.length; i++) {
				$("#booking_services_list tbody").append("<tr><td style='text-align: center'>"+(i+1)+"</td><td><img src='{{asset('uploads/services/')}}/"+res[i].icon+"' style='width: 200px;'></td><td>"+res[i].name+"</td><td>"+res[i].description+"</td><td style='text-align: center'><a class='btn btn-info btn-sm'><i class='fa fa-edit'></i></a> <a class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a></td></tr>");
			}
		})
	})
</script>
@endsection