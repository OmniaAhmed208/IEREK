@extends('admin.layouts.master')
@section('return-url'){{url('/admin')}}@endsection
@section('panel-title') Manage {{$title}} @endsection
@section('content')
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        	<div class="panel panel-default">
                <div class="panel-body">
                	<div class="pull-right">
                		<a href="/admin/users/{{$type}}/make" class="btn btn-success btn-block"><span class="fa fa-plus"></span> Make User {{$title}}</a>
                	    <br>
                    </div>
                    <table class="table table-hover datatable table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Tel</th>
                                <th>Nationality</th>
                                <th>Role</th>
                                <th>Registred</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                    @if($users)
                                        @foreach($users as $user)
                                            <tr id="event{{ $user->user_id }}" class="inactive">
                                                <td>
                                                <?php
                                                    if($user->gender == 1 OR $user->gender == 0){ $gender = 'male'; }elseif($user->gender == 2){ $gender = 'female'; }
                                                ?>
                                                <img src="@if($user->image == '') /uploads/default_avatar_{{ $gender }}.jpg @else /storage/uploads/users/profile/{{ $user->image }}.jpg @endif" style="max-width:35px;border:1px #a97f18 solid;box-shadow: 0 2px 14px 0 rgba(0,0,0,0.1)">&ensp;{{ $user->user_title['title'].' '.$user->first_name.' '.$user->last_name }}</td>
                                                <td>
                                                    {{ $user->email }}
                                                </td>
                                                <td>
                                                    {{ $user->phone }}
                                                </td>
                                                <td>
                                                    @if($user->countries['name'] == 'HOST' OR $user->countries['name'] == NULL) {{ 'N/A' }} @else {{ $user->countries['name'] }} @endif
                                                </td>
                                                <td>
                                                    {{$user->user_type['description']}}
                                                </td>
                                                <td>{{ date('Y-m-d', strtotime($user->created_at)) }}</td>
                                                <td>
                                                    <a class="btn btn-warning" href="{{ url('admin/all-users/profile/'.$user->user_id) }}">Edit</a>&ensp;@if($user->hidden == 1) <a class="btn btn-success" href="{{ url('admin/all-users/unhide/'.$user->user_id) }}">Unhide</a>&ensp; @else <a class="btn btn-info" href="{{ url('admin/all-users/hide/'.$user->user_id) }}">Hide</a>&ensp; @endif<a class="btn btn-danger" onClick="notyConfirmDel('{{ $user->email }}', '{{ $user->user_id }}');">Remove</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                	<tr>
                                    <td>
                                    {{ 'No Admin Users' }}
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
    function notyConfirmDel(dat, id){
        noty({
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to remove user:<br> '+dat+' from {{$title}}?',
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
                        url: '/admin/users/remove/'+id,
                        data: {_method: 'post'},
                            beforeSend: function(xhr) {
                                
                            },
                            success: function () {
                                //check if response with success : true/false
                                setTimeout(window.open('/admin/users/{{$type}}', '_self'), 2000);
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'User '+dat+' was successfully removed from {{$title}} !.', layout: 'center', type: 'success', timeout: 2000})
                                
                            },
                            error: function () {           
                            }
                        });
                        //;
                    }
                    },
                    {addClass: 'btn btn-danger btn-clean', text: 'Cancel', onClick: function($noty) {
                        $noty.close();
                        }
                    }
                ]
        })                                                    
    }                                              
</script>
</div>
@endsection