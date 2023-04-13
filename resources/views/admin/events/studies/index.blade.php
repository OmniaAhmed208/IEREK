@extends('admin.layouts.master')
@section('panel-title')Manage Studies 
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
                                <th>Options</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                                @if($studies)
                                    @foreach($studies as $studies)
                                        <tr id="event{{ $studies->event_id }}" class="inactive">
                                            <td>{{ $studies->title_en }}</td>
                                            {{-- <td>{{ $studies->sub_category['title'] }}</td> --}}
                                            {{-- <td>{{ date("Y-m-d", strtotime($studies->start_date) ) }}</td> --}}
                                            
                                            <td>
                                            @if($studies->deleted == 1 && @$select == 'all')
                                                <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Studies Is Inactive">I</span>
                                            @endif
                                            @if($studies->deleted == 0 && @$select == 'all')
                                                <span class="label label-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Studies Is Active">A</span>
                                            @endif
                                            @if($studies->publish == 1)
                                                <span class="label label-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Is Published">P</span>
                                            @endif
                                            @if($studies->fullpaper == 1)
                                                <span class="label label-default" data-toggle="tooltip" data-placement="top" title="" data-original-title="Full Paper Is Open">F</span>
                                            @endif
                                            @if($studies->submission == 1)
                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="Registration Is Closed">R</span>
                                            @endif
                                            @if($studies->egy == 1)
                                                <span class="label label-primary"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Egyptian Fees Enabled">E</span>
                                            @endif
                                            </td>
                                            <td class="col-md-3">
                                                <!--<a class="btn btn-default" href="/admin/events/studies/attendance/{{ $studies->event_id }}">Audience</a>
                                                <a class="btn btn-default" href="/admin/events/studies/submission/{{ $studies->event_id }}">Submission</a>-->
                                                <div class="btn-group">
                                                    <a target="_blank" href="/admin/events/studies/attendance/{{ $studies->event_id }}" class="btn btn-info dropdown-toggle">Registers</a>
                                                </div>
                                                @if(Auth::user()->user_type_id >= 3)
                                                <div class="btn-group">
                                                    <a style="cursor:pointer" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Manage <span class="caret"></span></a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a target="_blank" href="{{ route('editStudies', $studies->event_id) }}" style="cursor:pointer">General Information</a></li>
                                                        
                                                        <li><a target="_blank" href="{{ route('showStudiesFees', $studies->event_id) }}" >Studies Fees</a></li>

                                                        <li><a target="_blank" href="{{ route('showStudiesWidgets', $studies->event_id) }}" >Studies Widgets</a></li>
                                                        <li><a target="_blank" href="{{ route('showSection', $studies->event_id) }}" >Studies Sections</a></li>
                                                        @if(Auth::user()->user_type_id == 4)
                                                        <li><a target="_blank" href="{{ route('showStudiesAdmins', $studies->event_id) }}" >Studies Admins</a></li>
                                                        @if($studies->deleted == 0)
                                                            <li><a style="cursor:pointer;color:red" onClick="notyConfirmDel('{{ $studies->title_en }}', '{{ $studies->event_id }}');">Delete</a></li>
                                                        @elseif($studies->deleted == 1)
                                                            <li><a style="cursor:pointer;color:green" onClick="notyConfirmRes('{{ $studies->title_en }}', '{{ $studies->event_id }}');">Restore</a></li>
                                                        @endif
                                                        @endif                
                                                    </ul>
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    {{ 'no studies' }}
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
        window.open('/admin/events/studies/filter/'+deleted, '_self')
    });
    function notyConfirmRes(dat, id){
        noty({
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Restore studies:<br> '+dat+' ?',
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
                        url: '/admin/events/studies/restore/'+id,
                        data: {_method: 'post'},
                            beforeSend: function(xhr) {
                                $('#loading').show();
                            },
                            success: function () {
                                $('#loading').hide();
                                //check if response with success : true/false
                                var deleted = $('select[name=deleted]').val();
                                window.open('/admin/events/studies/filter/'+deleted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'Studies '+dat+' restored successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Delete studies:<br> '+dat+' ?',
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
                        url: '/admin/events/studies/'+id,
                        data: {_method: 'delete'},
                            beforeSend: function(xhr) {
                                
                            },
                            success: function () {
                                //check if response with success : true/false
                                
                                var deleted = $('select[name=deleted]').val();
                                window.open('/admin/events/studies/filter/'+deleted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'Studies '+dat+' deleted successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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