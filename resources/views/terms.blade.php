@extends('layouts.master')
@section('content')   
<div id="content" class="container site-content container">

	
	<div class="framed-box">
		<div class="frame-title">Terms &amp; Conditions</div>
			<div class="framed-content">
			
			<?php echo $content->content; ?>			

			</div>
		</div>
	</div>
@endsection