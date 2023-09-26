@extends('layouts.app')
@section("breadcrumb")
<li class="breadcrumb-item">@lang('menu.settings')</li>
<li class="breadcrumb-item active">@lang('menu.fare_settings')</li>
@endsection
@section('extra_css')
<style type="text/css">
.custom .nav-link.active {
    background-color: #21bc6c !important;
}
.rate_type_list {
  margin-top: 20px;
}
.table-label {
  font-size: 15px;
  margin: 0;
}
.form-group {
  margin-bottom: 0px;
}
#hourly_content tr > th {
  width: 40%;
}

#daily_content tr > th {
  width: 16%;
}

</style>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card card-success">
			<div class="card-header card_action">
				<h3 class="card-title">@lang('menu.fare_settings')
				</h3>
			</div>
			<div class="card-body">
				<div>
					<ul class="nav nav-pills custom vehicle_type_list">
					@foreach($types as $type)
						<li class="nav-item"><a href="#{{strtolower(str_replace(' ','',$type))}}" data-toggle="tab"  onclick="onChangeType({{ $type->id }})" class="nav-link text-uppercase @if(reset($types) == $type) active @endif"> {{$type->vehicletype}} <i class="fa"></i></a></li>
					@endforeach
					</ul>
					<ul class="nav nav-pills rate_type_list">
						<li class="nav-item">
							<a href="#hourly_content" data-toggle="tab" class="nav-link text-uppercase active btn-sm"> Hourly rate <i class="fa"></i></a>
						</li>
            <li class="nav-item">
							<a href="#daily_content" data-toggle="tab" class="nav-link text-uppercase btn-sm"> Daily rate <i class="fa"></i></a>
						</li>
            <li class="nav-item">
              <a href="#insurance_content" data-toggle="tab" class="nav-link text-uppercase btn-sm">Insurance rate <i class="fa"></i></a>
            </li>
					</ul>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="tab-content">
              <div class="tab-pane active" id="hourly_content">
                <div class="table-responsive">
                  <table class="table table-responsive" style="width: 100%; table-layout: fixed;">
                    <thead class="thead-inverse">
                      <tr>
                        <th>@lang('fleet.chauffeur_driven_rate_per_hour')</th>
                        <th>@lang('fleet.self_drive_rate_per_hour')</th>
                        <th>@lang('fleet.driver_allowance')</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="form-group">
                            <label for="" class="form-label table-label">@lang('fleet.hourly_rate')</label>
                            <input type="number" class="form-control" id="hourly">
                          </div>
                          <div class="form-group">
                            <label for="" class="form-label table-label">2 @lang('fleet.hour_rate')</label>
                            <input type="number" class="form-control" id="hourly_2">
                          </div>
                          <div class="form-group">
                            <label for="" class="form-label table-label">3 @lang('fleet.hour_rate')</label>
                            <input type="number" class="form-control" id="hourly_3">
                          </div>
                          <div class="form-group">
                            <label for="" class="form-label table-label">4 @lang('fleet.hour_rate')</label>
                            <input type="number" class="form-control" id="hourly_4">
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <label for="" class="form-label table-label">@lang('fleet.hourly_rate')</label>
                            <input type="number" class="form-control" id="hourly_sd">
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <label for="" class="form-label table-label">@lang('fleet.hourly_rate')</label>
                            <input type="number" class="form-control" id="hourly_da">
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane" id="daily_content">
                <div class="table-responsive">
                  <table class="table table-responsive" style="width: 100%; table-layout: fixed;">
                    <thead class="thead-inverse">
                      <tr>
                        <th>@lang('fleet.1_2_day_rates')</th>
                        <th>@lang('fleet.3_6_day_rates')</th>
                        <th>@lang('fleet.7_15_day_rates')</th>
                        <th>@lang('fleet.16_30_day_rates')</th>
                        <th>@lang('fleet.daily_km_allowance')</th>
                        <th>@lang('fleet.daily_kilometer_rate')</th>
                      </tr>   
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="form-group">
                            <label class="form-label table-label">@lang('fleet.chauffeur_driven')</label>
                            <input type="number" class="form-control" id="wdwa_1_2">
                          </div>
                          <div class="form-group">
                            <label class="form-label table-label">@lang('fleet.self_driven')</label>
                            <input type="number" class="form-control" id="wdwa_1_2_sd">
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <label class="form-label table-label">@lang('fleet.chauffeur_driven')</label>
                            <input type="number" class="form-control" id="wdwa_3_6">
                          </div>
                          <div class="form-group">
                            <label class="form-label table-label">@lang('fleet.self_driven')</label>
                            <input type="number" class="form-control" id="wdwa_3_6_sd">
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <label class="form-label table-label">@lang('fleet.chauffeur_driven')</label>
                            <input type="number" class="form-control" id="wdwa_7_15">
                          </div>
                          <div class="form-group">
                            <label class="form-label table-label">@lang('fleet.self_driven')</label>
                            <input type="number" class="form-control" id="wdwa_7_15_sd">
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <label class="form-label table-label">@lang('fleet.chauffeur_driven')</label>
                            <input type="number" class="form-control" id="wdwa_16_30">
                          </div>
                          <div class="form-group">
                            <label class="form-label table-label">@lang('fleet.self_driven')</label>
                            <input type="number" class="form-control" id="wdwa_16_30_sd">
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <label class="form-label table-label">&nbsp;</label>
                            <input type="number" class="form-control" id="wdwa_dka">
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <label class="form-label table-label">&nbsp;</label>
                            <input type="number" class="form-control" id="wdwa_dkr">
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane" id="insurance_content">
                <div class="table-responsive">
                  <table class="table table-responsive">
                    <thead class="thead-inverse">
                      <tr>
                        <th>@lang('fleet.1_2_day_rates')</th>
                        <th>@lang('fleet.3_6_day_rates')</th>
                        <th>@lang('fleet.7_15_day_rates')</th>
                        <th>@lang('fleet.16_30_day_rates')</th>
                      </tr>   
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="form-group">
                            <input type="text" class="form-control" id="ins_1_2">
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <input type="text" class="form-control" id="ins_3_6">
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <input type="text" class="form-control" id="ins_7_15">
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <input type="text" class="form-control" id="ins_16_30">
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <a href="javascript:;" class="btn btn-success btn-sm update_btn" onclick="update()">@lang('fleet.update')</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  var active_id = {{$types[0]->id}};
	$(document).ready(function() {
    $.post("{{url('/admin/fare-fetch')}}", { id: active_id }, function(data) {
      setInitialize(data);
    })
	});

  function onChangeType(id) {
    if(active_id == id)
      return;
    active_id = id;
    $.post("{{url('/admin/fare-fetch')}}", { id }, function(data) {
      setInitialize(data);
    })
  }

  function setInitialize(data) {
    var fare_list = data.data;
    var field_list = Object.keys(fare_list);
    for(var i = 0; i < field_list.length; i++) {
      try {
        $("#" + field_list[i]).val(fare_list[field_list[i]]);
      } catch (err){ console.log("This element is not exist") };
    }
  }

  function update() {
    let fleetData = {
      id: active_id,
      hourly: $('#hourly').val() || 0,
      hourly_2: $('#hourly_2').val() || 0,
      hourly_3: $('#hourly_3').val() || 0,
      hourly_4: $('#hourly_4').val() || 0,
      hourly_sd: $('#hourly_sd').val() || 0,
      hourly_da: $('#hourly_da').val() || 0,
      wdwa_1_2: $('#wdwa_1_2').val() || 0,
      wdwa_1_2_sd: $('#wdwa_1_2_sd').val() || 0,
      wdwa_3_6: $('#wdwa_3_6').val() || 0,
      wdwa_3_6_sd: $('#wdwa_3_6_sd').val() || 0,
      wdwa_7_15: $('#wdwa_7_15').val() || 0,
      wdwa_7_15_sd: $('#wdwa_7_15_sd').val() || 0,
      wdwa_16_30: $('#wdwa_16_30').val() || 0,
      wdwa_16_30_sd: $('#wdwa_16_30_sd').val() || 0,
      wdwa_dka: $('#wdwa_dka').val() || 0,
      wdwa_dkr: $('#wdwa_dkr').val() || 0,
      ins_1_2: $('#ins_1_2').val() || 0,
      ins_3_6: $('#ins_3_6').val() || 0,
      ins_7_15: $('#ins_7_15').val() || 0,
      ins_16_30: $('#ins_16_30').val() || 0,
    };

    $.post("{{url('/admin/fare-update')}}", fleetData, function (data) {
      if(data.success) {
        new PNotify({
          title: 'Success!',
          text: "@lang('fleet.updated_success')",
          type: 'success'
        });
      } else {
        new PNotify({
          title: 'Error!',
          text: "@lang('fleet.request_error')",
          type: 'error'
        });
      }
    })
  }
</script>
@endsection