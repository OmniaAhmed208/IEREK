@extends('admin.layouts.master')
@section('panel-title')Manage Book Series 
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
                                <th>Status</th>
                                @if(Auth::user()->user_type_id >= 3)
                                <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                                @if($bookseries)
                                    @foreach($bookseries as $bookseries)
                                        <tr id="event{{ $bookseries->event_id }}" class="inactive">
                                            <td>{{ $bookseries->title_en }}</td>
                                            <td>{{ $bookseries->sub_category['title'] }}</td>
                                            <td>{{ date("Y-m-d", strtotime($bookseries->start_date) ) }}</td>
                                            
                                            <td>
                                            @if($bookseries->deleted == 1)
                                                <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Book Series Is Inactive">I</span>
                                            @endif
                                            @if($bookseries->deleted == 0)
                                                <span class="label label-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Book Series Is Active">A</span>
                                            @endif
                                            @if($bookseries->publish == 1)
                                                <span class="label label-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Book Series Is Published">P</span>
                                            @endif
                                            @if($bookseries->fullpaper == 1)
                                                <span class="label label-default" data-toggle="tooltip" data-placement="top" title="" data-original-title="Book Series Full Paper Is Open">F</span>
                                            @endif
                                            @if($bookseries->submission == 1)
                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="Book Series Submission Is Closed">S</span>
                                            @endif
                                            @if($bookseries->overview == 1)
                                                <span class="label label-success"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Book Series Is In Overview">O</span>
                                            @endif
                                            </td>
                                            @if(Auth::user()->user_type_id >= 3)
                                            <td>
                                                <div class="btn-group">
                                                    <a style="cursor:pointer" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Manage <span class="caret"></span></a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{ route('editBookseries', $bookseries->event_id) }}" style="cursor:pointer">General Information</a></li>
                                                        
                                                        <li><a href="{{ route('showBookseriesWidgets', $bookseries->event_id) }}" >Book Series Widgets</a></li>

                                                        <li><a href="{{ route('showSection', $bookseries->event_id) }}" >
                                                        Book Series Sections</a></li>
                                                        @if(Auth::user()->user_type_id ==4)
                                                        <li><a href="{{ route('showBookseriesAdmins', $bookseries->event_id) }}" >Book Series Admins</a></li>
                                                        

                                                        @if($bookseries->deleted == 0)
                                                            <li><a style="cursor:pointer;color:red" onClick="notyConfirmDel('{{ $bookseries->title_en }}', '{{ $bookseries->event_id }}');">Delete</a></li>
                                                        @elseif($bookseries->deleted == 1)
                                                            <li><a style="cursor:pointer;color:green" onClick="notyConfirmRes('{{ $bookseries->title_en }}', '{{ $bookseries->event_id }}');">Restore</a></li>
                                                        @endif   
                                                       @endif 
                                                               
                                                    </ul>
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    {{ 'no bookseries' }}
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
        window.open('/admin/events/bookseries/filter/'+deleted, '_self')
    });
    function notyConfirmRes(dat, id){
        noty({
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Restore bookseries:<br> '+dat+' ?',
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
                        url: '/admin/events/bookseries/restore/'+id,
                        data: {_method: 'post'},
                            beforeSend: function(xhr) {
                                $('#loading').show();
                            },
                            success: function () {
                                $('#loading').hide();
                                //check if response with success : true/false
                                var deleted = $('select[name=deleted]').val();
                                window.open('/admin/events/bookseries/filter/'+deleted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'Book Series '+dat+' restored successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Delete bookseries:<br> '+dat+' ?',
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
                        url: '/admin/events/bookseries/'+id,
                        data: {_method: 'delete'},
                            beforeSend: function(xhr) {
                                
                            },
                            success: function () {
                                //check if response with success : true/false
                                
                                var deleted = $('select[name=deleted]').val();
                                window.open('/admin/events/bookseries/filter/'+deleted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'Book Series '+dat+' deleted successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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