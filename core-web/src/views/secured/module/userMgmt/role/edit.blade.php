@extends('layouts.secured')

@section('content')

<script type="text/javascript">

function renderRoleListing(){

	var roleId = $('#roleId').val();
	var urlRoleFunction = '{{ route("roleFunction.grid", ":id") }}';
	urlRoleFunction = urlRoleFunction.replace(':id', roleId);	
	
	$.ajax({
		type : "GET",
		url : urlRoleFunction,
		data : {
			
				},
		dataType : 'json',
		success : function(respond) {
						markup = '';
    					$.each(respond.data, function (i, item){
    						markup += '<tr>';
    						markup += '<th scope="row">'+item.name+'</th>';
    						markup += '<th scope="row">'+item.createable+'</th>';
    						markup += '<th scope="row">'+item.deleteable+'</th>';
    						markup += '<th scope="row">'+item.readable+'</th>';
    						markup += '<th scope="row">'+item.updateable+'</th>';
    						markup += '<td><a href="#" onclick="renderFunctionModalEdit(\''+item.name+'\', \''
    																				   +item.role_id+'\', \''
    																				   +item.function_code+'\', \''
    																				   +item.createable+'\', \''
    																				   +item.deleteable+'\', \''
    																				   +item.readable+'\', \''
    																				   +item.updateable+'\');" >{{ __('messages_core_web.edit') }}</a></td>';   
                            var url = '{{ route("roleFunction.delete", [":roleId", ":functionCode"]) }}';
                            url = url.replace(':roleId', item.role_id);
                            url = url.replace(':functionCode', item.function_code);							
                            markup += '<td><a href="'+url+'">{{ __('messages_core_web.delete') }}</a></td>';						
    						markup += '</tr>';
    					});

						$("#tbodyListRole").append(markup);
    					
					},
		error : function(request, status, error) {
							$("#tbodyListRole").append('<span class="alert alert-danger" role="alert">Error...</span>');
					},
	});
}

function saveNewRoleFunction(){

	$.ajax({
		type : 'POST',
		url : "{{ route('roleFunction.create') }}",
		data : {
				function_code : $('#modelFunctionCodeNew').val(), 
				roleId : $('#modalRoleIdNew').val(),
				createable : $('#createableNew').val(),
				deleteable : $('#deleteableNew').val(),
				readable : $('#readableNew').val(),
				updateable : $('#updateableNew').val(),					
				},
		dataType : 'json',
		success : function(respond) {
			$('#functionModalNew').modal('hide');
			$('#tbodyListRole').empty();
			renderRoleListing();
			},
		error : function(request, status, error){

			console.log(request);
			var json = $.parseJSON(request.responseText);
			console.log(json);

			$.each(json.errors, function(key, value){
				$("#modalNew").append('<span class="alert alert-danger" role="alert">'+value+'</span>');
			});
			
			}
		});
	
}

function renderFunctionModalEdit(name, roleId, functionCode, createable, deleteable, readable, updateable){
	$('#functionNameEdit').val(name);
	$('#modelFunctionCodeEdit').val(functionCode);
	$('#modalRoleIdEdit').val(roleId);

	if(createable == 'true'){
		$('#createableEdit').prop('checked', true);
	}else{
		$('#createableEdit').prop('checked', false);
	}

	if(deleteable == 'true'){
		$('#deleteableEdit').prop('checked', true);
	}else{
		$('#deleteableEdit').prop('checked', false);
	}

	if(readable == 'true'){
		$('#readableEdit').prop('checked', true);
	}else{
		$('#readableEdit').prop('checked', false);
	}

	if(updateable == 'true'){
		$('#updateableEdit').prop('checked', true);
	}else{
		$('#updateableEdit').prop('checked', false);
	}
	
	$('#functionModalEdit').modal('show');
}

function renderFunctionModalNew(){

	$('#modalNew').empty();
	$('#modalRoleIdNew').val($('#roleId').val());

	$('#createableNew').prop('checked', true);
	$('#deleteableNew').prop('checked', true);
	$('#readableNew').prop('checked', true);
	$('#updateableNew').prop('checked', true);
	
	$('#functionModalNew').modal('show');
}

