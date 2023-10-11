@extends('layouts.app')

@section('extra_css')

@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('addon.index') }}">@lang('menu.add_ons')</a></li>
<li class="breadcrumb-item active">@lang('fleet.edit_add_on')</li>
@endsection
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-6">
		<div class="card card-info">
			<div class="card-header with-border">
				<h3 class="card-title">
					@lang('fleet.edit_add_on')
				</h3>
			</div>
			<div class="card-body">
				<div class="col-md-12">
          <div class="form-group">
            <label class="form-label">@lang('fleet.description')</label>
            <input type="text" class="form-control" placeholder="@lang('fleet.description')" id="description" value="{{$addon->description}}" />
          </div>
          <div class="form-group">
            <label class="form-label">@lang('fleet.amount')</label>
            <input type="number" class="form-control" placeholder="@lang('fleet.amount')" id="amount" value="{{$addon->amount}}" />
          </div>
          <div class="form-group">
            <label class="form-label">@lang('fleet.addtototal')</label>
            <select id="addtototal" class="form-control">
              <option value="Y" @if($addon->addtototal == 'Y') selected @endif>Yes</option>
              <option value="N" @if($addon->addtototal == 'N') selected @endif>No</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">@lang('fleet.notes')</label>
            <textarea id="notes" rows="10" class="form-control">{{$addon->notes}}</textarea>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" id="submit_btn"> <i class="fa fa-save"></i> Save</button>
            <a href="{{ route('addon.index')}}" class="btn btn-danger"><i class="fa fa-share"></i> Return</a>
          </div>
        </div>
			</div>
		</div>
	</div>
</div>
@endsection
@section("script")
<script>
    $("#submit_btn").click(function(){
      const description = $("#description").val();
      const amount = $("#amount").val();
      const addtototal = $("#addtototal").val();
      const notes = $("#notes").val();
      if(description == '')
      {
        new PNotify({
          title: 'Warning',
          text: "@lang('fleet.description') @lang('fleet.is_not_empty')",
          type: 'warning'
        });
        return;
      }
      if(amount == '')
      {
        new PNotify({
          title: 'Warning',
          text: "@lang('fleet.amount') @lang('fleet.is_not_empty')",
          type: 'warning'
        });
        return;
      }
      if(notes == '')
      {
        new PNotify({
          title: 'Warning',
          text: "@lang('fleet.notes') @lang('fleet.is_not_empty')",
          type: 'warning'
        });
        return;
      }
      const formData = new FormData();
      formData.append('id', "{{ $addon->id }}");
      formData.append('description', description);
      formData.append('amount', amount);
      formData.append('addtototal', addtototal);
      formData.append('notes', notes);

      $.ajax({
        url: "{{url('admin/addon-update')}}",
        type: "POST",
        data: formData,
        processData: false,  // tell jQuery not to process the data
        contentType: false,  // tell jQuery not to set contentType
        success: function (res) {
          if(res.code === 402) {
            new PNotify({
              title: 'Error',
              text: "@lang('fleet.not_found_addon')",
              type: 'error'
            });
            return;
          }
          new PNotify({
            title: 'Success!',
            text: "@lang('fleet.updated_success')",
            type: 'success'
          });
        }
      });
    });
</script>
@endsection