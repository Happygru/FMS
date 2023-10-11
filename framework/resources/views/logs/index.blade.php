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
<li class="breadcrumb-item active">@lang('menu.settings')</li>
<li class="breadcrumb-item active">@lang('fleet.logs')</li>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card card-info">
			<div class="card-header with-border">
				<div>
					<h3 class="card-title">
						@lang('fleet.logs')
					</h3>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<form id="searchForm" method="GET" action="{{ url('admin/logs') }}">
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
										<th>No</th>
										<th>@lang('fleet.url')</th>
                                        <th>@lang('fleet.action')</th>
                                        <th>@lang('fleet.username')</th>
                                        <th>@lang('fleet.ipaddress')</th>
										<th>Log Date</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($documents as $key => $document)
										<tr>
											<td>{{ (($documents->currentPage() - 1 ) * $documents->perPage() ) + $loop->iteration }}</td>
											<td>{{ $document->url }}</td>
                                            <td>{{ $document->action }}</td>
                                            <td>{{ $document->c_name }}</td>
                                            <td>{{ $document->ipaddress }}</td>
											<td>{{ $document->created_at ? (new DateTime($document->created_at))->format('Y-m-d') : '' }}</td>
										</tr>
									@endforeach
									@if (count($documents) < 1)
										<tr>
											<td rowspan="2" colspan="7" style="text-align: center;">No Data</td>
										</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12 pagination">
						{{ $documents->withQueryString()->links() }}
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
@endsection
@section("script")

@endsection