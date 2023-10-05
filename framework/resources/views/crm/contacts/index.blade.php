@extends('layouts.app')

@section('extra_css')
<style>
.form-label {
    margin: 0;
}
.card-header > div {
    display: flex;
    width: 100%;
    align-items: center;
    justify-content: space-between;
}
</style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('crm.index') }}">@lang('menu.crm')</a></li>
<li class="breadcrumb-item active">@lang('fleet.contact_management')</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card card-info">
            <div class="card-header with-border">
                <div>
                    <h3 class="card-title">
                        @lang('fleet.contact_management')
                    </h3>
                    <a href="{{url('admin/crm-contacts/create')}}" class="btn btn-sm btn-success">
                        <i class="fa fa-plus"></i>
                        @lang('fleet.add_contact')
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-4">
                    <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
                        <label class="form-label">Account:</label>
                        <select id="select_account" class="select2 form-control">
                            <option value="all" @if('all' == $active_account) selected @endif>All</option>
                            @foreach($accounts as $account)
                                <option value="{{$account->id}}" @if($account->id == $active_account) selected @endif>{{$account->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-responsive">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>No</th>
                                    <th>Account Name</th>
                                    <th>@lang('fleet.name')</th>
                                    <th>@lang('fleet.email')</th>
                                    <th>@lang('fleet.phone')</th>
                                    <th>@lang('fleet.job_title')</th>
                                    <th>@lang('fleet.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contacts as $key => $contact)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$contact->u_name}}</td>
                                        <td>{{$contact->name}}</td>
                                        <td>{{$contact->email}}</td>
                                        <td>{{$contact->phone}}</td>
                                        <td>{{$contact->job}}</td>
                                        <td>
                                            <button class="btn btn-sm btn-success">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
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
</div>
@endsection
@section("script")
<script>
    $(document).ready(function() {
        $(".select2").select2();
        $("#select_account").change(function() {
            window.location.href = "{{url('admin/crm-contacts')}}?account=" + $(this).val();
        })
    })
</script>
@endsection