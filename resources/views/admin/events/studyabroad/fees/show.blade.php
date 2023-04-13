@extends('admin.layouts.master')
@section('return-url'){{route('indexStudyabroad')}}@endsection
@section('panel-title')Manage Study Abroad Fees <small>{{ $event }}</small><br><br><small>Currency: <span style="color:darkgreen;font-weight:700;background:#fff;padding:0.25em;border-radius:5px;">@if($event_currency == ''){{'Not Set'}}@else{{$event_currency}}@endif</span></small>@endsection
@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        	<div class="panel panel-default">
                <div class="panel-body">
                	<div class="col-md-2 pull-right">
                		<a href="/admin/events/studyabroad/fees/create/{{ $event_id }}" class="btn btn-success btn-block"><span class="fa fa-plus"></span> Add Fees</a>
                	</div>
            		<div class="col-md-3">
                        <form method="get">
                            Filter <label class="col-m-6 col-offset-md-4">
                            <select name="deleted" id="deleted" class="form-control">
                                <option value="active-only" @if(@$select == 'active-only') {{ 'selected' }} @endif >Acitve Only</option>
                                <option value="inactive-only" @if(@$select == 'inactive-only') {{ 'selected' }} @endif >Inactive Only</option>
                                <option value="all" @if(@$select == 'all') {{ 'selected' }} @endif>All</option>
                            </select>
                            </label>&ensp;<img src="{{ asset('loading.gif') }}" alt="loading" style="display:none" id="loading">
                        </form>
                    </div>
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Condition</th>
                                <th>For</th>
                                <th>Category</th>
                                <th>Currency/Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($fees)
                            @foreach($fees as $afee)
                            <tr id="event{{ $afee->event_id }}" class="inactive">
                                <td>{{ $afee->title_en }}</td>
                                <td>
                                    
                                    @if($afee->event_date_type_id == 0)
                                    {{ 'All' }}
                                    @else
                                    {{
                                    ucwords(str_replace("_"," ",$afee->event_date_type['event_date_type_title']))
                                    }}
                                    @endif
                                </td>
                                <td>
                                    
                                    @if($afee->event_attendance_type_id == 0)
                                    {{ 'All' }}
                                    @else
                                    {{
                                    $afee->event_attendance_type['title']
                                    }}
                                    @endif
                                    
                                </td>
                                <td>{{ $afee->fees_category_type['title'] }}</td>
                                <td>
                                    
                                    @if($afee->amount > 0)
                                    <span class="label label-info" data-toggle="tooltip" data-placement="top"> @if($event_currency == ''){{'Not Set'}}@else{{$event_currency}}@endif</span> {{ $afee->amount }}.00
                                    @endif
                                </td>
                                <td>
                                    @if($afee->deleted == 1)
                                    <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="fee Is Inactive">Iinactive</span>
                                    @endif
                                    @if($afee->deleted == 0)
                                    <span class="label label-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="fee Is Active">Active</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a style="cursor:pointer" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Manage <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{ route('editStudyabroadFees', $afee->event_fees_id) }}" style="cursor:pointer">Edit</a></li>
                                            @if($afee->deleted == 0)
                                            <li><a style="cursor:pointer;color:red" onClick="notyConfirmDel('{{ $afee->title_en }}', '{{ $afee->event_fees_id }}');">Delete</a></li>
                                            @elseif($afee->deleted == 1)
                                            <li><a style="cursor:pointer;color:green" onClick="notyConfirmRes('{{ $afee->title_en }}', '{{ $afee->event_fees_id }}');">Restore</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>
                                    {{ 'No Fees for this conference' }}
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
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
        window.open('/admin/events/studyabroad/fees/{{ $event_id }}/filter/'+deleted, '_self')
    });
    function notyConfirmRes(dat, id){
        noty({
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Restore fee:<br> '+dat+' ?',
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
                        url: '/admin/events/studyabroad/fees/restore/'+id,
                        data: {_method: 'post'},
                            beforeSend: function(xhr) {
                                $('#loading').show();
                            },
                            success: function () {
                                $('#loading').hide();
                                //check if response with success : true/false
                                var deleted = $('select[name=deleted]').val();
                                window.open('/admin/events/studyabroad/fees/'+{{ $event_id }}+'/filter/'+deleted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'fee '+dat+' restored successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Delete fee:<br> '+dat+' ?',
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
                        url: '/admin/events/studyabroad/fees/'+id,
                        data: {_method: 'delete'},
                            beforeSend: function(xhr) {
                                
                            },
                            success: function () {
                                //check if response with success : true/false
                                
                                var deleted = $('select[name=deleted]').val();
                                window.open('/admin/events/studyabroad/fees/'+{{ $event_id }}+'/filter/'+deleted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'fee '+dat+' deleted successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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