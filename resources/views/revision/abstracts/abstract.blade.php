@extends('layouts.master')
@section('panel-title')Abstract View @endsection
@section('title') {{ $abstract->title }} @endsection
@section('content')
<div class="container">    
    <div class="row">
        <div class="col-md-12">
        	<div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Abstract Review</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <h3>Title: <small style="font-size:15px;">{{ $abstract->title }}</small></h3>
                    </div>
                    {{-- <div class="col-md-12">
                        <h3>File: <small style="font-size:15px;">{{ $abstract->file }}</small> @if($abstract->file != 'No File') <a class="btn btn-success btn-sm pull-right" onclick="window.open('{{ url('/storage/uploads/abstracts/'.$abstract->event_id.'/'.$abstract->file) }}', '_self')">Download</a> @endif</h3>
                    </div> --}}
                    <div class="col-md-12">
                        <h3>Expire Date:
                            <?php $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 5, date('Y'))); ?>
                            <small style="font-size:15px;">{{ $date }}</small>
                        </h3>
                    </div>
                    <div class="col-md-12">
                        <h3>Topic: <small style="font-size:15px;">{{ $topic }}</small></h3>
                    </div>
                    <div class="col-md-12">
                        <h3>Content: @if($abstract->abstract == '') File: <small style="font-size:15px;">{{ $abstract->file }}</small> @if($abstract->file != 'No File') <a class="btn btn-success btn-sm" onclick="window.open('{{ url('/storage/uploads/abstracts/'.$abstract->event_id.'/'.$abstract->file) }}', '_blank')">Download <i class="glyphicon glyphicon-download-alt"></i></a> @endif @endif</h3>
                    </div>
                    <div class="col-md-12"><?php echo $abstract->abstract; ?></div><div class="clear-fix"></div>
                </div>
                <div class="panel-footer" style="height: 55px">
                    <div class="col-md-12">
                        <div class="btn-group">
                            <a href="/revision/abstract/{{$abstract->abstract_id}}/accept" class="btn btn-success">Accept</a>
                            <a href="/revision/abstract/{{$abstract->abstract_id}}/reject" class="btn btn-danger">Reject</a>
                            <div class="btn-group">
                                <a style="cursor:pointer" data-toggle="dropdown" class="btn btn-default dropdown-toggle">I can't review <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="/revision/abstract/{{$abstract->abstract_id}}/reject/Busy" style="cursor:pointer">I'm busy</a></li>
                                    <li><a href="/revision/abstract/{{$abstract->abstract_id}}/reject/Conflict-of-interest" style="cursor:pointer">Conflict of interest</a></li>
                                    <li><a href="/revision/abstract/{{$abstract->abstract_id}}/reject/Not-in-my-domain" style="cursor:pointer">Not in my domain</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('table').each(function(){
                $(this).addClass('table');
                $(this).addClass('table-striped');
                $(this).addClass('table-hover');
                $(this).addClass('table-bordered');
                $(this).addClass('table-condensed');
            })
        })
    </script>
@endpush
