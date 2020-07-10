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
                <div class="card-header">{{ __('messages_core_web.newRole') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('role.create') }}">
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
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.name') }} *</label>
                        	
                        	<div class="col-sm-4">
                        		<input type="text" class="form-control" name="name">
                        	</div>
                        	
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.sortOrder') }} *</label>
                        	<div class="col-sm-4">
                        		<input type="number" class="form-control" name="sort_order">
                        	</div>
                        </div>
                        
                        <div class="form-group row">
                        	
                        </div>
                        
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">{{ __('messages_core_web.description') }} *</label>
                        	<div class="col-sm-6">
                        		<textarea rows="" cols="" class="form-control" name="description"></textarea>
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
