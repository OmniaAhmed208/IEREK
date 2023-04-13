@extends('layouts.master')
@section('content')
    <style>
        .padri {
            margin-top: 70px;
        }

        .thum {
            border-top: 4px solid #AA822C;
            height: auto;
        }

        .scimg {
            border: 5px solid #ECECEC;
            box-shadow: 0 0 1px 1px #CBCBCB;
            border-radius: 23px;
            background: #fff;
            margin-top: -90px;
            -webkit-filter: grayscale(100%);
            filter: grayscale(100%);
            height: 110px;
            width: 110px;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row committee-container">
                    <?php if ($user->gender == 1 OR $user->gender == 0) {
                        $gender = 'male';
                    } elseif ($user->gender == 2) {
                        $gender = 'female';
                    } ?>
                    <div class="col-12 col-md-12">
                        <div class="committee-item" style="width:100%;display:table"><br>
                            <center>
                                <figure>
                                    <div style="background:url(
                                    @if($user->image == '')
                                            '/uploads/default_avatar_{{ $gender }}.jpg') no-repeat center center;
                                    @else
                                            '/storage/uploads/users/profile/{{ $user->image }}.jpg') no-repeat center center;
                                    @endif
                                            -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"
                                         class="scimg">

                                    </div>
                                </figure>
                            </center>
                            <div class="caption">
                                <center>
                                    <h1 style="    font-size: 20px;
    letter-spacing: 0px;
    font-weight: 500;">
                                        <a>{{ $user->first_name.' '.$user->last_name }}</a></h1>
                                </center>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                </div>
                <div class="row committee-container">
                    <div class="col-12 col-md-12">
                        <div class="styled-box" style="width:100%;display:table">
                            <div class="caption">
                                <div class="col-md-12" style="padding: 0 0 1em 0">
                                    <div><?php echo $user->biography; ?></div>
                                </div>
                                @if($user->cv != '')
                                    <div class="downloadCV-container">
                                        <a class="btn btn-primary" style="z-index: 10000!important"
                                           href="/storage/uploads/users/cv/{{ $user->cv }}">Download CV</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection