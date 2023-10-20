<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
      <span class="fa fa-gear"></span>
      <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu custom" role="menu">
      <a class="dropdown-item openBtn" data-id="{{$row->id}}" data-toggle="modal" data-target="#myModal2" id="openBtn">
      <span class="fa fa-eye" aria-hidden="true" style="color: #398439"></span> @lang('fleet.view_vehicle')
      </a>
    </div>
  </div>
  {!! Form::open(['url' => 'admin/vehicles/'.$row->id,'method'=>'DELETE','class'=>'form-horizontal','id'=>'form_'.$row->id]) !!}

  {!! Form::hidden("id",$row->id) !!}

  {!! Form::close() !!}