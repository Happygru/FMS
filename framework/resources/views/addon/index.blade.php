@extends('layouts.app')

@section('extra_css')
<style>
	button {
		white-space: nowrap;
	}
</style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('addon.index') }}">@lang('menu.add_ons')</a></li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
          <div class="card-header with-border">
            <h3 class="card-title">
              @lang('menu.add_ons')
            </h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-responsive">
                <thead>
                  <tr>
                    <th>@lang('fleet.no')</th>
                    <th>@lang('fleet.description')</th>
                    <th>@lang('fleet.amount')</th>
                    <th style="text-align: center;">@lang('fleet.addtototal')</th>
                    <th>@lang('fleet.notes')</th>
                    <th>@lang('fleet.action')</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($addon_list as $key => $addon)
                    <tr>
                      <td>
                        {{ $addon->id }}
                      </td>
                      <td>
                        {{ $addon->description }}
                      </td>
                      <td style="text-align: right;">
                        {{ $addon->amount }}$
                      </td>
                      <td style="text-align: center;">
                        @if($addon->addtototal == 'Y')
                          <p class="badge badge-success">Yes</p>
                        @else
                          <p class="badge badge-warning">No</p>
                        @endif
                      </td>
                      <td>
                        {{ $addon->notes }}
                      </td>
                      <td>
                        <a href="{{ route('addon.edit', $addon->id) }}" class="btn btn-sm btn-info">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-sm btn-danger" onclick="confirmDelete({{$addon->id}})">
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
</div>
<div id="bulkModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">@lang('fleet.delete')</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>@lang('fleet.confirm_delete')</p>
      </div>
      <div class="modal-footer">
        <button id="bulk_action" class="btn btn-danger" onclick="deleteItem()">@lang('fleet.delete')</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('fleet.close')</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section("script")
<script type="text/javascript">

  var id = 0;

  function confirmDelete(delete_id) {
    id = delete_id;
    $("#bulkModal").modal('show');
  }

  function deleteItem() {
    $.post('{{url("admin/addon-delete")}}', { id }, function (res) {
      new PNotify({
				title: 'Success!',
				text: "@lang('fleet.deleted')",
				type: 'success'
			});
      setTimeout(function(){ window.location.reload(); }, 1000);
    })
  }

</script>
@endsection