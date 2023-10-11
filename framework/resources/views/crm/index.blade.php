@extends('layouts.app')

@section('extra_css')
  <style>
    .crm_card {
      width: 160px;
      height: 160px;
      border: 1px solid #ccc;
      border-radius: 10px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      gap: 6px;
      padding: 10px;
    }

    .crm_card .crm_logo {
      font-size: 35px;
    }

    .crm_card a {
      font-size: 16px;
      text-align: center;
    }

    .crm_list {
      display: flex;
      gap: 20px;
      margin: auto;
      margin-top: 100px;
      flex-wrap: wrap;
    }
  </style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('crm.index') }}">@lang('menu.crm')</a></li>
@endsection
@section('content')
  <div class="container crm_list">
    <div class="crm_card">
      <span class="crm_logo icon">📈</span>
      <a href="#">Sales Activity</a>
    </div>
    <div class="crm_card">
      <span class="crm_logo icon">🏢</span>
      <a href="{{url('admin/crm-corporate-accounts')}}">@lang('menu.corporate_accounts')</a>
    </div>
    <div class="crm_card">
      <span class="crm_logo icon">🎯</span>
      <a href="#">Lead Management</a>
    </div>
    <div class="crm_card">
      <span class="crm_logo icon">📞</span>
      <a href="{{url('admin/crm-contacts')}}">@lang('fleet.contact_management')</a>
    </div>
    <div class="crm_card">
      <span class="crm_logo icon">📃</span>
      <a href="{{url('admin/crm-documents')}}">@lang('fleet.document_management')</a>
    </div>
    <div class="crm_card">
      <span class="crm_logo icon">🔍</span>
      <a href="#">Search</a>
    </div>
    <div class="crm_card">
      <span class="crm_logo icon">📊</span>
      <a href="#">Custom Reports</a>
    </div>
  </div>
@endsection
@section("script")

@endsection