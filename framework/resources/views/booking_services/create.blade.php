@extends('layouts.app')

@section('extra_css')

@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('booking-services.index') }}">@lang('menu.booking_services')</a></li>
<li class="breadcrumb-item active">@lang('fleet.add_booking_service')</li>
@endsection
@section('content')

@endsection
@section("script")

@endsection