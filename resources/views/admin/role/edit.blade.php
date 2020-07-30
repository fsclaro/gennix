@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-user-tag"></i> {{ __('gennix.model_role.view_title') }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('role_edit') }}
</div>
@stop

@section('content')
<form method="post" action="{{ route('role.update', $role->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="id">{{ __('gennix.model_role.details_id') }}</label><br>
                            <input type="text" class="form-control text-right" readonly id="id" value="{{ $role->id }}">
                        </div>

                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }} col-md-10">
                            <label for="title">{{ __('gennix.model_role.details_title')}}</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') ? old('title') : $role->title }}">

                            @if($errors->has('title'))
                            <small class="form-text text-red text-bold">
                                {{ $errors->first('title') }}
                            </small>
                            @endif
                        </div>
                    </div> <!-- ./row -->

                    <div class="row">
                        <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }} col-md-12">
                            <label for="permissions">{{ __('gennix.model_role.permissions') }}
                                <a class="btn btn-success btn-sm text-white" id="select-all" onclick="return selectAll();">
                                    <i class="fas fa-fw fa-check-double"></i> {{ __('gennix.model_role.select_all') }}
                                </a>

                                <a class="btn btn-danger btn-sm text-white" id="deselect-all" onclick="return deselectAll();">
                                    <i class="fas fa-fw fa-undo"></i> {{ __('gennix.model_role.unselect_all') }}
                                </a>
                            </label>

                            <select name="permissions[]" id="permissions" class="select2 form-control" multiple="multiple" style="width:100%;">
                                @foreach($permissions as $id => $permissions)
                                <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>
                                    {{ $permissions }}
                                </option>
                                @endforeach
                            </select>

                            @if($errors->has('permissions'))
                            <small class="form-text text-red text-bold">
                                {{ $errors->first('permissions') }}
                            </small>
                            @endif
                        </div>
                    </div> <!-- ./row -->
                </div> <!-- ./card-body -->

                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route('role.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-circle-left"> {{ __("gennix.back") }}</i>
                        </a>
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> {{ __("gennix.save") }}
                        </button>
                    </div>
                </div> <!-- ./card-footer-->
            </div> <!-- ./card -->
        </div> <!-- ./col-md-12 -->
    </div> <!-- ./row -->
</form>
@stop



@section('adminlte_css_pre')
@stop

@section('css')
@stop

@section('js')
<script>
    $(function() {
        $("#permissions").select2({
            placeholder: "{{ __('gennix.model_role.select_one') }}",
            allowClear: true,
        });
    });

    function selectAll() {
        let select = document.getElementById('permissions');
        let options = new Array();

        for (let index = 0; index < select.length; index++) {
            options[index] = select.options[index].value;
        }
        $("#permissions").val(options);
        $("#permissions").trigger("change");
    }

    function deselectAll() {
        $("#permissions").val('');
        $("#permissions").trigger("change");
    }
</script>
@stop
