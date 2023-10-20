<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
      <span class="fa fa-gear"></span>
      <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu custom" role="menu">
      <a class="dropdown-item" class="mybtn changepass" data-id="{{$row->id}}" data-toggle="modal" data-target="#changepass" title="@lang('fleet.change_password')"><i class="fa fa-key"  aria-hidden="true" style="color:#269abc;"></i> @lang('fleet.change_password')</a>
      <a class="dropdown-item" href="{{ url("admin/thirdmanagers/".$row->id."/edit")}}"><span aria-hidden="true" class="fa fa-edit" style="color: #f0ad4e;"></span> @lang('fleet.edit')</a>
      <a class="dropdown-item" data-id="{{$row->id}}" data-toggle="modal" data-target="#myModal"><span class="fa fa-trash" aria-hidden="true" style="color: #dd4b39"></span> @lang('fleet.delete')</a>
    </div>
</div>
{!! Form::open(['url' => 'admin/thirdmanagers/'.$row->id,'method'=>'DELETE','class'=>'form-horizontal','id'=>'form_'.$row->id]) !!}
{!! Form::hidden("id",$row->id) !!}
{!! Form::close() !!}