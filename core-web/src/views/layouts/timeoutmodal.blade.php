<!doctype html>

<script type="text/javascript">

	var notifyId;
	var logOutId;

    function loadTimeoutDialog() {
        var sessionAlive = {{ Session::get('session_timeout') }};
        var notifyBefore = 30; // beri masa kepada pengguna selama 30 saat(seconds) untuk memilih.
        notifyId = setTimeout(function() {
            $(function() {
                $( "#timeoutDialog" ).modal();
            });
        }, (sessionAlive - notifyBefore) * 1000);

        logOutId = setTimeout(function() {
            $(function() {
            	window.location.replace("{{ route('get.logout') }}");
            });
        }, (sessionAlive) * 1000);
    };

    $("#keepAliveSession").click(function() {
        clearTimeout(notifyId);
        clearTimeout(logOutId);
        loadTimeoutDialog();
        /*
        $.ajax({
            type : "GET",
            contentType : "application/json",
            url : "{{ route('secured.home') }}",
            data : '',
            dataType : 'json',
            timeout : 100000,
            success : function(data) {
                loadTimeoutDialog();
            },
            error : function(e) {
                window.location.replace("{{ route('login') }}");
            },
            done : function(e) {
            }
        });
        */
    });
    
    $(document).ready(function() {    
		loadTimeoutDialog();
    });
</script>
    

<div id="timeoutDialog" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4>
					{{ __('messages_core_web.sessionTimeoutHeader') }}
				</h4>
			</div>

			<div class="modal-body">
				<div class="panel-body">
					<div class="form-group row">
						<span class="col-sm-1"></span>
						<span class="col-sm-10">
							{{ __('messages_core_web.sessionTimeoutBody') }}
						</span>
					</div>
					
					<div class="form-group row">
						<span class="col-sm-1"></span>
						<span class="col-sm-10 text-center">
							<button id="keepAliveSession" type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">
								{{ __('messages_core_web.submit') }}				
							</button>
							<button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">
								{{ __('messages_core_web.close') }}							
							</button>							
						</span>
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>
    