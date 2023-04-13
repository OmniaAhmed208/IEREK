@extends('admin.layouts.window')

@section('content')
<table class="table table-striped table-bordered table-hover" style="background:#fff">
	<tbody>
		@isset($data->application)
			
			@php
				$app = json_decode($data->application,true);
			@endphp
			@foreach($app as $key => $value)
				<tr>
					<td><strong>{{ $key }}</strong></td>
					<td>{{ $value }}</td>
				</tr>
			@endforeach
		@endisset
	</tbody>
</table>
<pre>
</pre>
@endsection