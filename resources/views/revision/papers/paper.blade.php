@extends('layouts.master')
@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h4><strong>PAPER REVISION </strong> </h4><a class="btn btn-default float-right" href="/revision/paper"><i class="fa fa-arrow-circle-o-left"></i> RETURN BACK</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel">
            <div class="panel-heading">
                <h4>Evaluation</h4>
            </div>
            <div class="panel-body">
                <form method="post" class="form-horizontal" action="/revision/paper/{{$paper->id}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="event_id" value="{{$paper['paper']->event_id}}">
                    <input type="hidden" name="paper_id" value="{{$paper['paper']->paper_id}}">
                    <div class="message">
                        Please choose one of the following 3 radio buttons and write comments if available, you can also leave notes in all cases.
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Result</label>
                        <div class="col-md-9 col-xs-12">         
                            <label class="check col-md-4"><input type="radio" class="icheckbox" name="result" value="1" required="required" /> Accepted</label>
                            <label class="check col-md-4"><input type="radio" class="icheckbox" name="result" value="2" required="required" /> Accepted with comments</label>
                            <label class="check col-md-4"><input type="radio" class="icheckbox" name="result" value="3" required="required" /> Rejected</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-xs-12">Comments</label>
                        <div class="col-md-9 col-xs-12">
                            <textarea name="comments" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-xs-12">Evaluation Sheet (Accept .doc .docx)</label>
                        <div class="col-md-9 col-xs-12">
                            <input type="file" name="evaluation_sheet" accept="application/msword">
                        </div>
                    </div>
                    <hr>
                    <div class="message">
                        Please choose one of the following 3 radio buttons if you will not review this paper for any reason.
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Will not review</label>
                        <div class="col-md-9 col-xs-12">         
                            <label class="check col-md-4"><input type="radio" class="icheckbox" name="result" value="4" required="required" /> I'm busy</label>
                            <label class="check col-md-4"><input type="radio" class="icheckbox" name="result" value="5" required="required" /> Conflict of interest</label>
                            <label class="check col-md-4"><input type="radio" class="icheckbox" name="result" value="6" required="required" /> Not in my domain</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-xs-12">Notes</label>
                        <div class="col-md-9 col-xs-12">
                            <textarea name="extras" class="form-control" rows="7"></textarea>
                        </div>
                    </div>
                    <hr>
            </div>
            <div class="panel-footer">
                <div class="form-group">
                    <input type="submit" name="submit" value="Submit" class="btn btn-success pull-right">
                </div>
                <div class="clearfix"></div>
            </div>
                </form> 
        </div>

    </div>
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-heading">
                <h4>Paper Info</h4>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Title</td>
                            <td>{{ $paper['paper']->title }}</td>
                        </tr>
                        <tr>
                            <td>Code</td>
                            <td>{{ $paper['paper']->code }}</td>
                        </tr>
                        <tr>
                            <td>Expire</td>
                            <td>{{ $paper->expire }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-md-12">
                    <a class="btn btn-info btn-block" href="{{url('file/3')}}{{'/'.$paper['paper']->paper_id}}" target="_blank">DOWNLOAD PAPER</a>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-12">
                    <a class="btn btn-default btn-block" href="{{url('/evaluation-papers/evaluation-sheet.docx')}}" target="_blank">DOWNLOAD EVALUATION SHEET</a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<style rel="stylesheet" type="text/css">
    .message{
        padding: 1em;
        margin: 0.79em 0;
    }
    #comments{
        max-height:320px;
        overflow:auto;
    }
    .top10{
        padding-top: 13px;
    }
    .top13{
        padding-top: 18px;
    }
    .msg{
        box-shadow: 0px 1px 2px 0px rgba(0,0,0,0.2);
    }
    .afile{
        background:#e9e9e9;
        margin-top:-10px;
        padding:0.225em;
        box-shadow: 0px 1px 2px 0px rgba(0,0,0,0.2);
    }
    .eimg{
        border-radius: 50%;
        background: #e9e79e;
        margin-top: 10px;
        width:40px;
        text-align: center;
        vertical-align: middle;
        line-height: 18px;
        box-shadow: 0 0 0 4px rgba(0,0,0,0.05);
        height: 40px;
        font-size: 18px;
    }
    .scimg{
        border-radius: 50%;
        background: #a1e0e3;
        margin-top: 10px;
        width:40px;
        text-align: center;
        vertical-align: middle;
        line-height: 18px;
        box-shadow: 0 0 0 4px rgba(0,0,0,0.05);
        height: 40px;
        font-size: 18px;
    }
    .simg{
        border-radius: 50%;
        background: #b1e7a8;
        margin-top: 10px;
        width:40px;
        text-align: center;
        vertical-align: middle;
        line-height: 18px;
        box-shadow: 0 0 0 4px rgba(0,0,0,0.05);
        height: 40px;
        font-size: 18px;
    }
</style>
@push('scripts')

@endpush