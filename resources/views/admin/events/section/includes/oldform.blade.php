@include('errors.list')

<div class="row">
    <div class="col-md-12">

        <div class="panel">
            <div class="col-md-10 panel-body form-group">

                {!! Form::hidden('position', null) !!}
                {!! Form::hidden('section_id', @$section['section_id']) !!}
                {!! Form::hidden('event_id', Session::get('event_id', null)) !!}

                <div class="form-group">
                    <label class="col-md-3 col-xs-12">
                    {!! Form::label('section_type', 'Section Type') !!}
                    </label>
                    <div class="input-group col-md-8 col-xs-12">
                        {!! Form::select('section_type_id', $arrSectionTypes, @$section['section_type_id'], [
                        'placeholder' => 'Select',
                         'class' => 'select']) !!}
                    </div>
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
                <div class="form-group">
                    <label class="col-md-3 col-xs-12">
                    {!! Form::label('description_en', 'Section Description English') !!}
                    </label>
                    <div class="col-md-8 col-xs-12">
                    {!! Form::textarea('description_en', @$section['description_en'], [
                    'class' => 'form-control summernote_email',
                    'name'  => 'description_en'
                    ]) !!}
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>   
<div class="col-md-12">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-success pull-right', 'id' => 'submit']) !!}
</div>
