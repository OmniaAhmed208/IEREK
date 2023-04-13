@extends('layouts.master')
@section('content')
<div class="container" id="about-ierek-content">
    <figure class="cover-img">
        <img src="uploads/images/projects_managemnet.jpg" alt=""/>
    </figure>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Projects Managemnet</h3>
        </div>
        <div class="panel-body ierekpanel-b" >
            <div class="framed-content">
            <?php echo $content->content; ?>
            </div>
        </div>
    </div>
</div>
@endsection