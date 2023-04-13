@extends('layouts.master')
@section('content')
<div class="container">
    <figure class="cover-img">
        <img src=" {{ asset('/images/Previous Publications11.jpg')}}" alt=""/>
    </figure>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Previous Publications</h3>
        </div>
        <div class="panel-body ierekpanel-b whitebackground" >
            <div class="framed-content">
            <?php echo $content->content; ?>
            </div>
        </div>
    </div>
</div>
@endsection