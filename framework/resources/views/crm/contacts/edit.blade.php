@extends('layouts.app')

@section('extra_css')
<style>
.icon_file_select_form {
    display: flex;
}

.icon_file_select_form>a {
    padding: 8px 12px;
}

#select_service_icon {
    cursor: not-allowed;
}

.big-checkbox {
    transform: scale(1.5);
}

.form-check {
    cursor: pointer;
}

.select2 {
    width: 100% !important;
}
</style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('crm.index') }}">@lang('menu.crm')</a></li>
<li class="breadcrumb-item "><a href="{{ url('admin/crm-corporate-accounts') }}">@lang('fleet.corporate_accounts')</a>
</li>
<li class="breadcrumb-item active">@lang('fleet.edit_contact')</li>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <div class="card card-info">
            <div class="card-header with-border">
                <h3 class="card-title">
                    @lang('fleet.edit_contact')
                </h3>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Account</label>
                        <select id="account_id" class="form-control select2">
                            @foreach($accounts as $account)
                                <option value="{{$account->id}}" @if($contact->account_id == $account->id) selected @endif>{{$account->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('fleet.name')</label>
                        <input type="text" class="form-control" placeholder="@lang('fleet.name')" id="name" value="{{$contact->name}}" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('fleet.email')</label>
                        <input type="email" placeholder="@lang('fleet.email')" id="email" class="form-control" value="{{$contact->email}}" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('fleet.phone')</label>
                        <input type="text" id="phone" class="form-control" placeholder="@lang('fleet.phone')" value="{{$contact->phone}}" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('fleet.job_title')</label>
                        <input type="text" id="job" class="form-control" placeholder="@lang('fleet.job_title')" value="{{$contact->job}}" />
                    </div>
                    <div>
                        <button class="btn btn-success" onclick="edit()">
                            <i class="fa fa-save"></i>
                            Update
                        </button>
                        <a class="btn btn-danger" href="{{url('admin/crm-contacts')}}">
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
<script type="text/javascript">
    $(document).ready(function(){
        $(".select2").select2().css('width', '100%');
    })

    function edit() {
        var account_id = $("#account_id").val();
        var name = $("#name").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var job = $("#job").val();

        if(name == ''){
            new PNotify({
                title: 'Error',
                text: "@lang('fleet.name') @lang('fleet.is_not_empty')",
                type: 'error'
            });
            return;
        }

        if(email == '') {
            new PNotify({
                title: 'Error',
                text: "@lang('fleet.email') @lang('fleet.is_not_empty')",
                type: 'error'
            });
            return;
        }

        if(phone == '') {
            new PNotify({
                title: 'Error',
                text: "@lang('fleet.phone') @lang('fleet.is_not_empty')",
                type: 'error'
            });
            return;
        }

        if(job == '') {
            new PNotify({
                title: 'Error',
                text: "@lang('fleet.job') @lang('fleet.is_not_empty')",
                type: 'error'
            });
            return;
        }

        const formData = new FormData();
        formData.append('id', {{$contact->id}})
        formData.append('account_id', account_id);
        formData.append('name', name);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('job', job);

        $.ajax({
            url: "{{url('admin/crm-contacts/edit')}}",
            type: "POST",
            data: formData,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success: function (res) {
                if(!res.success) {
                    new PNotify({
                        title: 'Error',
                        text: "@lang('fleet.update_failed')",
                        type: 'error'
                    });
                    return;
                }
                new PNotify({
                    title: 'Success',
                    text: "@lang('fleet.updated_successfully')",
                    type: 'success'
                });
                setTimeout(function(){ window.location.reload(''); }, 1000);
            }
      });
    }
</script>
@endsection