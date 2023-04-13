@include('errors.list')

<div class="row">
    <div class="col-md-12">

        <div class="col-md-10 col-xs-12 panel-body form-group">

            {!! Form::hidden('position', null) !!}
            {!! Form::hidden('topic_id', null) !!}
            {!! Form::hidden('event_id', Session::get('event_id', null)) !!}
            <div class="form-group">
                <label class="col-md-3 col-xs-12">    
                    {!! Form::label('title_en', 'Topic') !!}
                </label>
                <div class="col-md-8 col-xs-12 input-group">
                    <span class="input-group-addon">En</span>
                    <!--<input name="topic_title[]" class="form-control" placeholder="Enter topic title">-->
                    <!--<br>-->
                    {!! Form::text('title_en', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Enter topic title'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-xs-12">
                    {!! Form::label('description_en', 'Topic Description') !!}
                </label>
                <div class="form-group col-md-8 col-xs-12"> 
                {!! Form::textarea('description_en', null, [
                'class' => 'form-control textarea'
                ]) !!}
                </div>
            </div>
            <hr>
        </div>

    </div>
</div>   
<div class="col-md-12">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-success pull-right', 'id' => 'submit']) !!}
</div>