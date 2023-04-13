<!-- PAGE CONTENT WRAPPER -->
<div class="panel">

        <div class="panel-body section" id="sort-section">

            @if(count($sections) > 0)
                @foreach($sections as $section)
                    <div class="section-item" style="cursor:move" id="section_item_{{$section->section_id}}">

                        <div class="section-title">
                            <i class="fa fa-align-justify"></i><span>{{ $section->position }}. </span>
                            <span class="section_title_text">{{$section->title_en}}</span>
                            <input type="hidden" name="section_id" value="{{ $section->section_id }}">
                        </div>
                    </div>
                @endforeach

            @else
                <div class="alert alert-warning" role="alert">No sections found</div>
            @endif

        </div>
    <div class="panel-footer">
        <div class="col-md-4 pull-right">
            <div class="btn-group dropup" style="float:right">
                <a style="cursor:pointer" onclick="ajaxChangePosition();" class="btn btn-primary">
                    Save
                </a>
            </div>
        </div>
    </div>


</div>

<hr>

<!--start Hidden html-->

<!--end hidden html-->

<!-- END PAGE CONTENT WRAPPER -->