<!-- PAGE CONTENT WRAPPER -->
{!! Form::open(['name' => 'frm_create_section', 'route' => 'storeSection']) !!}
    @include('admin.events.section.includes.oldform',
    ['submitButtonText'  => 'Add Section'
    ])
{!! Form::close() !!}