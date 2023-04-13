@extends('layouts.master')
@section('content')    
    <div class="container">
        <figure class="cover-img">
            <img src="uploads/images/translation_service.jpg">
        </figure>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Translation Service</h3>
            </div>
            <div class="panel-body ierekpanel-b" >
                <div class="framed-content">
                    <?php echo $content->content; ?> 
                </div>
            </div>
        </div>
    </div>
@endsection