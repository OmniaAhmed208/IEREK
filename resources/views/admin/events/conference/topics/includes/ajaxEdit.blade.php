<!-- PAGE CONTENT WRAPPER -->
<div class="panel">

    <div class="panel-body">

                    <div class="panel panel-default">

                        <div class="panel-body section" id="sort-topic">

                            @if(count($topics) > 0)
                                @foreach($topics as $topic)
                                
                                <div class="section-item" style="cursor:move" id="topic_item_{{$topic->topic_id}}">

                        <div class="section-title">
                            <i class="fa fa-align-justify"></i><span>{{ $topic->position }}. </span>
                            <span class="section_title_text">{{$topic->title_en}}</span>
                            <input type="hidden" name="topic_id" value="{{ $topic->topic_id }}">
                        </div>
                    </div>
                @endforeach

                            @else
                                <div class="alert alert-warning" role="alert">No Topics Were Found</div>
                            @endif

                        </div>
                    </div>
    </div>
    <div class="panel-footer">
        <div class="col-md-4 pull-right">
            <div class="btn-group dropup" style="float:right">
                <a style="cursor:pointer"  onclick="ajaxChangePosition();" class="btn btn-primary">
                    Save
                </a>
            </div>
        </div>
    </div>


</div>

<hr>

<!-- END PAGE CONTENT WRAPPER -->