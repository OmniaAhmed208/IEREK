@extends('admin.layouts.master')
@section('panel-title')Manage Conferences 
@endsection
@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        	<div class="panel panel-default">
                <div class="panel-body">
            		<div class="col-md-6">
                        <form method="get">
                            Filter <label class="col-m-6 col-offset-md-4">
                            <select name="deleted" id="filter" class="form-control">
                                <option value="active-only" @if(@$select == 'active-only') {{ 'selected' }} @endif >Acitve Only</option>
                                <option value="inactive-only" @if(@$select == 'inactive-only') {{ 'selected' }} @endif >Inactive Only</option>
                                <option value="all" @if(@$select == 'all') {{ 'selected' }} @endif>All</option>
                            </select>
                            </label>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
                        </form>
                    </div>
                    <table class="table table-hover table-striped datatable">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Year</th>
                                <th>Start Date</th>
                                <th>Options</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                                @if($conferences)
                                    @foreach($conferences as $conference)
                                       
                                        <tr id="event{{ $conference->event_id }}" class="inactive">
                                            <td>{{ $conference->title_en }}</td>
                                            <td>{{ $conference->sub_category['title'] }}</td>
                                            <td>{{ date("Y-m-d", strtotime($conference->start_date) ) }}</td>
                                            
                                            <td>
                                            @if($conference->deleted == 1 && @$select == 'all')
                                                <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Conference Is Inactive">I</span>
                                            @endif
                                            @if($conference->deleted == 0 && @$select == 'all')
                                                <span class="label label-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Conference Is Active">A</span>
                                            @endif
                                            @if($conference->publish == 1)
                                                <span class="label label-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Is Published">P</span>
                                            @endif
                                            @if($conference->fullpaper == 1)
                                                <span class="label label-default" data-toggle="tooltip" data-placement="top" title="" data-original-title="Full Paper Is Open">F</span>
                                            @endif
                                            @if($conference->submission == 1)
                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="Submission Is Closed">S</span>
                                            @endif
                                            @if($conference->egy == 1)
                                                <span class="label label-primary"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Egyptian Fees Enabled">E</span>
                                            @endif
                                            </td>
                                            <td>
                                                <!--<a class="btn btn-default" href="/admin/events/conference/attendance/{{ $conference->event_id }}">Audience</a>
                                                <a class="btn btn-default" href="/admin/events/conference/submission/{{ $conference->event_id }}">Submission</a>-->
                                                <div class="btn-group">
                                                    <a style="cursor:pointer" data-toggle="dropdown" class="btn btn-info dropdown-toggle">Participants <span class="caret"></span></a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a target="_blank" href="/admin/events/conference/registeredEmails/{{ $conference->event_id }}" style="cursor:pointer">Registeration users' emails</a></li>
                                                        <li><a target="_blank" href="/admin/events/conference/attendance/{{ $conference->event_id }}" style="cursor:pointer">Audience</a></li>
                                                        
                                                        <li><a target="_blank" href="/admin/events/conference/submission/{{ $conference->event_id }}" >Submission</a></li>
                                                        <li><a target="_blank" href="{{ route('showConferenceSpeakers', $conference->event_id) }}" >Speakers</a></li>


                                                        <li><a target="_blank" href="{{ route('showConferenceSponsors', $conference->event_id) }}" >Sponsors</a></li>
                                                        <li><a target="_blank" href="{{ route('showConferenceMediaCoverages', $conference->event_id) }}" >Media Coverages</a></li>
                                                        <li><a target="_blank" style="background-color: #eee" href="/admin/events/conference/migration/{{ $conference->event_id }}" >Migration</a></li>   
                                                                      
                                                    </ul>
                                                </div>
                                                @if(Auth::user()->user_type_id >= 3)
                                                <div class="btn-group">
                                                    <a style="cursor:pointer" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Manage <span class="caret"></span></a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a target="_blank" href="{{ route('editConference', $conference->event_id) }}" style="cursor:pointer">General Information</a></li>
                                                        <li><a target="_blank" href="{{ route('showConferenceFees', $conference->event_id) }}" >Conference Fees</a></li>
                                                        <li><a target="_blank" href="{{ route('showConferenceWidgets', $conference->event_id) }}" >Conference Widgets</a></li>

                                                        <li><a target="_blank" href="{{ route('showConferenceTopics', $conference->event_id) }}" >Conference Topics</a></li>
                                                        <li><a target="_blank" href="{{ route('showSection', $conference->event_id) }}" >Conference Sections</a></li>
                                                        @if(Auth::user()->user_type_id == 4)
                                                        <li><a target="_blank" href="{{ route('showConferenceAdmins', $conference->event_id) }}" >Conference Admins</a></li>
                                                        @endif
                                                        <li><a target="_blank" href="{{ route('showConferenceSCommittee', $conference->event_id) }}">Scientific Committee</a></li>
                                                        <li><a target="_blank" href="{{ route('editConferenceDates', $conference->event_id) }}">Important Dates</a></li>
                                                        @if(Auth::user()->user_type_id == 5)
                                                        <li><a target="_blank" href="{{ route('showConferenceExpences', $conference->event_id) }}" >Conference expenses</a></li>
                                                        @endif
                                                        @if(Auth::user()->user_type_id == 4)
                                                        @if($conference->deleted == 0)
                                                            <li><a style="cursor:pointer;color:red" onClick="notyConfirmDel('{{ $conference->title_en }}', '{{ $conference->event_id }}');">Delete</a></li>
                                                        @elseif($conference->deleted == 1)
                                                            <li><a style="cursor:pointer;color:green" onClick="notyConfirmRes('{{ $conference->title_en }}', '{{ $conference->event_id }}');">Restore</a></li>
                                                        @endif 
                                                        @endif
                                                    </ul>
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    {{ 'no conferences' }}
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<input type="hidden" name="_token" value="{{ csrf_token() }}" placeholder="">

