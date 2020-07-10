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
                <div class="card-header">{{ __('messages_core_web.editMenuItem') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('menuMgmt.update') }}">
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
                        
                        <input type="hidden" name="id" value="{{$menuItem->id}}">
                        
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.name') }} *</label>
                        	
                        	<div class="col-sm-4">
                        		<input type="text" class="form-control" name="name" value="{{$menuItem->name}}">
                        	</div>
                        	
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.sortOrder') }} *</label>
                        	<div class="col-sm-4">
                        		<input type="number" class="form-control" name="sort_order" value="{{$menuItem->sort_order}}">
                        	</div>
                        </div>
                        
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.description') }} *</label>
                        	<div class="col-sm-6">
                        		<textarea rows="" cols="" class="form-control" name="description">{{$menuItem->description}}</textarea>
                        	</div>
                        </div>
                        
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.function') }}</label>
                        	
                        	<div class="col-sm-4">
                        		<select class="form-control" id="functionCode" name="function_code" value="{{$menuItem->function_code}}">
                        			<option value="">{{ __('messages_core_web.select') }}</option>
                        			@foreach ( $selectItemFunction as $key => $value)
                        				<option {{ $menuItem->function_code == $key ? 'selected="selected"' : ''  }}  value="{{ $key }}">
                        					{{ $value }}
                        				</option>
                        			@endforeach
                        		</select>
                        	</div>
                        	
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.parent') }}</label>
                        	
                        	<div class="col-sm-4">
                        		<select class="form-control" id="parentId" name="parent_id" value="{{$menuItem->parent_id}}">
                        			<option value="">{{ __('messages_core_web.select') }}</option>
                        			@foreach ( $selectItemMenuItemParent as $key => $value)
                        				<option {{ $menuItem->parent_id == $key ? 'selected="selected"' : ''  }} value="{{ $key }}">
                        					{{ $value }}
                        				</option>
                        			@endforeach
                        		</select>
                        	</div>
                    	</div>
                    	
                    	<div class="form-group row">
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.parentFlag') }}</label>
                        	<div class="col-sm-2">
                        		<input class="form-check-input" type="checkbox" id="parentFlag" name="parent_flag" {{ $menuItem->parent_flag  ? 'checked="checked"' : '' }} >
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
@endsection
