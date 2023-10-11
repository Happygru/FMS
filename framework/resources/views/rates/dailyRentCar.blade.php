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
  td {
    vertical-align: middle !important;
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
        <a href="javascript:;" class="btn btn-success btn-sm update_rates_btn">@lang('fleet.update')</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
          <table class="table table-responsive" style="width: 100%; table-layout: fixed;">
            <thead class="thead-inverse">
              <tr>
                <th>@lang('fleet.vehicle_category')</th>
                <th>@lang('fleet.1_2_day_rates')</th>
                <th>@lang('fleet.3_6_day_rates')</th>
                <th>@lang('fleet.7_15_day_rates')</th>
                <th>@lang('fleet.16_30_day_rates')</th>
                <th>@lang('fleet.daily_km_allowance')</th>
                <th>@lang('fleet.daily_kilometer_rate')</th>
              </tr>   
            </thead>
            <tbody>
              @foreach($rate_list as $key => $item)
                <tr data-id="{{$item->id}}">
                  <td>{{ $item->name }}</td>
                  <td>
                    <div class="form-group">
                      <label class="form-label table-label">@lang('fleet.chauffeur_driven')</label>
                      <input type="text" class="form-control wdwa_1_2" value="{{ $item->wdwa_1_2 }}">
                    </div>
                    <div class="form-group">
                      <label class="form-label table-label">@lang('fleet.self_driven')</label>
                      <input type="text" class="form-control wdwa_1_2_sd" value="{{ $item->wdwa_1_2_sd }}">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <label class="form-label table-label">@lang('fleet.chauffeur_driven')</label>
                      <input type="text" class="form-control wdwa_3_6" value="{{ $item->wdwa_3_6 }}">
                    </div>
                    <div class="form-group">
                      <label class="form-label table-label">@lang('fleet.self_driven')</label>
                      <input type="text" class="form-control wdwa_3_6_sd" value="{{ $item->wdwa_3_6_sd }}">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <label class="form-label table-label">@lang('fleet.chauffeur_driven')</label>
                      <input type="text" class="form-control wdwa_7_15" value="{{ $item->wdwa_7_15 }}">
                    </div>
                    <div class="form-group">
                      <label class="form-label table-label">@lang('fleet.self_driven')</label>
                      <input type="text" class="form-control wdwa_7_15_sd" value="{{ $item->wdwa_7_15_sd }}">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <label class="form-label table-label">@lang('fleet.chauffeur_driven')</label>
                      <input type="text" class="form-control wdwa_16_30" value="{{ $item->wdwa_16_30 }}">
                    </div>
                    <div class="form-group">
                      <label class="form-label table-label">@lang('fleet.self_driven')</label>
                      <input type="text" class="form-control wdwa_16_30_sd" value="{{ $item->wdwa_16_30_sd }}">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" class="form-control wdwa_dka" value="{{ $item->wdwa_dka }}">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" class="form-control wdwa_dkr" value="{{ $item->wdwa_dkr }}">
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <a href="javascript:;" class="btn btn-success btn-sm update_rates_btn">@lang('fleet.update')</a>
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
    var wdwa_1_2 = [];
    var wdwa_1_2_sd = [];
    var wdwa_3_6 = [];
    var wdwa_3_6_sd = [];
    var wdwa_7_15 = [];
    var wdwa_7_15_sd = [];
    var wdwa_16_30 = [];
    var wdwa_16_30_sd = [];
    var wdwa_dka = [];
    var wdwa_dkr = [];
    var postData = [];
    $("tbody > tr").each(function() {
      id.push($(this).data('id'));
    })
    $(".wdwa_1_2").each(function () {
      wdwa_1_2.push($(this).val());
    });
    $(".wdwa_1_2_sd").each(function () {
      wdwa_1_2_sd.push($(this).val());
    });
    $(".wdwa_3_6").each(function () {
      wdwa_3_6.push($(this).val());
    });
    $(".wdwa_3_6_sd").each(function () {
      wdwa_3_6_sd.push($(this).val());
    });
    $(".wdwa_7_15").each(function () {
      wdwa_7_15.push($(this).val());
    });
    $(".wdwa_7_15_sd").each(function () {
      wdwa_7_15_sd.push($(this).val());
    });
    $(".wdwa_16_30").each(function () {
      wdwa_16_30.push($(this).val());
    });
    $(".wdwa_16_30_sd").each(function () {
      wdwa_16_30_sd.push($(this).val());
    });
    $(".wdwa_dka").each(function () {
      wdwa_dka.push($(this).val());
    });
    $(".wdwa_dkr").each(function () {
      wdwa_dkr.push($(this).val());
    });
    
    if (id.includes('') || wdwa_1_2.includes('') || wdwa_1_2_sd.includes('') || wdwa_3_6.includes('') || wdwa_3_6_sd.includes('') || wdwa_7_15.includes('') || wdwa_7_15_sd.includes('') || wdwa_16_30.includes('') || wdwa_16_30_sd.includes('') || wdwa_dka.includes('') || wdwa_dkr.includes('')) {
      new PNotify({
				title: 'Error!',
				text: "@lang('fleet.all_field_validate')",
				type: 'error'
			});
      return;
    }
    for(var i = 0; i < wdwa_1_2.length; i++) {
      var data = {
        id: id[i],
        wdwa_1_2: wdwa_1_2[i],
        wdwa_1_2_sd: wdwa_1_2_sd[i],
        wdwa_3_6: wdwa_3_6[i],
        wdwa_3_6_sd: wdwa_3_6_sd[i],
        wdwa_7_15: wdwa_7_15[i],
        wdwa_7_15_sd: wdwa_7_15_sd[i],
        wdwa_16_30: wdwa_16_30[i],
        wdwa_16_30_sd: wdwa_16_30_sd[i],
        wdwa_dka: wdwa_dka[i],
        wdwa_dkr: wdwa_dkr[i]
      };
      postData.push(data);
    }
    $.post("{{url('admin/rates-dailyRentCar-update')}}", { data: postData }, function(data) {
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