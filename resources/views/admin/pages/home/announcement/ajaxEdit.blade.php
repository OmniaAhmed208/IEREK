<!-- PAGE CONTENT WRAPPER -->
<div class="panel">

    <div class="panel-body">

                    <div class="panel panel-default">

                        <div class="panel-body section" id="sort-announcement">

                            @if(count($announcements) > 0)
                                @foreach($announcements as $announcement)
                                
                                <div class="section-item" style="cursor:move" id="announcement_item_{{$announcement->announce_id}}">

                        <div class="section-title">
                            <i class="fa fa-align-justify"></i><span>{{ $announcement->announce_position }}. </span>
                            <span class="section_title_text">{{$announcement->announce_url}}</span>
                            <input type="hidden" name="announce_id" value="{{ $announcement->announce_id }}">
                        </div>
                    </div>
                @endforeach

                            @else
                                <div class="alert alert-warning" role="alert">No announcements Were Found</div>
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