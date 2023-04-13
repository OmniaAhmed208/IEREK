@extends('admin.layouts.master')
@section('return-url'){{route('indexVideo')}}@endsection
@section('panel-title')Manage Home Page Video Images @endsection
@section('content')

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-2 pull-right">
                        
                        <a href="/admin/pages/home/partners/create" class="btn btn-success btn-block"><span class="fa fa-plus"></span> Add Partners</a>

                    </div>
                    
                    <table class="table table-hover table-striped datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Partner Image</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                                @if($partners)
                                    @foreach($partners as $partner)
                                        <tr id="event{{ $partner->id }}" class="inactive">
                                            <td>{{$partner->id}}</td>
                                            <td><img style="width: 50px; height: 50px" src="{{asset('/storage/uploads/partners/'.$partner->img_path)}}"></td>
                                            <td> <button class="btn btn-danger" onClick="notyConfirmDel('{{ $partner->id }}');">Delete</button></td>        
                                        </tr>
                                                              
                                    @endforeach
                                @else
                                    {{ 'no partners' }}
                                @endif
                        </tbody>
                    </table>
                   
                   
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
 function notyConfirmDel(id){
        noty({
            text: '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Delete the image?',
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
                        url: '/admin/pages/home/partners/'+id,
                        data: {_method: 'delete'},
                            beforeSend: function(xhr) {
                                
                            },
                            success: function () {
                                //check if response with success : true/false
                                
                                var deleted = $('select[name=deleted]').val();
                               
                                noty({text: 'image deleted successfully !.', layout: 'center', type: 'success', timeout: 2000})
                                location.reload(); 
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
@endsection