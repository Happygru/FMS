@extends('layouts.app')

@section('extra_css')
<style>
	button {
		white-space: nowrap;
	}
</style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('branches.index') }}">@lang('menu.branches')</a></li>
<li class="breadcrumb-item active">@lang('menu.new_branch')</li>
@endsection
@section('content')
<div class="row">
  <div class="col-md-6 col-sm-12">
    <div class="card card-info">
      <div class="card-header with-border">
        <h3 class="card-title">
            @lang('menu.new_branch')
        </h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label class="form-label">@lang('fleet.name')</label>
              <input type="text" class="form-control" id="name" placeholder="@lang('fleet.name')">
            </div>
            <div class="form-group">
              <label class="form-label">@lang('fleet.code')</label>
              <input type="text" class="form-control" id="code" placeholder="@lang('fleet.code')">
            </div>
            <div class="form-group">
              <label class="form-label">@lang('fleet.rate')</label>
              <input type="number" class="form-control" name="phone" placeholder="@lang('fleet.rate')" id="rate">
            </div>
            <div class="form-group">
              <label class="form-label">@lang('fleet.commission')</label>
              <input type="number" class="form-control" name="phone" placeholder="@lang('fleet.commission')" id="commission">
            </div>
            <div class="form-group">
              <label class="form-label">@lang('fleet.manager')</label>
              <select class="form-control select2" id="manager">
                @foreach($users as $user)
                  <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" id="submit_btn"> <i class="fa fa-paper-plane"></i> Submit</button>
              <a href="{{ route('branches.index')}}" class="btn btn-danger"><i class="fa fa-share"></i> Return</a>
            </div>
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
    $(".select2").select2();
  });

  $("#submit_btn").click(function() {
    var name = $("#name").val();
    var code = $("#code").val();
    var rate = $("#rate").val();
    var commission = $("#commission").val();
    var manager = $("#manager").val();

    if (name == "") {
      new PNotify({
        title: 'Warning',
        text: "@lang('fleet.input_name')",
        type: 'warning'
      });
      return;
    }
    
    if (code == "") {
      new PNotify({
        title: 'Warning',
        text: "@lang('fleet.input_code')",
        type: 'warning'
      });
      return;
    }
    
    if (rate == "" || rate < 0) {
      new PNotify({
        title: 'Warning',
        text: "@lang('fleet.input_rate')",
        type: 'warning'
      });
      return;
    }
    
    if (commission == "" || commission < 0) {
      new PNotify({
        title: 'Warning',
        text: "@lang('fleet.input_commission')",
        type: 'warning'
      });
      return;
    }

    var postData = {
      name, code, rate, commission, manager, deleted: 0
    }

    $.ajax({
      url: "{{ url('admin/branch-create') }}",
      type: "POST",
      data: postData,
      dataType: "json",
      success: function(response) {
        if (response.code == 200) {
          new PNotify({
            title: 'Success!',
            text: "@lang('fleet.create_branch_success')",
            type:'success'
          });
          setTimeout(function() {
            window.location.reload("");
          }, 1000);
        } else {
          new PNotify({
            title: 'Warning',
            text: "@lang('fleet.branch_already_exists')",
            type: 'warning'
          });
        }
      },
      error: function(response) {
        new PNotify({
          title: 'Warning',
          text: "@lang('fleet.request_error')",
          type: 'warning'
        });
      }
    });
  })
</script>
@endsection