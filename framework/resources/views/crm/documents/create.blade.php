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
<li class="breadcrumb-item "><a href="{{ url('admin/crm-corporate-accounts') }}">@lang('fleet.documents')</a>
</li>
<li class="breadcrumb-item active">@lang('fleet.add_document')</li>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <div class="card card-info">
            <div class="card-header with-border">
                <h3 class="card-title">
                    @lang('fleet.add_document')
                </h3>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">@lang('fleet.name')</label>
                        <input type="text" class="form-control" placeholder="@lang('fleet.name')" id="name" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('fleet.description')</label>
                        <input type="text" placeholder="@lang('fleet.description')" id="description" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('fleet.corporate')</label>
                        <select id="corporates" class="form-control">
                            @foreach($corporates as $corporate)
                                <option value="{{$corporate->id}}">{{$corporate->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('fleet.documents')</label>
                        <div class="icon_file_select_form">
                            <input type="text" class="form-control" placeholder="@lang('fleet.documents')"
                                id="document" disabled />
                            <button class='btn btn-info btn-sm' id="select_btn">...</button>
                        </div>
                        <input type="file" style="display: none" accept=".pdf, .doc, .docx" id="select_file" />
                    </div>
                    <div>
                        <button class="btn btn-success" onclick="create()">
                            <i class="fa fa-plus"></i>
                            Create
                        </button>
                        <a class="btn btn-danger" href="{{url('admin/crm-documents')}}">
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
        $("#select_btn").click(function(){
            $("#select_file").click();
        })

        $("#select_file").change(function(e){
            file = $(this).get(0).files[0];
            if(file)
                $("#document").val(file.name);
            else
                $("#document").val('');
        })
    })

    function create() {
        var name = $("#name").val();
        var description = $("#description").val();
        var corporate_id = $("#corporates").val();

        if(name == ''){
            new PNotify({
                title: 'Error',
                text: "@lang('fleet.name') @lang('fleet.is_not_empty')",
                type: 'error'
            });
            return;
        }

        if(description == '') {
            new PNotify({
                title: 'Error',
                text: "@lang('fleet.description') @lang('fleet.is_not_empty')",
                type: 'error'
            });
            return;
        }

        if($("#document").val() == '') {
            new PNotify({
                title: 'Error',
                text: "@lang('fleet.file') @lang('fleet.is_not_empty')",
                type: 'error'
            });
            return;
        }

        var formData = new FormData();
        formData.append('name', name);
        formData.append('description', description);
        formData.append('corporate_id', corporate_id);
        formData.append('document', file);
        $.ajax({
            url: "{{url('admin/crm-documents/create')}}",
            type: "POST",
            data: formData,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success: function (res) {
                if(!res.success) {
                    new PNotify({
                        title: 'Error',
                        text: "@lang('fleet.created_failed')",
                        type: 'error'
                    });
                    return;
                }
                new PNotify({
                    title: 'Success',
                    text: "@lang('fleet.created_successfully')",
                    type: 'success'
                });
                setTimeout(function(){ window.location.reload(''); }, 1000);
            }
      });
    }

</script>
@endsection