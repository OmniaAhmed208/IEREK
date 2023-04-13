@extends('layouts.master')
@section('content')
<div id="CONDETAILP">
	<div class="container">
		<div class="col-md-12 order">
			<div class="panel">
				<div class="panel-heading">
					<h4>FULL PAPERS REVISION REQUESTS</h4>
				</div>
				<div class="panel-body" id="">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Title</th>
								<th>Code</th>
								<th>Expire In</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($papers as $paper)
							<?php 
								$expire = $paper->expire;
								$str = strtotime(date("Y-m-d")) - (strtotime($expire));
								$diff = floor(($str/3600/24) * -1 );
							?>
							<tr class="@if($diff < -5) danger @elseif($diff < 0 && $diff > -5) warning @elseif($diff < 5 && $diff > 0) success @endif">
								<td>{{ $paper['paper']->title }}</td>
								<td>{{ $paper['paper']->code }}</td>
								<td>@if($diff < 0) {{'Expired '}}<small>({{ $diff }} days)</small> @else {{ $diff }} Days <small>({{ date('d M, Y', strtotime(@$expire)) }})@endif</small></td>
								<td><a href="/revision/paper/{{ $paper->id }}/view" class="btn btn-sm btn-success">View</a>
							</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style type="text/css">
	.btn-defaultx{
		background:#0c3852!important;
		color:#fff!important;
		cursor: pointer;
		transition: 0.3s;
	}
	.btn-defaultx:hover{
		background:#a97f18!important;
		color:#000;
	}
	.evgo{
		float: right;
		margin-right: 10px;
		margin-top: -30px;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
    function windowOpen(url){
        window.open (url,"mywin","resizable=0,width=1024");
    }
    $(document).ready(function(){
        @if(Session::has('close'))
            window.close();
        @endif
    });
</script>
@endpush