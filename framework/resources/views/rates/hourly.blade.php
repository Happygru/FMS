@extends('layouts.app')

@section('extra_css')
<style>
  .table-label {
    font-size: 15px;
    margin: 0;
  }
  .form-group {
    margin-bottom: 0px;
  }
  tr > th {
    width: 25%;
  }
</style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('rates.hourly') }}">@lang('menu.rates')</a></li>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card card-info">
			<div class="card-header with-border" style="display: flex; align-items: center; gap: 10px;">
				<h3 class="card-title">
					@lang('fleet.edit_hourly_rate')
				</h3>
        <a href="javascript:;" class="btn btn-success btn-sm update_rates_btn">Update Rates</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
          <table class="table table-responsive" style="width: 100%; table-layout: fixed;">
            <thead class="thead-inverse">
              <tr>
                <th>@lang('fleet.vehicle_category')</th>
                <th>@lang('fleet.chauffeur_driven_rate_per_hour')</th>
                <th>@lang('fleet.self_drive_rate_per_hour')</th>
                <th>@lang('fleet.driver_allowance')</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rate_list as $rate_item)
                <tr data-id="{{$rate_item->id}}">
                  <td>{{ $rate_item->name }}</td>
                  <td>
                    <div class="form-group">
                      <label for="" class="form-label table-label">@lang('fleet.hourly_rate')</label>
                      <input type="text" class="form-control hourly" value="{{ $rate_item->hourly }}">
                    </div>
                    <div class="form-group">
                      <label for="" class="form-label table-label">2 @lang('fleet.hour_rate')</label>
                      <input type="text" class="form-control hourly_2" value="{{ $rate_item->hourly_2 }}">
                    </div>
                    <div class="form-group">
                      <label for="" class="form-label table-label">3 @lang('fleet.hour_rate')</label>
                      <input type="text" class="form-control hourly_3" value="{{ $rate_item->hourly_3 }}">
                    </div>
                    <div class="form-group">
                      <label for="" class="form-label table-label">4 @lang('fleet.hour_rate')</label>
                      <input type="text" class="form-control hourly_4" value="{{ $rate_item->hourly_4 }}">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <label for="" class="form-label table-label">Hourly Rate</label>
                      <input type="text" class="form-control hourly_sd" value="{{ $rate_item->hourly_sd }}">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <label for="" class="form-label table-label">Hourly Rate</label>
                      <input type="text" class="form-control hourly_da" value="{{ $rate_item->hourly_da }}">
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <a href="javascript:;" class="btn btn-success btn-sm update_rates_btn">Update Rates</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section("script")
<script type="text/javascript">
  $(".update_rates_btn").click(function () {
    var id = [];
    var hourly = [];
    var hourly_2 = [];
    var hourly_3 = [];
    var hourly_4 = [];
    var hourly_sd = [];
    var hourly_da = [];
    var postData = [];
    $("tbody > tr").each(function() {
      id.push($(this).data('id'));
    })
    $(".hourly").each(function () {
      hourly.push($(this).val());
    });
    $(".hourly_2").each(function () {
      hourly_2.push($(this).val());
    });
    $(".hourly_3").each(function () {
      hourly_3.push($(this).val());
    });
    $(".hourly_4").each(function () {
      hourly_4.push($(this).val());
    });
    $(".hourly_sd").each(function () {
      hourly_sd.push($(this).val());
    });
    $(".hourly_da").each(function () {
      hourly_da.push($(this).val());
    });
    if (id.includes('') || hourly.includes('') || hourly_2.includes('') || hourly_3.includes('') || hourly_4.includes('') || hourly_sd.includes('')) {
      new PNotify({
				title: 'Error!',
				text: "@lang('fleet.all_field_validate')",
				type: 'error'
			});
      return;
    }
    for(var i = 0; i < hourly.length; i++) {
      var data = {
        id: id[i],
        hourly: hourly[i],
        hourly_2: hourly_2[i],
        hourly_3: hourly_3[i],
        hourly_4: hourly_4[i],
        hourly_sd: hourly_sd[i],
        hourly_da: hourly_da[i],
      };
      postData.push(data);
    }
    $.post("{{url('admin/rates-hourly-update')}}", { data: postData }, function(data) {
      if(data.success){
        new PNotify({
          title: 'Success!',
          text: "@lang('fleet.updated_success')",
          type: 'success'
        });
      }
    })
  })
</script>
@endsection