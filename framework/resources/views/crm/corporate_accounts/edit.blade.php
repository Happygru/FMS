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
</style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('crm.index') }}">@lang('menu.crm')</a></li>
<li class="breadcrumb-item "><a href="{{ url('admin/crm-corporate-accounts') }}">@lang('fleet.corporate_accounts')</a>
</li>
<li class="breadcrumb-item active">@lang('fleet.edit_corporate_account')</li>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="card card-info">
            <div class="card-header with-border">
                <h3 class="card-title">
                    @lang('fleet.edit_corporate_account')
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="col-md-12" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <img src="{{asset('uploads/avatars/'.($data->avatar ? $data->avatar : 'default.jpg'))}}" style="width: 100px; height: 100%; border-radius: 50%;" id="selected_img" />
                    <button class="btn btn-sm btn-success my-4" id="select_button">Browse...</button>
                    <input type="file" id="select_img" style="display: none;">
                  </div>
                  <div class="form-group col-md-6 col-xs-12">
                      <label class="form-label">@lang('fleet.name')</label>
                      <input type="text" class="form-control" placeholder="@lang('fleet.name')" id="name" value="{{$data->name}}" />
                  </div>
                  <div class="form-group col-md-6 col-xs-12">
                      <label class="form-label">@lang('fleet.email')</label>
                      <input type="email" placeholder="@lang('fleet.email')" id="email" class="form-control" value="{{$data->email}}" />
                  </div>
                  <div class="form-group col-md-6 col-xs-12">
                    <label class="form-label">@lang('fleet.gender')</label>
                    <select id="gender" class="form-control">
                      <option value="M" @if($data->gender == 'M') selected @endif>Male</option>
                      <option value="F" @if($data->gender == 'F') selected @endif>Female</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6 col-xs-12">
                      <label class="form-label">@lang('fleet.phone')</label>
                      <input type="text" id="phone" class="form-control" placeholder="@lang('fleet.phone')" value="{{$data->phone}}" />
                  </div>
                  <div class="form-group col-md-6 col-xs-12">
                      <label class="form-label">@lang('fleet.address')</label>
                      <input type="text" id="address" class="form-control" placeholder="@lang('fleet.address')" value="{{$data->addr}}" />
                  </div>
                  <div class="form-group col-md-6 col-xs-12">
                      <label class="form-label">@lang('fleet.location')</label>
                      <input type="text" id="location" class="form-control" placeholder="@lang('fleet.location')" value="{{$data->location}}}" />
                  </div>
                  <div class="form-group col-md-6 col-xs-12">
                    <label class="form-label">@lang('fleet.customer_type')</label>
                    <select id="customer_type" class="form-control">
                      <option value="I" @if($data->customer_type == 'I') selected @endif>Individual</option>
                      <option value="C" @if($data->customer_type == 'C') selected @endif>Corporate</option>
                    </select>
                  </div>
                  <div class="col-md-12">
                      <button class="btn btn-success" onclick="update()">
                          <i class="fa fa-save"></i>
                          @lang('fleet.save')
                      </button>
                      <a class="btn btn-danger" href="{{url('admin/crm-corporate-accounts')}}">
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
@if(Hyvikk::api('google_api') == '1')
<script>
function initMap() {
    // var input = document.getElementById('searchMapInput');
    var pickup_addr = document.getElementById('address');
    new google.maps.places.Autocomplete(pickup_addr);

    var dropoff_addr = document.getElementById('location');
    new google.maps.places.Autocomplete(dropoff_addr);

    // autocomplete.addListener('place_changed', function() {
    //     var place = autocomplete.getPlace();
    //     document.getElementById('pickup_addr').innerHTML = place.formatted_address;
    // });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ Hyvikk::api('api_key') }}&libraries=places&callback=initMap"
    async defer></script>
@endif
<script>

    var file;

    $(document).ready(function() {
      $("#select_img").change(function(e) {
        file = $(this).get(0).files[0];
        if(file)
        {
          var reader = new FileReader();
          reader.onload = function(){
              $("#selected_img").attr('src', reader.result);
          };
          reader.readAsDataURL(e.target.files[0]);
        }
        if(file)
          $("#selected_img").attr('src', reader.result);
        else
          $("#selected_img").attr('src', '{{asset('uploads/avatars/default.jpg')}}');
      })

      $("#select_button").click(function(){
        $("#select_img").click();
      })
    })

    function update() {
        var name = $("#name").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var address = $("#address").val();
        var location = $("#location").val();
        var gender = $("#gender").val();
        var customer_type = $("#customer_type").val();

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

        if(address == '') {
            new PNotify({
                title: 'Error',
                text: "@lang('fleet.address') @lang('fleet.is_not_empty')",
                type: 'error'
            });
            return;
        }

        if(location == '') {
            new PNotify({
                title: 'Error',
                text: "@lang('fleet.location') @lang('fleet.is_not_empty')",
                type: 'error'
            });
            return;
        }

        var formData = new FormData();
        formData.append('id', {{$data->id}});
        formData.append('name', name);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('address', address);
        formData.append('location', location);
        formData.append('gender', gender);
        formData.append('customer_type', customer_type);
        formData.append('avatar', file);

        $.ajax({
            url: "{{route('customers.ajax_update')}}",
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
                    text: "@lang('fleet.updated_success')",
                    type: 'success'
                });
                // setTimeout(function(){ window.location.reload(''); }, 1000);
                console.log(res);
            }
      });
    }

</script>
@endsection