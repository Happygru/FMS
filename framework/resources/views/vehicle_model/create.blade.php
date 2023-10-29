@extends('layouts.app')

@section('extra_css')
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ url('admin/vehicle-model') }}">@lang('fleet.manage_vehicle_model')</a></li>
<li class="breadcrumb-item active">@lang('fleet.add_vehicle_model')</li>
@endsection
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-6">
		<div class="card card-info">
			<div class="card-header with-border">
				<h3 class="card-title">
					@lang('fleet.add_vehicle_model')
				</h3>
			</div>
			<div class="card-body">
				<div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">@lang('fleet.name')</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" onclick="save()">
                            <i class="fa fa-save"></i>
                            @lang('fleet.save')
                        </button>
                        <a class="btn btn-danger" href="{{ url('admin/vehicle-model') }}">
                            <i class="fa fa-share"></i>
                            Return
                        </a>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection
@section("script")
<script>
    function save() {
        var name = $("#name").val();
        if(name == '') {
            new PNotify({
                title: 'Warning',
                text: "@lang('fleet.name')",
                type: 'warning'
            });
            return;
        }

        $.post("{{url('admin/vehicle-model/store')}}", { name: name }, function (res) {
            new PNotify({
                title: 'Success!',
                text: "@lang('fleet.created_successfully')",
                type: 'success'
            });
            setTimeout(function(){ window.location.reload() }, 1000);
        })
    }
</script>
@endsection