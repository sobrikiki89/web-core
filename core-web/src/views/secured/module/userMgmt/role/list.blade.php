@extends('layouts.secured')

@section('content')

<script type="text/javascript">

function renderRoleListing(){
	$.ajax({
		type : "POST",
		url : "{{ route('role.grid') }}",
		data : {
			
				},
		dataType : 'json',
		success : function(respond) {
						markup = '';
    					$.each(respond.data, function (i, item){
    						markup += '<tr>';
    						markup += '<th scope="row">'+(i+1)+'</th>';
    						markup += '<td>'+item.name+'</td>';
							markup += '<td>'+item.description+'</td>';
							markup += '<td>'+item.sort_order+'</td>';
							var url = '{{ route("role.read", ":id") }}';
							url = url.replace(':id', item.id);							
							markup += '<td><a href="'+url+'">{{ __('messages_core_web.edit') }}</a></td>';
							markup += '</tr>';
    					});

						$("#tbodyListRole").append(markup);
    					
					},
		error : function(request, status, error) {
							$("#tbodyListRole").append('<span class="alert alert-danger" role="alert">Error...</span>');
					},
	});
}

$(document).ready(function(){
	renderRoleListing();
});
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                	<div class="row">
                		<div class="col-md-10" style="vertical-align: middle;">
                				{{ __('messages_core_web.roleListing') }}
                		</div>
                		<div class="col-md-2 float-right">
                			<a type="button" class="btn btn-primary btn-sm float-right" href="{{ route('role.new') }}">{{ __('messages_core_web.new') }}</a>
                		</div>
                	</div>                	
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
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
                            <table class="table">
                                <thead>
                                    <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">{{ __('messages_core_web.name') }}</th>
                                      <th scope="col">{{ __('messages_core_web.description') }}</th>
                                      <th scope="col">{{ __('messages_core_web.sortOrder') }}</th>
                                      <th scope="col">{{ __('messages_core_web.edit') }}</th>
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
</div>
@endsection
