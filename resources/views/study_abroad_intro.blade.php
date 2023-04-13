@extends('layouts.master')
@section('content')
    <div class="container">
        <figure class="cover-img">
            <img src="uploads/images/study_abroad_intro.jpg" alt=""/>
        </figure>

        <div class="margin-btm-30-mob study_abroad_intro">
            <div class="framed-box frame-box-mobile" style=" margin-bottom: 2%;">
                <div class="frame-title">
                    Brief Introduction
                </div>

                <div class="mCustomScrollbar">
                    <div class="studyAbroadDescription">
                        <?php echo $content->content; ?>
                    </div>
                    <div class="styled-box">
                        <div class="box-content">
                            <div id="forAuthors">
                                <div class="announcements">
                                    <div class="row">
                                        <div class="col-12 col-md-3">
                                            <div class="main-study-abroad-btn card-link">
                                                <a href="/study_abroad_categories#Summer-Schools">
                                                    <div class="title">
                                                        <h4>SUMMER SCHOOLS</h4>
                                                    </div>
                                                    <div class="description">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="description-icon"><img
                                                                            src="/front/images/study_abroad/summer.png"
                                                                            alt=""/></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="main-study-abroad-btn card-link">
                                                <a href="/study_abroad_categories#Winter-Schools">
                                                    <div class="title">
                                                        <h4>WINTER SCHOOLS</h4>
                                                    </div>
                                                    <div class="description">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="description-icon"><img
                                                                            src="/front/images/study_abroad/winter.png"
                                                                            alt=""/></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="main-study-abroad-btn card-link">

                                                <a href="/study_abroad_categories/undergraduate-studies">

                                                    <div class="title">
                                                        <h4>UNDERGRADUATE STUDIES</h4>
                                                    </div>
                                                    <div class="description">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="description-icon"><img
                                                                            src="/front/images/study_abroad/undergrad.png"
                                                                            alt=""/></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="main-study-abroad-btn card-link">
                                                <a href="/study_abroad_categories#Postgraduate-Studies">

                                                    <div class="title">
                                                        <h4>POSTGRADUATE STUDIES</h4>
                                                    </div>
                                                    <div class="description">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="description-icon"><img
                                                                            src="/front/images/study_abroad/postgrad.png"
                                                                            alt=""/></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="styled-box">
                        <div class="box-content iframe-box">
                            <p style="text-align: justify;">
                                <iframe src="https://www.youtube.com/embed/4b7idNNviM0" width="100%" height="100%"
                                        frameborder="0" allowfullscreen="allowfullscreen"></iframe>
                            </p>
                        </div>
                    </div>
                    <div class="styled-box">
                        <div class="box-content">
                            <p style="text-align: center;"><span style="color: #a97f18; font-size: 1.2em;"><strong>Click on the below logos to learn more
            about
            the universities' programs available</strong> </span></p>
                            <div id="partnersLogos" class="home-block-content mCustomScrollbar"
                                 style="height: 233px !important;">
                                <div class="partner"><a title="UCAM" href="/files/shares/Universities/UCAM.pdf"
                                                        target="_blank" rel="noopener"><img
                                                src="http://www.ierek.com/study/UCAM.png" alt="UCAM"/></a></div>
                                <div class="partner"><a title="BTOS" href="/files/shares/Universities/BTOS.pdf"
                                                        target="_blank" rel="noopener"><img
                                                src="http://www.ierek.com/study/BTOS.png" alt=""/></a></div>
                                <div class="partner"><a title="KROK university"
                                                        href="/files/shares/Universities/Krok.pdf" target="_blank"
                                                        rel="noopener"><img
                                                src="http://www.ierek.com/study/Krok.jpg" alt=""/></a></div>
                                <div class="partner"><a title="Brentwood University"
                                                        href="/files/shares/Universities/Bentwood.pdf" target="_blank"
                                                        rel="noopener"><img
                                                src="http://www.ierek.com/study/Brentwood.jpg" alt=""/></a></div>
                                <div class="partner"><a
                                            title="Ntec - National Tertiary Education Consortium in New Zealand"
                                            href="/files/shares/Universities/Ntec.pdf"
                                            target="_blank" rel="noopener"><img
                                                src="http://www.ierek.com/study/NTec.png" alt=""/></a></div>
                                <div class="partner"><a title="Bangor University"
                                                        href="/files/shares/Universities/Bangor.pdf" target="_blank"
                                                        rel="noopener"><img src="http://www.ierek.com/study/Bangor.png"
                                                                            alt=""/></a></div>
                                <div class="partner"><a title="Universit&agrave; degli Studi di Palermo"
                                                        href="/files/shares/Universities/Palermo.pdf"
                                                        target="_blank" rel="noopener"><img
                                                src="http://www.ierek.com/study/palermo.png" alt=""/></a></div>
                                <div class="partner"><a title="RECAS" href="/files/shares/Universities/Recas.pdf"
                                                        target="_blank" rel="noopener"><img
                                                src="http://www.ierek.com/study/Recas.gif" alt=""/></a></div>
                                <div class="partner"><a title="Portugal University Admision"
                                                        href="/files/shares/Universities/Portugal%20UA.pdf"
                                                        target="_blank" rel="noopener"><img
                                                src="http://www.ierek.com/study/portugal.png" alt=""/></a></div>
                                
                                <div class="partner"><a title="Universit&agrave; degli Studi del Molise"
                                                        href="/files/shares/Universities/UNIMOL.pdf"
                                                        target="_blank" rel="noopener"><img
                                                src="http://www.ierek.com/study/Molise.png" alt=""/></a></div>
                                <div class="partner"><a title="Ohio Wesleyan University"
                                                        href="/files/shares/Universities/OWU.pdf" target="_blank"
                                                        rel="noopener"><img src="http://www.ierek.com/study/Ohio.jpg"
                                                                            alt=""/></a></div>
                                <div class="partner"><a title="Lincoln University | Christchurch, New Zealand"
                                                        href="/files/shares/Universities/Lincoln%20University.pdf"
                                                        target="_blank" rel="noopener"><img
                                                src="http://www.ierek.com/study/Lincoln.jpg" alt=""/></a></div>
                                <div class="partner"><a title="University of East London"
                                                        href="/files/shares/Universities/UEL.pdf" target="_blank"
                                                        rel="noopener"><img src="http://www.ierek.com/study/UEL.png"
                                                                            alt=""/></a></div>
                                <div class="partner"><a title="UNIVERSITY AGENTS NETWORKS"
                                                        href="http://www.ua-networks.com/" target="_blank"
                                                        rel="noopener"><img
                                                style="background-color: #ffffff; color: #626262;"
                                                src="http://www.ierek.com/study/UA.png"
                                                alt=""/></a></div>
                                <div class="partner"><a title="Universita degli Studi Roma Tre"
                                                        href="/files/shares/Universities/Roma%20Tre.pdf"
                                                        target="_blank" rel="noopener"><img
                                                src="http://www.ierek.com/study/Roma_Tre.png" alt=""/></a></div>
                                <div class="partner"><a title="UHECAS" href="/files/shares/Universities/UHECAS.pdf"
                                                        target="_blank" rel="noopener"><img
                                                src="/photos/shares/study/UHECAS.png" width="200" height="81"/></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="breifing hidden-xs hidden-sm">
                <div class="quick-links" style="margin-bottom:10px;">
                    <ul id="menu-quick-links" class="menu">
                    </ul>
                </div>
                <figure class="hidden-xs hidden-sm">
                </figure>

            </div>
        </div>
    </div>
@endsection