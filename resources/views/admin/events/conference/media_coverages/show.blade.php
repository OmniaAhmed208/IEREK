@extends('admin.layouts.master')
@section('return-url'){{route('indexConference')}}@endsection
@section('panel-title')Manage Conference Media Coverages Requests <small>{{ $event }}</small>@endsection
@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                   
                    <div class="col-md-4">
                        <form method="get">
                            Filter <label class="col-m-6 col-offset-md-4">
                                <select name="deleted" id="deleted" class="form-control">
                                    <option value="active-only" @if(@$select == 'active-only') {{ 'selected' }} @endif >Acitve Only</option>
                                    <option value="inactive-only" @if(@$select == 'inactive-only') {{ 'selected' }} @endif >Inactive Only</option>
                                    <option value="all" @if(@$select == 'all') {{ 'selected' }} @endif>All</option>
                                </select>

                            </label>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="
                            loading">

                            
                            <label class="col-m-6 col-offset-md-4">
                                 <select name="accepted" id="accepted" class="form-control">
                                    <option value="all" @if(@$accept == 'all') {{ 'selected' }} @endif>All</option>
                                    
                                    <option value="accepted" @if(@$accept == 'accepted') {{ 'selected' }} @endif >Accepted</option>
                                    <option value="rejected" @if(@$accept == 'rejected') {{ 'selected' }} @endif >Rejected</option>
                                    
                                </select>
                            </label>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
                            
                        </form>


                    </div>
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Organization</th>
                                <th>Email</th>
                                <th>Media Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                                @if($media_coverages)
                                    @foreach($media_coverages as $media_coverage)
                                        <tr id="event{{ $media_coverage->event_id }}" class="inactive">
                                            <td>{{ $media_coverage->organization }}</td>
                                            <td>{{ $media_coverage->email }}</td>

                                            <td>{{ $media_coverage->media_type }}</td>
                                           
                                            <td>
                                            @if($media_coverage->deleted == 1)
                                                <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Media Coverage Requist Is Inactive">I</span>
                                            @endif
                                            @if($media_coverage->deleted == 0)
                                                <span class="label label-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Media Coverage Requist Is Active">A</span>
                                            @endif

                                            @if($media_coverage->accepted == 0)
                                                <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Media Coverage Requist Is Initial">Ini</span>
                                            @endif

                                            @if($media_coverage->accepted == 1)
                                                <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Media Coverage Requist Is Accepted">Acc</span>
                                            @endif
                                            @if($media_coverage->accepted == 2)
                                                <span class="label label-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Media Coverage Requist Is requist Rejected">Rej</span>
                                            @endif

                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a style="cursor:pointer" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Manage <span class="caret"></span></a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{ route('editConferenceMediaCoverages', $media_coverage->event_media_coverage_sid) }}" style="cursor:pointer">View</a></li>
                                                        @if($media_coverage->deleted == 0)
                                                            @if($media_coverage->accepted == 0)
                                                                <li><a style="cursor:pointer;color:green" onClick="notyConfirmAcc('{{ $media_coverage->organization}}', '{{ $media_coverage->event_media_coverage_sid }}');">Accept</a></li>

                                                                <li><a style="cursor:pointer;color:magenta" onClick="notyConfirmRej('{{ $media_coverage->organization}}', '{{ $media_coverage->event_media_coverage_sid }}');">Reject</a></li>

                                                                <li><a style="cursor:pointer;color:red" onClick="notyConfirmDel('{{ $media_coverage->organization}}', '{{ $media_coverage->event_media_coverage_sid }}');">Delete</a></li>
                                                            @elseif($media_coverage->accepted != 0)
                                                                 <li><a style="cursor:pointer;color:red" onClick="notyConfirmDel('{{ $media_coverage->organization}}', '{{ $media_coverage->event_media_coverage_sid }}');">Delete</a></li>
                                                            @endif
                                                        @elseif($media_coverage->deleted == 1)
                                                            <li><a style="cursor:pointer;color:green" onClick="notyConfirmRes('{{ $media_coverage->organization }}', '{{ $media_coverage->event_media_coverage_sid }}');">Restore</a></li>
                                                        @endif                
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                    <td>
                                    {{ 'No Media Coverages for this conference' }}
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <!--
                                    <td></td>
                                    <td></td>
                                    <td></td>-->
                                    <td></td>
                                    <td></td>
                                    </tr>
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<input type="hidden" name="_token" value="{{ csrf_token() }}" placeholder="">

