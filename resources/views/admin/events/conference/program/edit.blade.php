@extends('admin.layouts.master')
@section('return-url'){{route('showConferenceFees', $event_id)}}@endsection
@section('panel-title')Update Conference Fees <small>{{ $event }}</small>
@endsection
@section('content')
<script type="text/javascript" charset="utf-8" async defer>
$(document).ready( function() {
    $('#update').on('click', function(event) {
             console.log("ok event");
        });
    });

  
</script>
<!-- PAGE CONTENT WRAPPER -->

<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('editConferenceProgram', $event_id) }}" id="update_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="post">
                <input type="hidden" name="event_id" value="{{ $event_id }}">
                <div class="panel panel-default">
                    <div class="panel-body tab-content">
                        <div class="tab-pane fade in active" id="tab-General">
                            <p>Fill in conference fees information.</p>
                            <p>Fields with <span class="redl">*</span> is required.</p>
                            <div class="form-group" id="title_en">
                                <label class="col-md-3 col-xs-12 control-label">Title</label>
                                <div class="col-md-7 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">En <span class="redl">*</span></span>
                                        <input type="text" name="title_en" id="title_en_input" class="form-control" />
                                    </div>
                                    <label id="title_en_err" class="help-block redl"></label>
                                </div>
                            </div>
                        
                            <div  id="tab-downloads">
                            <p>Conference program Downloads.</p>
                            
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Existing Conference program</label>
                                <div class="col-md-6 col-xs-12">
                                    <a href="{{url('/storage/uploads/conferences/')}}" target="_blank">Download</a>
                                </div>
                            </div>
                                 <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">upload conference program</label>
                                <div class="col-md-6 col-xs-12">                                                
                                    <input type="file" class="image_file" name="evaluation_sheet" id="evaluation_sheet" class="form-control" />
                                </div>
                            </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-3"></label>
                                <label class="help-block col-md-7"></label>
                            </div>
                        </div>
                        <div id="success" class="alert alert-success" style="margin-top:1em; display:none;">
                            <span><strong id="welcome">Conference Fees created successfully !</strong> </span>
                        </div>
                        <div id="alert" class="alert alert-danger" style="margin-top:1em; display:none;">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <span></span>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-default pull-right" id="update">update<span class="fa fa-floppy-o fa-right"></span></button>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
                    </div>
                </div>
            </form>
            
        </div>
    </div>                    
 
</div>
<!-- END PAGE CONTENT WRAPPER -->     

@endsection

