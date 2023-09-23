@extends('layouts.app')

@section('extra_css')
<style>
	#booking_services_list {
		font-weight: bold;
	}

	#booking_services_list img{
    width: 100%;
		max-width: 100%;
  }
</style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('booking-services.index') }}">@lang('menu.booking_services')</a></li>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card card-info">
			<div class="card-header with-border">
				<h3 class="card-title">
					@lang('fleet.all_services')
				</h3>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-responsive" id="booking_services_list" style="padding-bottom: 35px; width: 100%">
						<thead class="thead-inverse">
							<tr>
								<th style="width: 60px; text-align: center;">No</th>
								<th style="width: 20%;min-width:100px">@lang('fleet.icon')</th>
								<th style="width: 15%;">@lang('fleet.name')</th>
								<th style="width: 40%;">@lang('fleet.description')</th>
								<th style="width: 15%">@lang('fleet.service_type')</th>
								<th style="width: 90px;white-space:nowrap;">@lang('fleet.action')</th>
							</tr>
						</thead>
						<tbody>

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
	let deleteID;
	$(document).ready(function() {
		getBookingSerivceList();
	})

	function getBookingSerivceList() {
		$.get("{{url('admin/booking-services-fetch')}}", function (res) {
			let str = ""
			for(let i = 0; i < res.length; i++) {
				str += "<tr><td style='text-align: center'>"+(i+1)+"</td><td><img src='{{asset('uploads/services/')}}/"+res[i].icon+"'></td><td>"+res[i].name+"</td><td>"+res[i].description+"<div><p class='badge bg-success'>" + (res[i].website == 1 ? 'website' : '') + "</p> <p class='badge bg-success'>" + (res[i].backend == 1 ? 'backend' : '') + "</p> <p class='badge bg-success'>" + (res[i].corporate == 1 ? 'corporate' : '') + "</p></div></td><td>" + (res[i].type == 'C' ? '<p class="badge bg-primary">Chauffeur-Driven</p>' : '<p class="badge bg-warning">Self-Driven</p>') + "</td><td style='text-align: center;white-space:nowrap;'><a class='btn btn-info btn-sm' onclick='editItem(" + res[i].id + ")'><i class='fa fa-edit'></i></a> <a onclick='confirmDelete(" + res[i].id + ")' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a></td></tr>";
			}
			$("#booking_services_list tbody").html(str);
			$("#booking_services_list").DataTable();
		})
	}

	function confirmDelete(id) {
		deleteID = id;
    	$('#bulkModal').modal('show');
	}
	
	function editItem(id) {
        window.location.href = "{{url('admin/booking-services/edit')}}/"+id;
	}

	function deleteItem() {
		$.post("{{url('admin/booking-services-delete')}}", {id: deleteID}, function (res) {
			new PNotify({
				title: 'Success!',
				text: "@lang('fleet.deleted')",
				type: 'success'
			});
			$('#bulkModal').modal('hide');
			getBookingSerivceList();
		})
	}
</script>
@endsection