$(document).ready(function(){
	renderRoleListing();
});
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('messages_core_web.editRole') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('role.update') }}">
                        @csrf
                        
                        @if ($errors->any())
                        <div class="form-group row">
                        	<div class="col-md-12">
                                <span class="alert alert-danger" role="alert">
                                    @foreach ($errors->all() as $error)
    									<strong>{{ $error }}</strong>       										
                                    @endforeach
                                </span>
                            </div>
                        </div>
                        @enderror
                        
                        <input id="roleId" type="hidden" name="id" value="{{ $role->id }}">
                        
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.name') }}</label>
                        	
                        	<div class="col-sm-4">
                        		<input type="text" class="form-control" name="name" value="{{ $role->name }}">
                        	</div>
                        	
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.sortOrder') }}</label>
                        	<div class="col-sm-4">
                        		<input type="number" class="form-control" name="sort_order" value="{{ $role->sort_order }}">
                        	</div>
                        </div>
                        
                        <div class="form-group row">
                        	
                        </div>
                        
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.description') }}</label>
                        	<div class="col-sm-6">
                        		<textarea rows="" cols="" class="form-control" name="description">{{ $role->description }}</textarea>
                        	</div>
                        </div>
                        
                    	<button type="submit" class="btn btn-primary">{{ __('messages_core_web.save')}}</button>
                		<a class="btn btn-primary" href="{{ url()->previous() }}">{{ __('messages_core_web.back')}}</a>
                       
                    </form>
                </div>
            </div>
            
            <br>
            
            <div class="card">
                <div class="card-header">
                	<div class="row">
                		<div class="col-md-10" style="vertical-align: middle;">
                				{{ __('messages_core_web.roleFunction') }}
                		</div>
                		<div class="col-md-2 float-right">
                			<a type="button" class="btn btn-primary btn-sm float-right" href="#" onclick="renderFunctionModalNew();">{{ __('messages_core_web.new') }}</a>
                		</div>
                	</div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('role.update') }}">
                        
                        <div class="form-group row">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('messages_core_web.function') }}</th>
                                        <th scope="col">{{ __('messages_core_web.createable') }}</th>
                                        <th scope="col">{{ __('messages_core_web.updateable') }}</th>
                                        <th scope="col">{{ __('messages_core_web.readable') }}</th>
                                        <th scope="col">{{ __('messages_core_web.deleteable') }}</th>
                                        <th scope="col">{{ __('messages_core_web.edit') }}</th>
                                        <th scope="col">{{ __('messages_core_web.delete') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyListRole">
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
    
    <div class="modal fade" id="functionModalEdit" tabindex="-1" role="dialog" aria-labelledby="functionModalLabelEdit" aria-hidden="true">
    	<div class="modal-dialog" role="document">
    		<div class="modal-content">
    			<form action="{{ route('roleFunction.update') }}" method="POST">
    				 @csrf
    				<div class="modal-header">
        				<h5>{{ __('messages_core_web.roleFunction') }}</h5>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        					<span aria-hidden="true">&times;</span>
        				</button>
        			</div>
        			
        			<div class="modal-body">
        			
        				<input type="hidden" id="modalRoleIdEdit" name="role_id">
        				<input type="hidden" id="modelFunctionCodeEdit" name="function_code">
        				<div class="form-group row">
                        	<label class="col-sm-3 col-form-label">{{ __('messages_core_web.function') }}</label>
                        	
                        	<div class="col-sm-9">
                        		<input type="text" id="functionNameEdit" class="form-control" name="functionName" readonly="readonly">
                        	</div>
                    	</div>
                    	
                    	<div class="form-group row">
                        	<label class="col-sm-3 col-form-label">{{ __('messages_core_web.createable') }}</label>
                        	<div class="col-sm-3">
                        		<input class="form-check-input" type="checkbox" id="createableEdit" name="createable">
                        	</div>
    
                        	<label class="col-sm-3 col-form-label">{{ __('messages_core_web.deleteable') }}</label>
                        	<div class="col-sm-3">
                        		<input class="form-check-input" type="checkbox" id="deleteableEdit" name="deleteable">
                        	</div>
                        </div>
                        
                        <div class="form-group row">
                        	<label class="col-sm-3 col-form-label">{{ __('messages_core_web.readable') }}</label>
                        	<div class="col-sm-3">
                        		<input class="form-check-input" type="checkbox" id="readableEdit" name="readable">
                        	</div>
    
                        	<label class="col-sm-3 col-form-label">{{ __('messages_core_web.updateable') }}</label>
                        	<div class="col-sm-3">
                        		<input class="form-check-input" type="checkbox" id="updateableEdit" name="updateable">
                        	</div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
        				<button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('messages_core_web.close') }}</button>
        				<button type="submit" class="btn btn-primary">{{ __('messages_core_web.save') }}</button>
        			</div>
    			</form>
			</div>
		</div>
	</div>
	
	   
    <div class="modal fade" id="functionModalNew" tabindex="-1" role="dialog" aria-labelledby="functionModalLabelNew" aria-hidden="true">
    	<div class="modal-dialog" role="document">
    		<div class="modal-content">
    			<form action="">
    				<div class="modal-header">
        				<h5>{{ __('messages_core_web.roleFunction') }}</h5>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        					<span aria-hidden="true">&times;</span>
        				</button>
        			</div>
        			
        			<div class="modal-body">
        			
        				<div id="modalNew" class="form-group row">
        				</div>
        			
        				<input type="hidden" id="modalRoleIdNew" name="role_id">
        				<div class="form-group row">
                        	<label class="col-sm-3 col-form-label">{{ __('messages_core_web.function') }}</label>
                        	
                        	<div class="col-sm-9">
                        		<select class="form-control" id="modelFunctionCodeNew" name="function_code">
                        			@foreach ( $selectItemFunction as $key => $value)
                        				<option value="{{ $key }}">
                        					{{ $value }}
                        				</option>
                        			@endforeach
                        		</select>
                        	</div>
                    	</div>
                    	
                    	<div class="form-group row">
                        	<label class="col-sm-3 col-form-label">{{ __('messages_core_web.createable') }}</label>
                        	<div class="col-sm-3">
                        		<input class="form-check-input" type="checkbox" id="createableNew">
                        	</div>
    
                        	<label class="col-sm-3 col-form-label">{{ __('messages_core_web.deleteable') }}</label>
                        	<div class="col-sm-3">
                        		<input class="form-check-input" type="checkbox" id="deleteableNew">
                        	</div>
                        </div>
                        
                        <div class="form-group row">
                        	<label class="col-sm-3 col-form-label">{{ __('messages_core_web.readable') }}</label>
                        	<div class="col-sm-3">
                        		<input class="form-check-input" type="checkbox" id="readableNew">
                        	</div>
    
                        	<label class="col-sm-3 col-form-label">{{ __('messages_core_web.updateable') }}</label>
                        	<div class="col-sm-3">
                        		<input class="form-check-input" type="checkbox" id="updateableNew">
                        	</div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
        				<button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('messages_core_web.close') }}</button>
        				<button type="button" class="btn btn-primary" onclick="saveNewRoleFunction();">{{ __('messages_core_web.save') }}</button>
        			</div>
    			</form>
			</div>
		</div>
	</div>
    
</div>
@endsection
