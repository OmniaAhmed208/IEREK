 
@extends('layouts.master') @section('content')
    <div id="HomeP">
        <div class="container">
            <!-- carousel1 -->
            <div class="row">
                <!-- end carousel main -->
                <div class="container">
                    <div class="col-12 col-md-12 carousel-container">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <?php $first = 0; ?>
                                @foreach($sliders as $slider)
                                    <li data-target="#carousel-example-generic2" data-slide-to="{{$slider->position}}"
                                        class="<?php if ($first == 0) {
                                            $first = 1;
                                            echo 'active';
                                        } ?>">
                                    </li>
                                @endforeach
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <?php $first_s = 0; ?>
                                @foreach($sliders as $slider)
                                    <div class="item <?php if ($first_s == 0) {
                                        $first_s = 1;
                                        echo 'active';
                                    } ?>">
                                        <a href="{{$slider->img_url}}">
                                            <img src="/storage/uploads/slider/{{$slider->img}}" alt="">
                                        </a>
                                        <div class="carousel-caption">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                <span class="sr-only">Next</span>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12" style="margin-bottom:1em;">
                    <div class="categories-home-row categories-home-firstRow col-12 col-sm-6">
                        <div class="categories-home-card-main-container">
                            <a href="/conferences">
                                <div class="categories-home-card-container">
                                    <div class="categories-home-card-container-img">
                                        <img src="/uploads/images/45856_photo.jpg" alt="">
                                    </div>
                                    <div class="categories-home-card-container-title">
                                        <div class="categories-home-card-container-title-text">
                                            Conferences
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="categories-home-card-main-container">
                            <a href="/ierek-press">
                                <div class="categories-home-card-container">
                                    <div class="categories-home-card-container-img">
                                        <img src="/uploads/images/2d089_photo.jpg" alt="">
                                    </div>
                                    <div class="categories-home-card-container-title">
                                        <div class="categories-home-card-container-title-text">
                                            IEREK Press
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="categories-home-card-main-container">
                            <a href="/workshops">
                                <div class="categories-home-card-container">
                                    <div class="categories-home-card-container-img">
                                        <img src="/uploads/images/4b972_photo.jpg" alt="">
                                    </div>
                                    <div class="categories-home-card-container-title">
                                        <div class="categories-home-card-container-title-text">
                                            Workshops
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="categories-home-card-main-container">
                            <a href="/scientific-committee">
                                <div class="categories-home-card-container">
                                    <div class="categories-home-card-container-img">
                                        <img src="/uploads/images/49e42_photo.jpg" alt="">
                                    </div>
                                    <div class="categories-home-card-container-title">
                                        <div class="categories-home-card-container-title-text">
                                            Scientific Committee
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="categories-home-row categories-home-lastRow col-12 col-sm-6">
                        <div class="categories-home-card-main-container">
                            <a href="https://www.springer.com/series/15883" target="_blank" rel="nofollow">
                                <div class="categories-home-card-container">
                                    <div class="categories-home-card-container-img">
                                        <img src="/uploads/images/asti.png" alt="ASTI Book Series">
                                    </div>
                                    <div class="categories-home-card-container-title">
                                        <div class="categories-home-card-container-title-text">
                                            ASTI Book Series
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="categories-home-card-main-container">
                            <a href="/study_abroad">
                                <div class="categories-home-card-container">
                                    <div class="categories-home-card-container-img">
                                        <img src="/uploads/images/77c4d_photo.jpg" alt="">
                                    </div>
                                    <div class="categories-home-card-container-title">
                                        <div class="categories-home-card-container-title-text">
                                            Study Abroad
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="categories-home-card-main-container">
                            <a href="/news/index.php/category/news/">
                                <div class="categories-home-card-container">
                                    <div class="categories-home-card-container-img">
                                        <img src="/uploads/images/8fc6a_photo.jpg" alt="">
                                    </div>
                                    <div class="categories-home-card-container-title">
                                        <div class="categories-home-card-container-title-text">
                                            News
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="categories-home-card-main-container">
                            <a href="/news/index.php/category/blog/">
                                <div class="categories-home-card-container">
                                    <div class="categories-home-card-container-img">
                                        <img src="/uploads/images/e37f4_photo.jpg" alt="">
                                    </div>
                                    <div class="categories-home-card-container-title">
                                        <div class="categories-home-card-container-title-text">
                                            Blog
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <?php $count = 0; ?>
            @if(count($f_conferences) > 0)
                <div class="box-title">Featured Conferences</div>
                <!-- Insert to your webpage where you want to display the carousel -->
                <div class="row">
                    <div class="conferencesContainer"
                         style="display: block; position: relative; width: 100%; max-width: 100%; margin: 0px auto; direction: ltr;">
                        <div style="width: 100%; position: relative; overflow: visible;">
                            <div>
                                @foreach($f_conferences as $conference)
                                    <div class="col-md-4 col-sm-6 @if($count >= 6){{'hidden-sm hidden-xs'}}@endif"
                                         style="margin-bottom:30px">
                                        <div class="featured-conferences-item"
                                             style=" float: left; list-style: outside none none; position: relative;width: 100%; ">
                                            <div>
                                                <a class="conference-content-container"
                                                   href="/events/{{$conference->event['slug']}}">

                                                    <div class="featured-conferences-item-thumb">
                                                    {{--<a href="/events/{{$conference->event['slug']}}">--}}
                                                    <!-- <img src="/storage/uploads/conferences/{{ $conference->event_id }}/cover_img.jpg" height="150px" /> -->
                                                        <div class="conference-main-img-container">
                                                            <img class="conference-main-img"
                                                                 src="{{ asset('/storage/uploads/conferences/'.$conference->event_id.'/list_img.jpg') }}">
                                                        </div>
                                                        {{--</a>--}}
                                                    </div>
                                                    <div class="feature-conferences-item-text-container">
                                                        <div class="featured-conferences-item-title">
                                                            {{$conference->event['title_en']}}
                                                            <div class="featured-conferences-item-sub-title pulse1">
                                                                CALL FOR PAPERS
                                                            </div>
                                                        </div>

                                                    </div>

                                                </a>

                                                <div class="centering-flex-content"><a href="#"
                                                                                           onclick="window.open('/events/{{$conference->event['slug']}}','_self')"
                                                                                           class="btn btn-primary pull-right"
                                                                                           style="position: relative; float:right;">Submit
                                                            now</a>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $count++; ?>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <?php $count = 0; ?>
            @if(count($f_summer_schools) > 0)
                <div class="box-title">Featured Summer/ Winter Schools</div>
                <!--Insert to your webpage where you want to display the carousel-->
                <div class="row">
                    <div class="conferencesContainer"
                         style="display: block; position: relative; width: 100%; max-width: 100%; direction: ltr;">
                        <div style="width: 100%; position: relative; overflow: visible;">
                            <div>
                                @foreach($f_summer_schools as $f_summer_school)
                                    <div class="col-md-4 col-xs-12 ">
                                        <div class="featured-conferences-item featured-summer-schools"
                                             style=" float: left; list-style: outside none none; position: relative;width: 100%; ">
                                            <div class="featured-conferences-item-thumb">
                                                <a href="/events/{{$f_summer_school->event['slug']}}">
                                                <!--<img src="/storage/uploads/conferences/{{ $f_summer_school->event_id }}/cover_img.jpg" height="150px" />-->
                                                    <div class="conference-main-img-container summer-school-container">
                                                        <img width="100%" 
                                                             src="{{ asset('/storage/uploads/studyabroads/'.$f_summer_school->event_id.'/list_img.jpg') }}">
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="feature-conferences-item-text-container">
                                                <div class="featured-conferences-item-title">
                                                    <a href="/events/{{$f_summer_school->event['slug']}}">
                                                        {{$f_summer_school->event['title_en']}}</a>
                                                </div>
                                            </div>
                                            <div class="centering-flex-content"><a href="#"
                                                                                   onclick="window.open('/events/{{$f_summer_school->event['slug']}}','_self')"
                                                                                   class="btn btn-success pull-left">Register</a>
                                            </div>

                                        </div>
                                    </div>
                                    <?php $count++; ?>
                                @endforeach

                                {{-- study abroad --}}


                                    <div class="col-md-4 col-xs-12 ">
                                        <div class="featured-conferences-item featured-summer-schools"
                                             style=" float: left; list-style: outside none none; position: relative;width: 100%; ">
                                            <div class="featured-conferences-item-thumb">
                                                <a href="{{$announcements[0]->announce_url}}">
                                                <!--<img src="/storage/uploads/conferences/{{ $f_summer_school->event_id }}/cover_img.jpg" height="150px" />-->
                                                    <div class="conference-main-img-container summer-school-container">
                                                        <img width="100%"
                                                             src="{{asset('/storage/uploads/announcement/'.$announcements[0]->announce_image)}}">
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="feature-conferences-item-text-container">
                                                <div class="featured-conferences-item-title">
                                                    International Masters Degrees around the world
                                                </div>
                                            </div>
                                            <div class="centering-flex-content"><a href="{{$announcements[0]->announce_url}}"
                                                                                  
                                                                                   class="btn btn-success pull-left">Read More</a>
                                            </div>

                                        </div>
                                    </div>

                                    {{--<div class="col-md-4 col-xs-12">--}}
                                        {{--<div class="home-block-container third-img-first-row-home study-in-italy">--}}
                                            {{--<a href="{{$announcements[0]->announce_url}}"  target="_blank"><img src="{{asset('/storage/uploads/announcement/'.$announcements[0]->announce_image)}}"--}}
                                                                                                                {{--style="width: 100%"></a>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}


                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="home-blocks-container">
                <div class="main-container">
                    <div class="home-block-container">
                        <div class="home-block-title brown">About IEREK</div>
                        <div class="home-block-content mCustomScrollbar"
                             data-mcs-theme="inset-3">
                            <p><span style="font-size:1em"><strong>IEREK – International Experts for Research Enrichment and Knowledge Exchange</strong><span style="font-size:1em"> – is an international institution that is concerned with the exchange of knowledge and enhancing research through organizing and managing conferences in all fields of knowledge.</span></span>
                            </p>
                            <p style="text-align:justify"><span style="font-size:1em">Moreover, Ierek offers workshops and Conferences in various disciplines for all professionals. These professional events are unique in the practical way they are delivered and in the certified professionals who teach them.</span>
                            </p>
                            <p style="text-align:justify"><span style="font-size:1em">Our institution continues its activities through organizing and activating scientific programs to spread science and to develop skills on all local and international levels through its headquarters in Egypt and through our partners throughout the world.</span>
                            </p>
                            <p style="text-align:justify"><span style="font-size:1em">We also process the work for online publishing throughout our international journal and Ierek Electronic Library.</span>
                            </p>
                            <p style="text-align:justify"><span style="font-size:1em">Ierek activities are not only confined to these majors but also include cultural, social, and recreational aspects that would be available in all the events Ierek sponsors, standing by its belief that we all live in one world.</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- first row --}}
            <div class="row latest-news-section">
                <div class="col-12 col-md-12 home-blocks-container">
                    <div class="col-md-4 main-container">
                        <div class="home-block-container">
                            <div class="home-block-title brown">Latest News &amp; Blog</div>
                            <div class="home-block-content mCustomScrollbar" data-mcs-theme="inset-3">
                                <?php
                                @$rss = new DOMDocument();
                               
                                @$rss->load('https://www.ierek.com/news/index.php/feed/');
                                
                            

                                $feed = array();
                                foreach ($rss->getElementsByTagName('item') as $node) {
                                    $item = array(
                                        'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                                        'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                                        'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                                        'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
                                    );
                                    array_push($feed, $item);
                                 
                                }
                                
                                // print_r(get_loaded_extensions());
                          
                               
                                $limit = 10;
                                for($x = 0;$x < $limit;$x++) {
                                $title = str_replace(' & ', ' &amp; ', @$feed[$x]['title']);
                                $link = @$feed[$x]['link'];
                                $description = @$feed[$x]['desc'];
                                $desc = substr(@$description, 0, 100);
                                $desc = preg_replace("/[\s-]+/", " ", @$desc);
                                $date = date('l F d, Y', strtotime(@$feed[$x]['date']));
                                ?>
                                <div class="home-block-item">
                                    <div class="news-list-item">
                                        <div class="news-list-title"><?php echo @$title; ?></div>
                                        <div>
                                            <p style="font-size: 12px !important;"><?php echo @$desc; ?></p>
                                        </div>
                                        <p>
                                            <small><?php echo @$date; ?></small>
                                        </p>
                                        <div class="news-list-link">
                                            <a class="btn btn-primary btn-sm" style="color:#fff"
                                               href="<?php echo @$link; ?>">Read More</a>
                                            <br>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 main-container">
                        <div class="home-block-container">
                            <div class="home-block-title brown">Latest Videos</div>
                            <div class="home-block-content mCustomScrollbar" style="height:400px">
                                @if(isset($videos) && count($videos) > 0)
                                    @foreach($videos as $v)
                                        <?php echo $v->url; ?>
                                    @endforeach
                                @else
                                    <iframe width="100%" height="160px" src="https://www.youtube.com/embed/aJVm7pR3KY0"
                                            frameborder="0" allowfullscreen=""></iframe>
                                    <iframe width="100%" height="160px" src="https://www.youtube.com/embed/1ToFsJB_Pbk"
                                            frameborder="0" allowfullscreen=""></iframe>
                                    <iframe width="100%" height="160px" src="https://www.youtube.com/embed/H0UqOCFiSRA"
                                            frameborder="0" allowfullscreen=""></iframe>
                                    <iframe width="100%" height="160px" src="https://www.youtube.com/embed/Wk1AsItgDR4"
                                            frameborder="0" allowfullscreen=""></iframe>
                                    <iframe width="100%" height="160px"
                                            src="https://www.youtube.com/embed/ZhMVujaITWE?list=PLfd97LjbR12m-bjlqre8a6nSgKJRjo4X7"
                                            frameborder="0" allowfullscreen=""></iframe>
                                    <iframe width="100%" height="160px" src="https://www.youtube.com/embed/4w3pwA26hIA"
                                            frameborder="0" allowfullscreen=""></iframe>
                                    <iframe width="100%" height="160px" src="https://www.youtube.com/embed/LId5pHXs1as"
                                            frameborder="0" allowfullscreen=""></iframe>
                                    <iframe width="100%" height="160px" src="https://www.youtube.com/embed/6sTcgS1u0ZI"
                                            frameborder="0" allowfullscreen=""></iframe>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 main-container">
                        <div class="home-block-container third-img-first-row-home">
                            <a href="{{$announcements[1]->announce_url}}"  target="_blank"><img src="{{asset('/storage/uploads/announcement/'.$announcements[1]->announce_image)}}"
                                                              style="width: 100%; height:350px"></a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- second row --}}
            <div class="row latest-news-section">
                <div class="col-12 col-md-12 home-blocks-container">
                    <div class="col-md-4 main-container">
                        <div class="home-block-container home-block-content">
                            <a href="{{$announcements[2]->announce_url}}"  target="_blank"><img src="{{asset('/storage/uploads/announcement/'.$announcements[2]->announce_image)}}"
                                                                    style="width: 100%; height:300px"></a>
                        </div>
                    </div>
                    <div class="col-md-4 main-container">
                        <div class="home-block-container home-block-content">
                            <a href="{{$announcements[3]->announce_url}}"  target="_blank"><img src="{{asset('/storage/uploads/announcement/'.$announcements[3]->announce_image)}}"
                                                                    style="width: 100%; height:300px"></a>
                        </div>
                    </div>
                    <div class="col-md-4 main-container">
                        <div class="home-block-container home-block-content">
                            <div class="home-block-title brown">IEREK Newsletter</div>
                            <div class="home-block-content newsletterContent" style="height:271px !important;">
                                <div class="newsletter-form">
                                    <p class="help-block">Subscribe to our newsletter</p>
                                    <form method="post" id="nlform">
                                        <input type="hidden" name="nr" value="widget">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="nn" name="name"
                                                   placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="email" id="ne" required="" name="email"
                                                   placeholder="Email">
                                        </div>
                                        <div class="form-group newsletter-btn">
                                            <input class="btn btn-primary" type="button" value="Subscribe"
                                                   id="newsletter">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- third row --}}
            <div class="home-blocks-container">
                <div class="row latest-news-section">
                    <div class="col-md-12">
                        <div class="home-block-container">
                            <div class="home-block-title brown">Partners</div>
                            <div class="home-block-content mCustomScrollbar" style="height:215px !important;"
                                 id="partnersLogos">

                               @foreach($partners as $p)                                    
                                <div class="partner"><img src="{{asset('/storage/uploads/partners/'.$p->img_path)}}"></div>
                                @endforeach                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection