@extends('layouts.app')

@section('extra_css')
<style>
	button {
		white-space: nowrap;
	}
</style>
@endsection
@section("breadcrumb")
<li class="breadcrumb-item "><a href="{{ route('branches.index') }}">@lang('menu.branches')</a></li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header with-border">
                <h3 class="card-title">
                    @lang('menu.all_branches')
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive" id="branch_list" style="min-width: max-content; width: 100%;">
                        <thead class="thead-inverse">
							<tr>
								<th style="width:40%">Branch</th>
								<th style="width:15%">Code</th>
								<th style="width:10%">Rate</th>
								<th style="width:10%">Commission</th>
								<th style="width:20%">Manager</th>
								<th style="width:10%">Actions</th>
							</tr>
                        </thead>
                        <tbody>
							@foreach($branches as $branch)
								<tr>
									<td>{{ $branch->name }}</td>
									<td>{{ $branch->code }}</td>
									<td>{{ $branch->rate }}</td>
									<td>{{ $branch->commission }}</td>
									<td>{{ $branch->username }}</td>
									<td>
										<button class="btn btn-success" onclick="edit_branch({{ $branch->id }})">
												<i class="fa fa-edit"></i>
												Edit
										</button>
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
@endsection
@section("script")
<script type="text/javascript">
$(document).ready(function() {
    $("#branch_list").DataTable({
        width: "100%"
    });
})

function edit_branch(id) {
	window.location.href = "{{ route('branches.edit', ':id') }}".replace(':id', id);
}
</script>
@endsection