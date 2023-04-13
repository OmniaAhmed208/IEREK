@extends('admin.layouts.master')
@section('return-url'){{route('indexConference')}}@endsection
@section('panel-title')Manage Workshop Attendance <small>{{ $event->title_en }}</small>@endsection
@section('content') 
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Messages & Reports</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="{{ route('WorkAtteExport') }}">
                        <input type="hidden" name="event_id" value="{{ $event_id }}">
                        <div class="form-group panel">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="panel-body">
                                <label>Choose Users Group</label>
                                <div class="col-md-12">         
                                    <label class="check col-md-2"><input type="radio" class="icheckbox" value="all" name="users_filter" checked/> All</label>
                                    <label class="check col-md-2"><input type="radio" class="icheckbox" value="audience" name="users_filter" /> Audience</label>
                                    <label class="check col-md-2"><input type="radio" class="icheckbox" value="paid" name="users_filter" /> Paid</label>
                                    <label class="check col-md-2"><input type="radio" class="icheckbox" value="not-paid" name="users_filter" /> Not Paid</label>
                                    <label class="check col-md-2"><input type="radio" class="icheckbox" value="unregistered" name="users_filter" /> Unregistered</label>
                                </div>
                            </div>
                        </div><!-- 
                        <div class="form-group panel">
                            <div class="panel-body">
                                <label>Order By</label>
                                <div class="col-md-12">         
                                    <label class="check col-md-2"><input type="radio" class="icheckbox" value="orderby" checked value="a-z" /> A-Z</label>
                                    <label class="check col-md-2"><input type="radio" class="icheckbox" value="orderby" value="groups" /> Groups</label>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <div class="col-md-5">
                                <input type="submit" name="export" class="btn btn-success" value="Filter Users">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Workshop Registered Users</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="get">
                            Filter <label class="col-m-6 col-offset-md-4">
                            <select name="deleted" id="filter" class="form-control select">
                                <option value="active-only" @if(@$select == 'active-only') {{ 'selected' }} @endif >Acitve Only</option>
                                <option value="inactive-only" @if(@$select == 'inactive-only') {{ 'selected' }} @endif >Inactive Only</option>
                                <option value="paid" @if(@$select == 'paid') {{ 'selected' }} @endif >Paid</option>
                                <option value="not-paid" @if(@$select == 'not-paid') {{ 'selected' }} @endif >Not Paid</option>
                                <option value="unregistered" @if(@$select == 'unregistered') {{ 'selected' }} @endif >Unregistered</option>
                                <option value="all" @if(@$select == 'all') {{ 'selected' }} @endif>All</option>
                            </select>
                            </label>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
                        </form>
                    </div>
                    <table class="table table-hover table-striped datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Tel</th>
                                <th>Nationality</th>
                                <th>Type</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @if(isset($attendances))
                                    @foreach($attendances as $attendance)
                                        <tr id="event{{ $attendance->event_attendace_id }}" class="inactive">
                                            <td>
                                            <?php
                                                if($attendance['users']->gender == 1 OR $attendance['users']->gender == 0){ $gender = 'male'; }elseif($attendance['users']->gender == 2){ $gender = 'female'; }
                                            ?>
                                            <img src="@if($attendance['users']->image == '') /uploads/default_avatar_{{ $gender }}.jpg @else /storage/uploads/users/profile/{{ $attendance['users']->image }}.jpg @endif" style="max-width:35px;border:1px #a97f18 solid;box-shadow: 0 2px 14px 0 rgba(0,0,0,0.1)">&ensp;{{ $attendance['users']->user_title['title'].' '.$attendance['users']->first_name.' '.$attendance['users']->last_name }}</td>
                                            <td>
                                                {{ $attendance['users']->email }}
                                            </td>
                                            <td>
                                                {{ $attendance['users']->phone }}
                                            </td>
                                            <td>
                                                @if($attendance['users']->countries['name'] == 'HOST' OR $attendance['users']->countries['name'] == NULL) {{ 'N/A' }} @else {{ $attendance['users']->countries['name'] }} @endif
                                            </td>
                                            <td><?php $types = [1 => 'Audience', 2 => 'Co-Author', 3 => 'Author']; ?>
                                                {{$types[$attendance->event_attendance_type_id]}}
                                            </td>
                                            <td>{{ $attendance->created_at }}</td>

                                            <td>
                                            @if($attendance->deleted == 1)
                                                <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Attendace Is Inactive">I</span>
                                            @endif
                                            @if($attendance->deleted == 0)
                                                <span class="label label-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Attendace Is Active">A</span>
                                            @endif
                                            @if($attendance->payment == 1)
                                                <span class="label label-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Attendace Is Paid">Paid</span>
                                            @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a style="cursor:pointer" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Manage <span class="caret"></span></a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="" style="cursor:pointer">Add Payment</a></li>
                                                        <li><a href="" style="cursor:pointer">Cancel Payment</a></li>
                                                        <li><a href="" onclick="windowOpen('{{url('admin/message/'.$attendance->user_id.'/'.$attendance->event_id)}}')" style="cursor:pointer">Message</a></li>
                                                        @if($attendance->deleted == 0)
                                                            <li><a style="cursor:pointer;color:red" onClick="notyConfirmDel('{{ $attendance['users']->first_name }}', '{{ $attendance->event_attendance_id }}');">Delete</a></li>
                                                        @elseif($attendance->deleted == 1)
                                                            <li><a style="cursor:pointer;color:green" onClick="notyConfirmRes('{{ $attendance['users']->first_name }}', '{{ $attendance->event_attendance_id }}');">Restore</a></li>
                                                        @endif                
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    {{ 'There is no attendances for this workshops' }}
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
        window.open('/admin/events/workshop/attendance/{{ $event_id }}/filter/'+deleted, '_self')
    });
    function notyConfirmRes(dat, id){
        noty({
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Restore workshop:<br> '+dat+' ?',
            layout: 'center',
            buttons: [
                    {addClass: 'btn btn-success btn-clean', text: 'Ok', onClick: function($noty) {
                        $noty.close();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        $.ajax({
                        type: 'POST',
                        url: '/admin/events/workshop/attendance/restore/'+id,
                        data: {_method: 'post'},
                            beforeSend: function(xhr) {
                                $('#loading').show();
                            },
                            success: function () {
                                $('#loading').hide();
                                //check if response with success : true/false
                                var deleted = $('select[name=deleted]').val();
                                window.open('/admin/events/workshop/attendance/{{ $event_id }}/filter/'+deleted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'Attendace '+dat+' restored successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
                            },
                            error: function () {         
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
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Delete workshop:<br> '+dat+' ?',
            layout: 'center',
            buttons: [
                    {addClass: 'btn btn-success btn-clean', text: 'Ok', onClick: function($noty) {
                        $noty.close();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        $.ajax({
                        type: 'POST',
                        url: '/admin/events/workshop/attendance/'+id,
                        data: {_method: 'delete'},
                            beforeSend: function(xhr) {
                                
                            },
                            success: function () {
                                //check if response with success : true/false
                                
                                var deleted = $('select[name=deleted]').val();
                                window.open('/admin/events/workshop/attendance/{{ $event_id }}/filter/'+deleted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'Attendace '+dat+' deleted successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
                            },
                            error: function () {         
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
    function windowOpen(url){
        window.open (url,'targetWindow','resizable=0,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=700,height=550');
    }                                              
</script>
</div>  
    <!-- @foreach($attendances as $attendance)

    @endforeach -->
@endsection