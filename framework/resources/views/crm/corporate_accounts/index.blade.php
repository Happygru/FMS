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
<li class="breadcrumb-item active">@lang('menu.corporate_accounts')</li>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card card-info">
			<div class="card-header with-border">
				<div>
					<h3 class="card-title">
						@lang('fleet.corporate_account_management')
					</h3>
					<button class="btn btn-sm btn-success">
						<i class="fa fa-plus"></i>
						Add account
					</button>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<form id="searchForm" method="GET" action="{{ url('admin/crm-corporate-accounts') }}">
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
										<th>Name</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Address</th>
										<th>Location</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($corporateAccounts as $key => $accounts)
										<tr>
											<td>{{ (($corporateAccounts->currentPage() - 1 ) * $corporateAccounts->perPage() ) + $loop->iteration }}</td>
											<td>{{ $accounts->name }}</td>
											<td>{{ $accounts->email }}</td>
											<td>{{ $accounts->phone }}</td>
											<td>{{ $accounts->address }}</td>
											<td>{{ $accounts->location }}</td>
											<td>
												<button class="btn btn-sm btn-info">
													<i class="fa fa-edit"></i>
												</button>
												<button class="btn btn-sm btn-danger">
													<i class="fa fa-trash"></i>
												</button>
											</td>
										</tr>
									@endforeach
									@if (count($corporateAccounts) < 1)
										<tr>
											<td rowspan="2" colspan="7" style="text-align: center;">No Data</td>
										</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12 pagination">
						{{ $corporateAccounts->withQueryString()->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section("script")
<script>
	
</script>
@endsection