<script type="text/javascript">
    $('#filter').on('change', function(event){
        event.preventDefault();
        var deleted = $('select[name=deleted]').val();
        window.open('/admin/events/conference/filter/'+deleted, '_self')
    });
    function notyConfirmRes(dat, id){
        noty({
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Restore conference:<br> '+dat+' ?',
            layout: 'center',
            buttons: [
                    {addClass: 'btn btn-success btn-clean', text: 'Ok', onClick: function($noty) {
                        $noty.close();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        console.log(id);
                        $.ajax({
                        type: 'POST',
                        url: '/admin/events/conference/restore/'+id,
                        data: {_method: 'post'},
                            beforeSend: function(xhr) {
                                $('#loading').show();
                            },
                            success: function () {
                                $('#loading').hide();
                                //check if response with success : true/false
                                var deleted = $('select[name=deleted]').val();
                                window.open('/admin/events/conference/filter/'+deleted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'Conference '+dat+' restored successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
                            },
                            error: function () {
                               //console.log(response);           
                            }
                        });
                        //;
                    }
                    },
                    {addClass: 'btn btn-danger btn-clean', text: 'Cancel', onClick: function($noty) {
                        $noty.close();
                        //noty({text: 'You clicked "Cancel" button', layout: 'topRight', type: 'error'});
                        }
                    }
                ]
        })                                                                          
    }
    function notyConfirmDel(dat, id){
        noty({
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Delete conference:<br> '+dat+' ?',
            layout: 'center',
            buttons: [
                    {addClass: 'btn btn-success btn-clean', text: 'Ok', onClick: function($noty) {
                        $noty.close();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        console.log(id);
                        $.ajax({
                        type: 'POST',
                        url: '/admin/events/conference/'+id,
                        data: {_method: 'delete'},
                            beforeSend: function(xhr) {
                                
                            },
                            success: function () {
                                //check if response with success : true/false
                                
                                var deleted = $('select[name=deleted]').val();
                                window.open('/admin/events/conference/filter/'+deleted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'Conference '+dat+' deleted successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
                            },
                            error: function () {
                               //console.log(response);           
                            }
                        });
                        //;
                    }
                    },
                    {addClass: 'btn btn-danger btn-clean', text: 'Cancel', onClick: function($noty) {
                        $noty.close();
                        //noty({text: 'You clicked "Cancel" button', layout: 'topRight', type: 'error'});
                        }
                    }
                ]
        })                                                    
    }                                              
</script>
</div>
@endsection