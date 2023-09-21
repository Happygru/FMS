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
              </tr>   
            </thead>
            <tbody>
              @foreach($rate_list as $key => $item)
                <tr data-id="{{$item->id}}">
                  <td>{{ $item->name }}</td>
                  <td>
                    <div class="form-group">
                      <input type="text" class="form-control ins_1_2" value="{{ $item->ins_1_2 }}">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" class="form-control ins_3_6" value="{{ $item->ins_3_6 }}">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" class="form-control ins_7_15" value="{{ $item->ins_7_15 }}">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" class="form-control ins_16_30" value="{{ $item->ins_16_30 }}">
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
    var postData = [];
    var id = [];
    var ins_1_2 = [];
    var ins_3_6 = [];
    var ins_7_15 = [];
    var ins_16_30 = [];

    $("tbody > tr").each(function () {
      id.push($(this).data('id'));
      ins_1_2.push($(this).find('.ins_1_2').val());
      ins_3_6.push($(this).find('.ins_3_6').val());
      ins_7_15.push($(this).find('.ins_7_15').val());
      ins_16_30.push($(this).find('.ins_16_30').val());
    })
    
    if (id.includes('') || ins_1_2.includes('') || ins_3_6.includes('') || ins_16_30.includes('') || ins_7_15.includes('')) {
      new PNotify({
				title: 'Error!',
				text: "@lang('fleet.all_field_validate')",
				type: 'error'
			});
      return;
    }
    for(var i = 0; i < ins_1_2.length; i++) {
      var data = {
        id: id[i],
        ins_1_2: ins_1_2[i],
        ins_3_6: ins_3_6[i],
        ins_7_15: ins_7_15[i],
        ins_16_30: ins_16_30[i]
      };
      postData.push(data);
    }
    $.post("{{url('admin/rates-insuracne-update')}}", { data: postData }, function(data) {
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