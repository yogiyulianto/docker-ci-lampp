
@if(session("error") !== NULL )
<div class="alert alert-danger alert-bold" role="alert">
	<div class="alert-text"><strong><i class="la la-exclamation-triangle"></i> Error</strong>, {{session("error")}}</div>
</div>
@elseif (session("success")!== NULL) 
<div class="alert alert-success alert-bold" role="alert">
	<div class="alert-text"><strong><i class="la la-check "></i> Success</strong>, {{session("success")}}</div>
</div>
@endif
