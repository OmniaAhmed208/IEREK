@extends('admin.layouts.master') 
@section('return-url'){{route('indexVideo')}}@endsection
@section('panel-title')Create New Video Image @endsection @section('content')
<!-- PAGE CONTENT WRAPPER -->

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
           <form class="form-horizontal" enctype="multipart/form-data" method="post" action="/admin/pages/home/partners/store">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="post">
                <div class="panel panel-default">
                    <div class="panel-body tab-content">
                        <div class="tab-pane fade in active" id="tab-General">
                            <p>Fill in Video Image Information.</p>
                            <p>Fields with <span class="redl">*</span> is required.</p>
                            

                       
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Image</label>
                                <div class="col-md-6 col-xs-12">                                                
                                  <input  type="file" class="form-control" name="images[]" placeholder="address" multiple>
                                </div>
                            </div>

                        </div>
                      
                        </div>
                       
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-default pull-right" id="create">Create<span class="fa fa-floppy-o fa-right"></span></button>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


@endsection
