@extends('layouts.app')

@section('extra_css')
	<style>
		.search_form {
			display: flex;
			justify-content: space-between;
		}

		.search_form input {
			width: 250px;
		}

		.search_form select {
			width: 100px;
		}

		.search_form > .form-group {
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 15px;
		}

		.search_form .form-label {
			margin: 0 !important;
		}

		/* pagination */
		.w-5 {
			width: 20px;
			height: 20px;
		}

		.pagination > nav {
			width: 100%;
		}

		.pagination > nav > div {
			width: 100%;
			display: flex;
			align-items: center;
			justify-content: space-between;
		}

		.pagination > nav > div > div:last-child > span > span > span, .pagination > nav > div > div:last-child > span > a {
			width: 40px;
			height: 40px;
			display: inline-block;
			text-align: center;
			padding: 8px !important;
		}

		.pagination > nav > div > div:last-child > span *{
			background-color: white !important;
		}

		.pagination > nav > div > div:last-child > span [aria-current="page"] > span {
			background-color: #024273 !important;
			color: white !important;
			cursor: not-allowed !important;
		}

		.pagination > nav > div > div:last-child > span [aria-disabled="true"] > span {
			cursor: not-allowed !important;
		}

		.pagination > nav > div:first-child {
			display: none;
		}

		.card-header > div {
			display: flex;
			justify-content: space-between;
			align-items: center;
			width: 100%;
		}
	</style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('crm.index') }}">@lang('menu.crm')</a></li>
<li class="breadcrumb-item active">@lang('fleet.leads')</li>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card card-info">
			<div class="card-header with-border">
				<div>
					<h3 class="card-title">
						@lang('fleet.lead_management')
					</h3>
					<a class="btn btn-sm btn-success" href="{{url('admin/crm-leads/create')}}">
						<i class="fa fa-plus"></i>
						@lang('fleet.add_lead')
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<form id="searchForm" method="GET" action="{{ url('admin/crm-leads') }}">
								<div class="search_form">
									<div class="form-group">
										<label class="form-label">Search:</label>
										<input type="text" class="form-control" name="searchkey" value="{{ request('searchkey') }}" placeholder="Search...">
									</div>
									<div class="form-group">
										<label class="form-label">Page Count:</label>
										<select type="submit" name="perPage" class="form-control" onchange="document.getElementById('searchForm').submit();">
											@foreach([10, 20, 50, 100] as $p)
												<option value="{{ $p }}" @if(request('perPage') == $p) selected @endif>{{ $p }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-responsive">
								<thead class="thead-inverse">
									<tr>
										<th>@lang('fleet.no')</th>
										<th>@lang('fleet.avatar')</th>
										<th>@lang('fleet.gender')</th>
										<th>@lang('fleet.name')</th>
										<th>@lang('fleet.email')</th>
                                        <th>@lang('fleet.phone')</th>
										<th>@lang('fleet.created_at')</th>
										<th>@lang('fleet.action')</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($leads as $key => $lead)
										<tr>
											<td>{{ (($leads->currentPage() - 1 ) * $leads->perPage() ) + $loop->iteration }}</td>
											<td>
												<img src="{{asset('uploads/avatars/').'/'.($lead->avatar ? $lead->avatar : 'default.jpg')}}" style='width: 50px; height: 50px; border-radius: 50%;' />;
											</td>
											<td>{{ $lead->gender == 'M' ? 'Male' : 'Female' }}</td>
											<td>{{ $lead->name }}</td>
                                            <td>{{ $lead->email }}</td>
                                            <td>{{ $lead->phone }}</td>
                                            <td>{{ $lead->created_at }}</td>
                                            <td>
												<a href="javascript:;" title="Convert to customer" class="btn btn-success btn-sm" onclick="confirmtocustomer({{$lead->id}})">
													<i class="fa fa-share"></i>
												</a>
                                                <a title="Edit" class="btn btn-info btn-sm" onclick="edit({{$lead->id}})">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a title="Delete" class="btn btn-danger btn-sm" onclick="confirmDelete({{$lead->id}})">
													<i class="fa fa-trash"></i>
												</a>
                                            </td>
										</tr>
									@endforeach
									@if (count($leads) < 1)
										<tr>
											<td rowspan="2" colspan="8" style="text-align: center;">No Data</td>
										</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12 pagination">
						{{ $leads->withQueryString()->links() }}
					</div>
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

<div id="leadModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">@lang('fleet.update')</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>@lang('fleet.confirm_update')</p>
      </div>
      <div class="modal-footer">
        <button id="bulk_action" class="btn btn-info" onclick="convertcustomer()">@lang('fleet.update')</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('fleet.close')</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section("script")
<script>

var deleteID, lead_id;

function edit(id) {
	window.location.href = "{{url('admin/crm-leads/edit')}}/"+id;
}

function confirmDelete(id) {
	$("#bulkModal").modal('show');
	deleteID = id;
}

function deleteItem() {
	$.post("{{url('admin/crm-leads/delete')}}", {id: deleteID}, function (res) {
		new PNotify({
			title: 'Success!',
			text: "@lang('fleet.deleted')",
			type: 'success'
		});
		setTimeout(() => {
			window.location.reload();
		}, 1000);
	})
}

function confirmtocustomer(id) {
	$("#leadModal").modal('show');
	lead_id = id;
}

function convertcustomer() {
	$.post("{{url('admin/crm-leads/convertcustomer')}}", { id: lead_id }, function (res) {
		new PNotify({
			title: 'Success!',
			text: "@lang('fleet.updated_success')",
			type: 'success'
		});
		setTimeout(() => {
			window.location.reload();
		}, 1000);
	})
}
</script>
@endsection