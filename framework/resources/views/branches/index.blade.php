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
								<th style="width:50%">Branch</th>
								<th style="width:15%">Code</th>
								<th style="width:10%">Commission</th>
								<th style="width:25%">Manager</th>
								<th style="width:10%">Actions</th>
							</tr>
                        </thead>
                        <tbody>
							@foreach($branches as $branch)
								<tr>
									<td>{{ $branch->name }}</td>
									<td>{{ $branch->code }}</td>
									<td>{{ $branch->commission }}</td>
									<td>{{ $branch->username }}</td>
									<td>
										<a class="btn btn-success btn-sm" onclick="edit_branch({{ $branch->id }})">
											<i class="fa fa-edit"></i>
										</a>
										<a class="btn btn-danger btn-sm" data-target="#bulkModal" data-toggle="modal" onclick="confirm_delete({{ $branch->id }})">
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
				<p>@lang('fleet.confirm_bulk_delete')</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger" onclick="delete_branch()">@lang('fleet.delete')</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">@lang('fleet.close')</button>
			</div>
		</div>
	</div>
</div>

@endsection
@section("script")
<script type="text/javascript">
var branch_id;
$(document).ready(function() {
    $("#branch_list").DataTable({
        width: "100%"
    });
})

function edit_branch(id) {
	window.location.href = "{{ route('branches.edit', ':id') }}".replace(':id', id);
}

function confirm_delete(id) {
	branch_id = id;
	console.log(id);
}

function delete_branch() {
	$.post("{{ route('branches.delete') }}", { id: branch_id }, function (res) {
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