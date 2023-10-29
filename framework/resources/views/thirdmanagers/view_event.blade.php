<style>
	#thirdparty_owner tr > td:first-child {
		font-weight: bold;
	}
</style>

<div role="tabpanel">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a href="#info-tab" data-toggle="tab" class="nav-link custom_padding active"> @lang('fleet.general_info') <i class="fa"></i></a>
        </li>
        <li class="nav-item">
            <a href="#vehicle-tab" data-toggle="tab" class="nav-link custom_padding">@lang('fleet.vehicles')@lang('fleet.third')</a>
        </li>
        <li class="nav-item">
            <a href="#earning-tab" data-toggle="tab" class="nav-link custom_padding">@lang('fleet.earning_amount')</a>
        </li>
    </ul>

	<div class="tab-content">
		<div class="tab-pane active" id="info-tab">
			<table class="table table-striped">
                <tr>
                    <th>@lang('fleet.name'):</th>
                    <td>{{ $user_info->name }}</td>
                </tr>
                <tr>
                    <th>@lang('fleet.email'):</th>
                    <td>{{ $user_info->email }}</td>
                </tr>
                <tr>
                    <th>@lang('fleet.gender'):</th>
                    <td>
                        @if($user_info->gender == 'M')
                            Male
                        @else
                            Female
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('fleet.phone'):</th>
                    <td>
                        {{ $user_info->phone }}
                    </td>
                </tr>
                <tr>
                    <th>@lang('fleet.address'):</th>
                    <td>
                        {{ $user_info->addr }}
                    </td>
                </tr>
                <tr>
                    <th>@lang('fleet.location'):</th>
                    <td>
                        {{ $user_info->location }}
                    </td>
                </tr>
			</table>
		</div>
        <div class="tab-pane" id="vehicle-tab">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>@lang('fleet.make')</th>
                        <th>@lang('fleet.model')</th>
                        <th>@lang('fleet.type')</th>
                        <th>@lang('fleet.year')</th>
                        <th>@lang('fleet.engine')</th>
                        <th>@lang('reg_exp_date')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->make_name }}</td>
                            <td>{{ $vehicle->model_name }}</td>
                            <td>{{ $vehicle->vehicletype }}</td>
                            <td>{{ $vehicle->year }}</td>
                            <td>{{ $vehicle->engine_type }}</td>
                            <td>{{ $vehicle->reg_exp_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane" id="earning-tab">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>@lang('fleet.make')</th>
                        <th>@lang('fleet.model')</th>
                        <th>@lang('fleet.licensePlate')</th>
                        <th>@lang('fleet.amount')</th>
                        <th>@lang('fleet.earning_amount')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($incomes as $income)
                        <tr>
                            <td>{{ $income->make_name }}</td>
                            <td>{{ $income->model_name }}</td>
                            <td>{{ $income->license_plate }}</td>
                            <td>{{ $income->amount }}</td>
                            <td>{{ $income->thirdparty_amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
	</div>
</div>