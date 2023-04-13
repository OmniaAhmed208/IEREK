@extends('layouts.master')
@section('content')    
    <div class="container">
        <figure class="cover-img">
            <img src="uploads/images/faq.jpg">
        </figure>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">FAQ</h3>
            </div>
            <div class="panel-body ierekpanel-b" >
                    <?php echo $content->content; ?>
            </div>
        </div>
    </div>
@endsection