<script type="text/javascript">
    $('#deleted').on('change', function(event){
        event.preventDefault();
        var deleted = $('select[name=deleted]').val();
        var accepted = $('select[name=accepted]').val();
        window.open('/admin/events/conference/media_coverages/{{ $event_id }}/filter/'+deleted+'/filterAccepted/'+accepted, '_self')
    });

    $('#accepted').on('change', function(event){
        event.preventDefault();
        var deleted = $('select[name=deleted]').val();
        var accepted = $('select[name=accepted]').val();
        window.open('/admin/events/conference/media_coverages/{{ $event_id }}/filter/'+deleted+'/filterAccepted/'+accepted, '_self')
    });

    


    function notyConfirmRes(dat, id){
        noty({
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Restore the requist of the media_coverage:<br> '+dat+' ?',
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
                        url: '/admin/events/conference/media_coverages/restore/'+id,
                        data: {_method: 'post'},
                            beforeSend: function(xhr) {
                                $('#loading').show();
                            },
                            success: function () {
                                $('#loading').hide();
                                //check if response with success : true/false
                                var deleted = $('select[name=deleted]').val();
                                var accepted = $('select[name=accepted]').val();
                                window.open('/admin/events/conference/media_coverages/'+{{ $event_id }}+'/filter/'+deleted+'/filterAccepted/'+accepted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'the requist of the media_coverage '+dat+' restored successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Delete the requist of the media_coverage:<br> '+dat+' ?',
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
                        url: '/admin/events/conference/media_coverages/'+id,
                        data: {_method: 'delete'},
                            beforeSend: function(xhr) {
                                
                            },
                            success: function () {
                                //check if response with success : true/false
                                
                                var deleted = $('select[name=deleted]').val();
                                var accepted = $('select[name=accepted]').val();
                                window.open('/admin/events/conference/media_coverages/'+{{ $event_id }}+'/filter/'+deleted+'/filterAccepted/'+accepted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'the requist of the media_coverage '+dat+' deleted successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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
    function notyConfirmAcc(dat, id){
        noty({
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Accept the request of the media_coverage:<br> '+dat+' ?',
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
                        url: '/admin/events/conference/media_coverages/accept/'+id,
                        data: {_method: 'post'},
                            beforeSend: function(xhr) {
                                $('#loading').show();
                            },

                            success: function () {
                                //check if response with success : true/false
                                
                                var deleted = $('select[name=deleted]').val();
                                var accepted = $('select[name=accepted]').val();
                                window.open('/admin/events/conference/media_coverages/'+{{ $event_id }}+'/filter/'+deleted+'/filterAccepted/'+accepted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'the request of the media_coverage '+dat+' accepted successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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
    function notyConfirmRej(dat, id){
        noty({
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Reject the request of the media_coverage:<br> '+dat+' ?',
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
                        url: '/admin/events/conference/media_coverages/reject/'+id,
                        data: {_method: 'post'},
                            beforeSend: function(xhr) {
                                $('#loading').show();
                            },

                            success: function () {
                                //check if response with success : true/false
                                
                                var deleted = $('select[name=deleted]').val();
                                var accepted = $('select[name=accepted]').val();
                                window.open('/admin/events/conference/media_coverages/'+{{ $event_id }}+'/filter/'+deleted+'/filterAccepted/'+accepted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'the request of the media_coverage '+dat+' rejected successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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