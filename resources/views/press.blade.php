@extends('layouts.master')
@section('content')
<div class="container">
    <figure class="cover-img">
        <img src="uploads/images/press.jpg" alt=""/>
    </figure>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">IEREK Press</h3>
        </div>
        <div class="panel-body ierekpanel-b" >
            <div class="contacts-messages insidepanel">
                <div class="row">
                    <?php echo $content->content; ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection