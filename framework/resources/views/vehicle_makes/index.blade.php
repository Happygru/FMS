@extends('layouts.app')
@section("breadcrumb")
<li class="breadcrumb-item active">@lang('fleet.vehicle_types')</li>
@endsection
@section('extra_css')
<style type="text/css">
  .checkbox, #chk_all{
    width: 20px;
    height: 20px;
  }
</style>
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-info">
      <div class="card-header">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <h3 class="card-title">@lang('fleet.manage_vehicle_make')</h3>
            <a href="{{ url('admin/vehicle-makes/create') }}" class="btn btn-success btn-sm" title="@lang('fleet.addNew')"><i class="fa fa-plus"></i> @lang('fleet.add_vehicle_make')</a>
        </div>
      </div>

      <div class="card-body table-responsive">
        <table class="table" id="ajax_data_table">
          <thead class="thead-inverse">
            <tr>
              <th>No.</th>
              <th>@lang('fleet.name')</th>
              <th>@lang('fleet.action')</th>
            </tr>
          </thead>
          <tbody>
            @foreach($vehicle_makes as $key => $vehicle_make)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $vehicle_make->name }}</td>
                    <td>
                        <a href="{{ url('admin/vehicle-makes/edit/').'/'.$vehicle_make->id }}" class="btn btn-success btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#bulkModal" onclick="confirm_delete({{$vehicle_make->id}})">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="bulkModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">@lang('fleet.delete')</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>@lang('fleet.confirm_bulk_delete')</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" onclick="delete_item()">@lang('fleet.delete')</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('fleet.close')</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
@endsection

@section('script')
<script>
  var make_id;

  function confirm_delete(id) {
    make_id = id;
  }

  function delete_item() {
    $.post("{{url('admin/vehicle-makes/delete')}}", { id: make_id }, function (res) {
        new PNotify({
            title: 'Success!',
            text: "@lang('fleet.deleted')",
            type: 'success'
        });
        setTimeout(function(){ window.location.reload() }, 1000);
    })
  }
</script>
@endsection