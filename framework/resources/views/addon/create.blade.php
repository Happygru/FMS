@extends('layouts.app')

@section('extra_css')
<style>
  .icon_file_select_form {
    display: flex;
  }

  .icon_file_select_form > a {
    padding: 8px 12px;
  }

  .icon_file_select_form > input {
    cursor: not-allowed;
  }
</style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('booking-services.index') }}">@lang('menu.add_ons')</a></li>
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
            <label class="form-label">@lang('fleet.name')</label>
            <input type="text" class="form-control" placeholder="@lang('fleet.name')" id="name" />
          </div>
          <div class="form-group">
            <label class="form-label">@lang('fleet.price')</label>
            <input type="text" class="form-control" placeholder="@lang('fleet.price')" id="price" />
          </div>
          <div class="form-group">
            <label class="form-label">@lang('fleet.vendor_type')</label>
            <select class="form-control" id="type">
              <option value="Tours">Tours</option>
              <option value="Extras">Extras</option>
              <option value="Amenities">Amenities</option>
            </select>
          </div>
          <div class="form-group" style="text-align:center;">
            <label class="form-label" style="text-align:left; width: 100%;">@lang('fleet.image')</label>
            <div class="icon_file_select_form">
              <input type="text" class="form-control" placeholder="@lang('fleet.image')" id="select_addon_img" disabled />
              <button class='btn btn-info btn-sm'>...</button>
            </div>
            <img src="" style="margin:auto; width: 80%;margin-top: 10px;" id="addon_img" />
            <input type="file" style="display: none" accept=".jpg, .png, .bmp, .gif" id="select_file" />
          </div>
          <div class="form-group">
            <label class="form-label">@lang('fleet.description')</label>
            <textarea id="description" rows="10" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" id="submit_btn"> <i class="fa fa-paper-plane"></i> Submit</button>
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
    let icon;
    $("#select_file").change(function(e) {
      icon = $(this).get(0).files[0];
      if(icon)
      {
        var reader = new FileReader();
        reader.onload = function(){
            $("#addon_img").attr('src', reader.result);
        };
        reader.readAsDataURL(e.target.files[0]);

        if(icon)
          $("#select_addon_img").val(icon.name);
        else
          $("#select_addon_img").val('');
      } else {
        $("#addon_img").attr('src', "");
        $("#select_addon_img").val("");
      }
    })

    $("#select_addon_img + button").click(function(){
      $("#select_file").click();
    })

    $("#submit_btn").click(function(){
      const name = $("#name").val();
      const price = $("#price").val();
      const type = $("#type").val();
      const description = $("#description").val();
      const image = icon;
      if(name == '')
      {
        new PNotify({
          title: 'Warning',
          text: "@lang('fleet.input_name')",
          type: 'warning'
        });
        return;
      }
      if(description == '')
      {
        new PNotify({
          title: 'Warning',
          text: "@lang('fleet.input_description')",
          type: 'warning'
        });
        return;
      }
      if($("#select_addon_img").val() == '') {
        new PNotify({
          title: 'Warning',
          text: "@lang('fleet.input_file')",
          type: 'warning'
        });
        return;
      }
      const formData = new FormData();
      formData.append('name', name);
      formData.append('description', description);
      formData.append('image', image);
      formData.append('type', type);
      formData.append('price', price);

      $.ajax({
        url: "{{url('admin/addon-create')}}",
        type: "POST",
        data: formData,
        processData: false,  // tell jQuery not to process the data
        contentType: false,  // tell jQuery not to set contentType
        success: function (res) {
          if(res.code === 402) {
            new PNotify({
              title: 'Error',
              text: "@lang('fleet.addon_already_exist')",
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