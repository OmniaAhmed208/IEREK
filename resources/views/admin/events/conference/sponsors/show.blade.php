@extends('admin.layouts.master')
@section('return-url'){{route('indexConference')}}@endsection
@section('panel-title')Manage Conference Sponsors Requests <small>{{ $event }}</small>@endsection
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
                                <th>Organization Name</th>
                                <th>Phone</th>
                                <th>Contact Person Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                                @if($sponsors)
                                    @foreach($sponsors as $sponsor)
                                        <tr id="event{{ $sponsor->event_id }}" class="inactive">
                                            <td>{{ $sponsor->sponsor_organization }}</td>
                                            <td>{{ $sponsor->sponsor_phone }}</td>

                                            <td>{{ $sponsor->sponsor_name }}</td>
                                           
                                            <td>
                                            @if($sponsor->deleted == 1)
                                                <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sponsor Requist Is Inactive">I</span>
                                            @endif
                                            @if($sponsor->deleted == 0)
                                                <span class="label label-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sponsor Requist Is Active">A</span>
                                            @endif

                                            @if($sponsor->accepted == 0)
                                                <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sponsor Requist Is Initial">Ini</span>
                                            @endif

                                            @if($sponsor->accepted == 1)
                                                <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sponsor Requist Is Accepted">Acc</span>
                                            @endif
                                            @if($sponsor->accepted == 2)
                                                <span class="label label-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sponsor Requist Is requist Rejected">Rej</span>
                                            @endif

                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a style="cursor:pointer" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Manage <span class="caret"></span></a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="/admin/events/conference/sponsors/showSponsor/{{$sponsor->sponsor_id}}" style="cursor:pointer">View</a></li>
                                                        @if($sponsor->deleted == 0)
                                                            @if($sponsor->accepted == 0)
                                                                <li><a style="cursor:pointer;color:green" onClick="notyConfirmAcc('{{ $sponsor->sponsor_name}}', '{{ $sponsor->sponsor_id }}');">Accept</a></li>

                                                                <li><a style="cursor:pointer;color:magenta" onClick="notyConfirmRej('{{ $sponsor->sponsor_name}}', '{{ $sponsor->sponsor_id }}');">Reject</a></li>

                                                                <li><a style="cursor:pointer;color:red" onClick="notyConfirmDel('{{ $sponsor->sponsor_name}}', '{{ $sponsor->sponsor_id }}');">Delete</a></li>
                                                            @elseif($sponsor->accepted != 0)
                                                                 <li><a style="cursor:pointer;color:red" onClick="notyConfirmDel('{{ $sponsor->sponsor_name}}', '{{ $sponsor->sponsor_id }}');">Delete</a></li>
                                                            @endif
                                                        @elseif($sponsor->deleted == 1)
                                                            <li><a style="cursor:pointer;color:green" onClick="notyConfirmRes('{{ $sponsor->sponsor_name }}', '{{ $sponsor->sponsor_id }}');">Restore</a></li>
                                                        @endif                
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                    <td>
                                    {{ 'No Sponsors for this conference' }}
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
        window.open('/admin/events/conference/sponsors/{{ $event_id }}/filter/'+deleted+'/filterAccepted/'+accepted, '_self')
    });

    $('#accepted').on('change', function(event){
        event.preventDefault();
        var deleted = $('select[name=deleted]').val();
        var accepted = $('select[name=accepted]').val();
        window.open('/admin/events/conference/sponsors/{{ $event_id }}/filter/'+deleted+'/filterAccepted/'+accepted, '_self')
    });

    


    function notyConfirmRes(dat, id){
        noty({
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Restore the requist of the sponsor:<br> '+dat+' ?',
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
                        url: '/admin/events/conference/sponsors/restore/'+id,
                        data: {_method: 'post'},
                            beforeSend: function(xhr) {
                                $('#loading').show();
                            },
                            success: function () {
                                $('#loading').hide();
                                //check if response with success : true/false
                                var deleted = $('select[name=deleted]').val();
                                var accepted = $('select[name=accepted]').val();
                                window.open('/admin/events/conference/sponsors/'+{{ $event_id }}+'/filter/'+deleted+'/filterAccepted/'+accepted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'the requist of the sponsor '+dat+' restored successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Delete the requist of the sponsor:<br> '+dat+' ?',
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
                        url: '/admin/events/conference/sponsors/'+id,
                        data: {_method: 'delete'},
                            beforeSend: function(xhr) {
                                
                            },
                            success: function () {
                                //check if response with success : true/false
                                
                                var deleted = $('select[name=deleted]').val();
                                var accepted = $('select[name=accepted]').val();
                                window.open('/admin/events/conference/sponsors/'+{{ $event_id }}+'/filter/'+deleted+'/filterAccepted/'+accepted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'the requist of the sponsor '+dat+' deleted successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Accept the request of the sponsor:<br> '+dat+' ?',
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
                        url: '/admin/events/conference/sponsors/accept/'+id,
                        data: {_method: 'post'},
                            beforeSend: function(xhr) {
                                $('#loading').show();
                            },

                            success: function () {
                                //check if response with success : true/false
                                console.log("ok");
                                var deleted = $('select[name=deleted]').val();
                                var accepted = $('select[name=accepted]').val();
                                window.open('/admin/events/conference/sponsors/'+{{ $event_id }}+'/filter/'+deleted+'/filterAccepted/'+accepted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'the request of the sponsor '+dat+' accepted successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Reject the request of the sponsor:<br> '+dat+' ?',
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
                        url: '/admin/events/conference/sponsors/reject/'+id,
                        data: {_method: 'post'},
                            beforeSend: function(xhr) {
                                $('#loading').show();
                            },

                            success: function () {
                                //check if response with success : true/false
                                
                                var deleted = $('select[name=deleted]').val();
                                var accepted = $('select[name=accepted]').val();
                                window.open('/admin/events/conference/sponsors/'+{{ $event_id }}+'/filter/'+deleted+'/filterAccepted/'+accepted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'the request of the sponsor '+dat+' rejected successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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