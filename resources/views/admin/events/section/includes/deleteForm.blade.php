{!! Form::open([
    'method' => 'DELETE',
    'name' => 'frm_delete_section',
    'route' => ['deleteSection', $section_id]]) !!}

    {!! Form::button( 'Delete<i class="fa fa-trash fa-lg"></i>', ['type' => 'submit',
    'class' => 'btn btn-default btn-block delete_section','style' => 'border:none!important;border-radius:0px;text-align:left;color:red', 'data-id' => $section_id] ) !!}
{!! Form::close() !!}