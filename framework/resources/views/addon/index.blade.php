@extends('layouts.app')

@section('extra_css')
<style>
	button {
		white-space: nowrap;
	}
</style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('addon.index') }}">@lang('menu.add_ons')</a></li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
          <div class="card-header with-border">
              <h3 class="card-title">
                @lang('menu.add_ons')
              </h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-responsive">
                <thead>
                  <tr>
                    <th>@lang('fleet.image')</th>
                    <th>@lang('fleet.vendor_type')</th>
                    <th>@lang('menu.add_ons')</th>
                    <th>@lang('fleet.price')(GHS)</th>
                    <th>@lang('description')</th>
                    <th>@lang('action')</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($addon_list as $addon)
                    <tr>
                      <td>
                        <img src="{{ asset('uploads/addons/'.$addon->image) }}" style="width: 100px; height: 100px;">
                      </td>
                      <td>{{ $addon->type }}</td>
                      <td>{{ $addon->name }}</td>
                      <td>{{ $addon->price }}</td>
                      <td>{{ $addon->description }}</td>
                      <td>
                        <a href="{{ route('addon.edit', $addon->id) }}" class="btn btn-sm btn-info">Edit</a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>  
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
@section("script")
<script type="text/javascript">

</script>
@endsection