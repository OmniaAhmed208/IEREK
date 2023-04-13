<!-- PAGE CONTENT WRAPPER -->
{!! Form::open(['name' => 'frm_create_topic', 'route' => 'storeConferenceTopics']) !!}
    @include('admin.events.conference.topics.includes.form', 
    ['submitButtonText'  => 'Add new topic'
    ])
{!! Form::close() !!}
