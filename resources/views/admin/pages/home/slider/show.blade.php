@extends('admin.layouts.master')
@section('return-url'){{route('indexSlider')}}@endsection
@section('panel-title')Manage Home Page Slider Images @endsection
@section('content')
<script>

</script>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-2 pull-right">
                        
                        <a href="/admin/pages/home/slider/create" class="btn btn-success btn-block"><span class="fa fa-plus"></span> Add Slider Image</a>

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
                                <th>Order</th>
                                <th>Image</th>
                                <th>URL</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                                @if($slider)
                                    @foreach($slider as $slid)
                                        <tr  class="inactive">
                                            <td>{{ $slid->position }}</td>
                                            <td>{{ $slid->img }}</td>

                                            <td>{{ $slid->img_url }}</td>
                                           
                                            <td>
                                            @if($slid->deleted == 1)
                                                <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Slider Image Is Inactive">I</span>
                                            @endif
                                            @if($slid->deleted == 0)
                                                <span class="label label-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Slider Image Is Active">A</span>
                                            @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a style="cursor:pointer" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Manage <span class="caret"></span></a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{ route('editSlider', $slid->slider_sid) }}" style="cursor:pointer">Edit</a></li>
                                                        @if($slid->deleted == 0)
                                                            <li><a style="cursor:pointer;color:red" onClick="notyConfirmDel('{{ $slid->position}}', '{{ $slid->slider_sid }}');">Delete</a></li>
                                                        @elseif($slid->deleted == 1)
                                                            <li><a style="cursor:pointer;color:green" onClick="notyConfirmRes('{{ $slid->position }}', '{{ $slid->slider_sid }}');">Restore</a></li>
                                                        @endif                
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                    <td>
                                    {{ 'No Slider Images Exist' }}
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

</div>
@endsection

@push('scripts')
<script type="text/javascript">
    
 $('#deleted').on('change', function(event){
        event.preventDefault();
        var deleted = $('select[name=deleted]').val();
        window.open('/admin/pages/home/slider/filter/'+deleted, '_self')
    });
    function notyConfirmRes(dat, id){
        noty({
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Restore Slider Image:<br> '+dat+' ?',
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
                        url: '/admin/pages/home/slider/restore/'+id,
                        data: {_method: 'post'},
                            beforeSend: function(xhr) {
                                $('#loading').show();
                            },
                            success: function () {
                                $('#loading').hide();
                                //check if response with success : true/false
                                var deleted = $('select[name=deleted]').val();
                                window.open('/admin/pages/home/slider/filter/'+deleted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'Slider Slide restored successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Delete the slide?',
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
                        url: '/admin/pages/home/slider/'+id,
                        data: {_method: 'delete'},
                            beforeSend: function(xhr) {
                                
                            },
                            success: function () {
                                //check if response with success : true/false
                                
                                var deleted = $('select[name=deleted]').val();
                                window.open('/admin/pages/home/slider/filter/'+deleted, '_self')
                                //$(deletedEvent).appendTo(inactiveEvents);
                                noty({text: 'Slider Slide deleted successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                
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
                                               
</script>
@endpush