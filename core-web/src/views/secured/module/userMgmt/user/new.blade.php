@extends('layouts.secured')

@section('content')

<script type="text/javascript">

$(document).ready(function(){
});
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('messages_core_web.newUser') }}</div>

                <div class="card-body">
                    <form id="formUserInfo" method="POST" action="{{ route('userInfo.create') }}">
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
                        
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.staffNo') }} *</label>
                        	
                        	<div class="col-sm-2">
                        		<input id="staffIDId" onchange="renderInfoStaff(this);" type="text" class="form-control" name="staff_no"  value="{{old('staff_no')}}">
                        	</div>
                        </div>
                        
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.name') }} *</label>
                        	
                        	<div class="col-sm-4">
                        		<input type="text" id="staffNameId" class="form-control" name="name" readonly="readonly">
                        	</div>
                        </div>
                        
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.department') }} *</label>
                        	
                        	<div class="col-sm-4">
                        		<input type="text" id="departmentId" class="form-control" name="department" readonly="readonly">
                        	</div>
                        	
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.designation') }} *</label>
                        	
                        	<div class="col-sm-4">
                        		<input type="text" id="designationId" class="form-control" name="designation" readonly="readonly">
                        	</div>
                        </div>
                        
                         <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.email') }} *</label>
                        	
                        	<div class="col-sm-4">
                        		<input type="text" id="emailId" class="form-control" name="email" readonly="readonly">
                        	</div>
                        	
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.role') }} *</label>

                        	<div class="col-sm-4">
                        		<select class="form-control" name="role_id" id="roleId" value="{{old('role_id')}}">
        							<option value="">{{ __('messages_core_web.select') }}</option>
                                    @foreach ( $selectItemRole as $key => $value)
                                        <option value="{{ $key }}" {{ old('role_id') == $key ? ' selected' : '' }}> 
                                            {{ $value }} 
                                        </option>
                                    @endforeach 
        						</select>
                        	</div>
                        </div>
                        
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.sessionTimeout') }} *</label>
                        	
                        	<div class="col-sm-4">
                        		<input type="number" id="departmentId" class="form-control col-sm-3" name="session_timeout"  value="{{old('session_timeout')}}">
                        	</div>
                        	
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.active') }}</label>
                        	
                        	<div class="col-sm-4">
                        		<input type="checkbox" id="designationId" class="form-check-input" name="active">
                        	</div>
                        </div>
                        
                         <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.maxInvalidLoginAttempt') }} *</label>
                        	
                        	<div class="col-sm-4">
                        		<input type="number" id="designationId" class="form-control col-sm-3" name="max_count_login"  value="{{old('max_count_login')}}">
                        	</div>
                        	
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.invalidLoginAttempt') }} *</label>
                        	
                        	<div class="col-sm-4">
                        		<input type="number" id="departmentId" class="form-control col-sm-3" name="invalid_count_login"  value="{{old('invalid_count_login')}}">
                        	</div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('messages_core_web.save')}}</button>
                    	<a class="btn btn-primary" href="{{ url()->previous() }}">{{ __('messages_core_web.back')}}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

function renderInfoStaff(sel){
	
	populateInfoStaff(sel.value);
}

function populateInfoStaff(dataStaffId){

	$('#staffIDId').removeClass('is-invalid');
    $('#staffIDId').parent().children('.invalid-feedback').remove();
    
	if(dataStaffId !== ''){
		//$('#staffIDId').parent().addClass("kt-spinner kt-spinner--sm kt-spinner--success kt-spinner--right kt-spinner--input");
				
		$.ajax({
	        type: "POST",
	        url: "{{ route('common.infoStaff') }}",
	        data: { 
	        		staffId:dataStaffId
	            	}, 
	        dataType: 'json',
	        success: function(respond) {
		        $('#staffNameId').val(respond.data.title +' '+ respond.data.name);
	        	$('#departmentId').val(respond.data.department);
	        	$('#designationId').val(respond.data.designation);
	        	$('#contactNoId').val(respond.data.contactNo);
	        	$('#emailId').val(respond.data.email);
	        },
	        error: function(request, status, error) {
	        	//$('#staffIDId').parent().removeClass("kt-spinner kt-spinner--sm kt-spinner--success kt-spinner--right kt-spinner--input"); 
	        	
	        	console.log('ERROR');
	            var json = $.parseJSON(request.responseText);
	            $.each(json.errors, function(key, value){
	            	$('#staffIDId').addClass("is-invalid");
	                $('#staffIDId').parent().append("<div class='invalid-feedback'>"+value+"</div>");
	            });

	            $('#staffNameId').val('');
	        	$('#departmentId').val('');
	        	$('#designationId').val('');
	        	$('#contactNoId').val('');
	        	$('#emailId').val('');           	
	        	
	        }
	    });
	}
}


jQuery(document).ready(function() {
	if($('#staffIDId').val() !== ''){
		populateInfoStaff($('#staffIDId').val());
	}	
});

</script>
@endsection
