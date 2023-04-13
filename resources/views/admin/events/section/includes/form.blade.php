@include('errors.list')
<style>
    .form-group-container {
        display: flex;
        flex-flow: column;
    }

    #overview .form-group, #conference-fees .form-group, #scientific_committee .form-group, #for-authors .form-group {
        min-height: 400px;
        height: 100%;
        border-bottom: 2px solid lightgrey;
    }

    #overview .form-group.conference-topics, #conference-fees .form-group.conference-topics, #scientific_committee .form-group.conference-topics, #for-authors .form-group.conference-topics {
        height: 50px;
        min-height: 50px;
    }

    #conference-fees .form-group.conference-topics {
        border-top: 2px solid lightgrey;
        padding: 14px 10px;
    }
</style>
<div class="row">
    <div class="col-md-12">

        <div class="panel">
            <div class="col-md-10 panel-body form-group form-group-container">

                {!! Form::hidden('position', null) !!}
                {!! Form::hidden('section_id', @$section['section_id']) !!}
                {!! Form::hidden('event_id', Session::get('event_id', null)) !!}
                <input type="hidden" id="section_type" value="<?= @$section['section_type_id'];?>"/>
                <div class="form-group">
                    {!! Form::hidden('section_type_id', @$section['section_type_id']) !!}
                    @if ($errors->has('section_type_id'))
                        <p class="help-block alert alert-danger">{{ $errors->first('section_type_id') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label class="col-md-3 col-xs-12">
                        {!! Form::label('title_en', 'Section English') !!}
                    </label>
                    <div class="input-group col-md-8 col-xs-12">
                        <span class="input-group-addon">En</span>

                        {!! Form::text('title_en', @$section['title_en'], [
                        'class' => 'form-control',
                        'placeholder' => 'Enter English section title'
                        ]) !!}
                    </div>
                    @if ($errors->has('title_en'))
                        <p class="help-block alert alert-danger">{{ $errors->first('title_en') }}</p>
                    @endif


                </div>
                
                <?php
                if (@$section['section_type_id'] == 11) {
                    $overview_data = explode("&$#and#$&", @$section['description_en']);

                }
                ?>
                <div id="overview" style="display: none">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12">
                            {!! Form::label('description_en', 'Intro') !!}
                        </label>
                        <div class="col-12 col-md-8">
                            {!! Form::textarea('intro',(empty($overview_data[0]) ? null : $overview_data[0]), [
                            'class' => 'form-control summernote_email',
                            'name'  => 'intro'
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group conference-topics">
                        <a target="_blank" href="{{ route('showConferenceTopics', Session::get('event_id', null)) }}">Conference
                            Topics</a>
                    </div>
                    
                     <div class="form-group">
                        <label class="col-md-3 col-xs-12">
                            {!! Form::label('description_en', 'Partner universities') !!}
                        </label>
                        <div class="col-md-8 col-xs-12">
                            {!! Form::textarea('partner_units',(empty($overview_data[1]) ? null : $overview_data[1]), [
                            'class' => 'form-control summernote_email',
                            'name'  => 'partner_units'
                            ]) !!}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12">
                            {!! Form::label('description_en', 'Venue') !!}
                        </label>
                        <div class="col-md-8 col-xs-12">
                            {!! Form::textarea('venue',(empty($overview_data[2]) ? null : $overview_data[2]), [
                            'class' => 'form-control summernote_email',
                            'name'  => 'venue'
                            ]) !!}
                        </div>
                    </div>
                   
                    
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12">
                            {!! Form::label('description_en', 'Activities') !!}
                        </label>
                        <div class="col-md-8 col-xs-12">
                            {!! Form::textarea('activities',(empty($overview_data[3]) ? null : $overview_data[3]), [
                            'class' => 'form-control summernote_email',
                            'name'  => 'activities'
                            ]) !!}
                        </div>
                    </div>
                </div>


                <?php
                if (@$section['section_type_id'] == 12) {
                    $fees_data = explode("&$#and#$&", @$section['description_en']);

                }
                ?>
                <div id="conference-fees" style="display: none">
                    <div class="form-group conference-topics">
                        <a target="_blank" href="{{ route('showConferenceFees', Session::get('event_id', null)) }}">Conference
                            fees</a>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12">
                            {!! Form::label('description_en', 'fees') !!}
                        </label>
                        <div class="col-md-8 col-xs-12">
                            {!! Form::textarea('visa',(empty($fees_data[2]) ? null : $fees_data[2]), [
                            'class' => 'form-control summernote_email',
                            'name'  => 'fees'
                            ]) !!}
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="col-md-3 col-xs-12">
                            {!! Form::label('description_en', 'visa') !!}
                        </label>
                        <div class="col-md-8 col-xs-12">
                            {!! Form::textarea('visa',(empty($fees_data[1]) ? null : $fees_data[1]), [
                            'class' => 'form-control summernote_email',
                            'name'  => 'visa'
                            ]) !!}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12">
                            {!! Form::label('description_en', 'refund policy') !!}
                        </label>
                        <div class="col-md-8 col-xs-12">
                            {!! Form::textarea('refund_policy',(empty($fees_data[1]) ? null : $fees_data[0]), [
                            'class' => 'form-control summernote_email',
                            'name'  => 'refund_policy'
                            ]) !!}
                        </div>
                    </div>
                    
                    

                </div>
                <?php
                if (@$section['section_type_id'] == 13) {
                    $scientific_data = explode("&$#and#$&", @$section['description_en']);

                }
                ?>
                <div id="scientific_committee" style="display: none">

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12">
                            {!! Form::label('description_en', 'keynote speakers') !!}
                        </label>
                        <div class="col-md-8 col-xs-12">
                            {!! Form::textarea('speakers', (empty($scientific_data[0]) ? null : $scientific_data[0]), [
                            'class' => 'form-control summernote_email',
                            'name'  => 'speakers'
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12">
                            {!! Form::label('description_en', 'Advisory Abroad') !!}
                        </label>
                        <div class="col-md-8 col-xs-12">
                            {!! Form::textarea('advisory_abroad', (empty($scientific_data[1]) ? null : $scientific_data[1]), [
                            'class' => 'form-control summernote_email',
                            'name'  => 'advisory_abroad'
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <a target="_blank"
                           href="{{ route('showConferenceSCommittee', Session::get('event_id', null)) }}">Scientific
                            committe
                        </a>
                    </div>
                </div>
                <?php
                if (@$section['section_type_id'] == 14) {
                    $authors_data = explode("&$#and#$&", @$section['description_en']);

                }
                ?>
                <div id="for-authors" style="display: none">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12">
                            {!! Form::label('description_en', 'Author Instructions') !!}
                        </label>
                        <div class="col-md-8 col-xs-12">
                            {!! Form::textarea('author_instructions',(empty($authors_data[0]) ? null : $authors_data[0]), [
                            'class' => 'form-control summernote_email',
                            'name'  => 'author_instructions'
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12">
                            {!! Form::label('description_en', 'Participation Procedures') !!}
                        </label>
                        <div class="col-md-8 col-xs-12">
                            {!! Form::textarea('participation_procedures',(empty($authors_data[1]) ? null : $authors_data[1]), [
                            'class' => 'form-control summernote_email',
                            'name'  => 'participation_procedures'
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12">
                            {!! Form::label('description_en', 'Plagiarism Policy') !!}
                        </label>
                        <div class="col-md-8 col-xs-12">
                            {!! Form::textarea('plagiarism_policy',(empty($authors_data[2]) ? null : $authors_data[2]), [
                            'class' => 'form-control summernote_email',
                            'name'  => 'plagiarism_policy'
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12">
                            {!! Form::label('description_en', 'Publishing') !!}
                        </label>
                        <div class="col-md-8 col-xs-12">
                            {!! Form::textarea('publishing',(empty($authors_data[3]) ? null : $authors_data[3]), [
                            'class' => 'form-control summernote_email',
                            'name'  => 'publishing'
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12">
                            {!! Form::label('description_en', 'English Editing') !!}
                        </label>
                        <div class="col-md-8 col-xs-12">
                            {!! Form::textarea('english_editing',(empty($authors_data[4]) ? null : $authors_data[4]), [
                            'class' => 'form-control summernote_email',
                            'name'  => 'english_editing'
                            ]) !!}
                        </div>
                    </div>
                </div>
                
                <?php
                if (@$section['section_type_id'] == 15) {
                    $program_data = explode("&$#and#$&", @$section['description_en']);

                }
                ?> 
                <div id="conference-program" style="display: none">
                    
                 <div class="form-group">
                        <label class="col-md-3 col-xs-12">
                            {!! Form::label('description_en', 'conference program') !!}
                        </label>
                        <div class="col-md-8 col-xs-12">
                            {!! Form::textarea('conference_program',(empty($program_data[0]) ? null : $program_data[0]), [
                            'class' => 'form-control summernote_email',
                            'name'  => 'conference_program'
                            ]) !!}
                        </div>
                    </div>
                
            </div>
            </div>

        </div>

    </div>
</div>
<div class="col-md-12">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-success pull-right', 'id' => 'submit']) !!}
</div>
<script>
    $(document).ready(function () {
        var type = $('#section_type').val();
        if (type == 11) {
            $('#overview').show();
        }

        if (type == 12) {
            $('#conference-fees').show();
        }

        if (type == 13) {
            $('#scientific_committee').show();
        }

        if (type == 14) {
            $('#for-authors').show();
        }
        
         if (type == 15) {
            $('#conference-program').show();
        }


    });
</script>