@extends('layouts.app')

@section('extra_css')
<style>
  .icon_file_select_form {
    display: flex;
  }

  .icon_file_select_form > a {
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
</style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('booking-services.index') }}">@lang('menu.booking_services')</a></li>
<li class="breadcrumb-item active">@lang('fleet.edit_booking_service')</li>
@endsection
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-6">
		<div class="card card-info">
			<div class="card-header with-border">
				<h3 class="card-title">
					@lang('fleet.add_booking_service')
				</h3>
			</div>
			<div class="card-body">
				<div class="col-md-12">
          <div class="form-group">
            <label class="form-label">@lang('fleet.name')</label>
            <input type="text" class="form-control" placeholder="@lang('fleet.enter_service_name')" id="service_name" value="{{$service->name}}" />
          </div>
          <div class="form-group" style="text-align:center;">
            <label class="form-label" style="text-align:left; width: 100%;">@lang('fleet.service_icon')</label>
            <div class="icon_file_select_form">
              <input type="text" class="form-control" placeholder="@lang('fleet.enter_service_icon')" id="select_service_icon" value="{{$service->icon}}" disabled />
              <button class='btn btn-info btn-sm'>...</button>
            </div>
            <img src="{{asset('uploads/services/')}}/{{$service->icon}}" style="margin:auto; width: 80%;margin-top: 10px;" id="service_img" />
            <input type="file" style="display: none" accept=".jpg, .png, .bmp, .gif" id="select_file" />
          </div>
          <div class="form-group">
            <label class="form-label">@lang('fleet.description')</label>
            <textarea id="service_description" rows="10" class="form-control">{{$service->description}}</textarea>
          </div>
<!--           <div class="form-group">
            <label class="form-label">@lang('fleet.service_type')</label>
            <select class="form-control" id="service_type">
              <option value="C" @if($service->type == 'C') selected @endif>Chauffeur-Driven</option>
              <option value="S" @if($service->type == 'S') selected @endif>Self-Driven</option>
            </select>
          </div> -->
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input big-checkbox" type="checkbox" value="" id="website_checkbox" {{$service->website ? 'checked' : ''}}>
              <label class="form-check-label" for="website_checkbox">
                @lang('fleet.available_on_website')
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input big-checkbox" type="checkbox" value="" id="backend_checkbox" {{$service->backend ? 'checked' : ''}}>
              <label class="form-check-label" for="backend_checkbox">
                @lang('fleet.available_in_backend')
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input big-checkbox" type="checkbox" value="" id="corporate_checkbox" {{$service->corporate ? 'checked' : ''}}>
              <label class="form-check-label" for="corporate_checkbox">
                @lang('fleet.available_for_corporate_clients')
              </label>
            </div>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" id="submit_btn"> <i class="fa fa-paper-plane"></i> Submit</button>
            <a href="{{ route('booking-services.index')}}" class="btn btn-danger"><i class="fa fa-share"></i> Return</a>
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
    let icon;
    $("#select_file").change(function(e) {
      icon = $(this).get(0).files[0];
      if(icon)
      {
        var reader = new FileReader();
        reader.onload = function(){
            $("#service_img").attr('src', reader.result);
        };
        reader.readAsDataURL(e.target.files[0]);

        if(icon)
          $("#select_service_icon").val(icon.name);
        else
          $("#select_service_icon").val('');
      } else {
        $("#service_img").attr('src', "");
        $("#select_service_icon").val("");
      }
    })
    $("#select_service_icon + button").click(function(){
      $("#select_file").click();
    })

    $("#submit_btn").click(function(e) {
      const name = $("#service_name").val();
      const description = $("#service_description").val();
      const type = $("#service_type").val();
      const website = $("#website_checkbox").is(":checked");
      const backend = $("#backend_checkbox").is(":checked");
      const corporate = $("#corporate_checkbox").is(":checked");
      if(name == '')
      {
        new PNotify({
          title: 'Warning',
          text: "@lang('fleet.input_service_name')",
          type: 'warning'
        });
        return;
      }
      if(description == '')
      {
        new PNotify({
          title: 'Warning',
          text: "@lang('fleet.input_service_description')",
          type: 'warning'
        });
        return;
      }
      if($("#select_service_icon").val() == '') {
        new PNotify({
          title: 'Warning',
          text: "@lang('fleet.input_service_icon')",
          type: 'warning'
        });
        return;
      }
      
      var formData = new FormData();
      formData.append('id', "{{ $service->id }}");
      formData.append('name', name);
      formData.append('description', description);
      formData.append('icon', icon);
      // formData.append('type', type);
      formData.append('website', Number(website));
      formData.append('backend', Number(backend));
      formData.append('corporate', Number(corporate));
      $.ajax({
        url: "{{url('admin/booking-services-update')}}",
        type: "POST",
        data: formData,
        processData: false,  // tell jQuery not to process the data
        contentType: false,  // tell jQuery not to set contentType
        success: function (res) {
          if(res.code === 402) {
            new PNotify({
              title: 'Error',
              text: "@lang('fleet.not_found_service')",
              type: 'error'
            });
            return;
          }
          new PNotify({
            title: 'Success!',
            text: "@lang('fleet.service_updated_successfully')",
            type: 'success'
          });
        }
      });
    })
  })
</script>
@endsection