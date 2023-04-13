@extends('admin.layouts.master')

@section('panel-title')Update Announcement picture
@endsection
@section('content')




<!-- PAGE CONTENT WRAPPER -->

<div class="page-content-wrap">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="row">
        <div class="col-md-12">

            <form  enctype="multipart/form-data" method="post" action="/admin/pages/home/announcement/store">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="post">
                <div class="panel panel-default">                            
                    <div class="panel-body tab-content">
                     <div class="form-group">
							<label class="col-md-4 control-label">Announcement Image</label>
							<div class="col-md-8">
								<img id="image-view" class="img-responsive img-thumbnail" src="{{asset('/storage/uploads/announcement/'.'announcementImage.jpeg')}}" style="max-height:120px;max-width:100px;border:1px #a97f18 solid;margin-bottom:10px;">
								<input type="file"  name="image" >
								
							</div>
						</div>
                    </div>
                    <div class="panel-footer">                                                                        
                        <button class="btn btn-default pull-right" id="update">Update<span class="fa fa-floppy-o fa-right"></span></button>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
                    </div>
                </div>                                
            
            </form>
            
        </div>

    </div>                    

    </div>
</div>

<!-- END PAGE CONTENT WRAPPER -->     
@endsection

