@extends('layouts.master')
@section('content')
<style>
	.padri{
		margin-top: 70px;
	}
	.thum{
		border-top:4px solid #AA822C;
		height:270px;
	}
	.scimg{
		border: 5px solid #ECECEC;
		box-shadow: 0 0 1px 1px #CBCBCB;
		border-radius: 23px;
		background: #fff;
		margin-top: -90px;
		-webkit-filter: grayscale(100%);
		filter: grayscale(100%);
		height:110px;
		width: 110px;
	}
</style>
<div class="container">
	<figure class="cover-img">
		<img src="uploads/images/sc.jpg" alt=""/>
	</figure>

	<div class="margin-btm-30-mob">
		<div class="framed-box frame-box-mobile" style=" margin-bottom: 2%;">
			<div class="frame-title">
				Brief Introduction
			</div>
			<div class="mCustomScrollbar brief-description">
                <?php echo @$content->content; ?>
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
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				@foreach($scs as $user)
					<?php if($user->gender == 1 OR $user->gender == 0){ $gender = 'male'; }elseif($user->gender == 2){ $gender = 'female'; } ?>
					<div class="col-sm-6 col-md-4 padri">
						<center>
						<div class="thumbnail thum"><br>
                                                    @if($user->slug != Null)
							<a  href="{{ url('comittee/'.$user->slug) }}" >
								<figure>
									<div style="background:url(@if($user->image == '') /uploads/default_avatar_{{ $gender }}.jpg @else /storage/uploads/users/profile/{{ $user->image }}.jpg @endif)  no-repeat center center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;" class="scimg"></div>
								</figure>
							</a>
                                                    
                                                    @endif
							<div class="caption">
								<h3><a @if($user->slug != '') href="{{ url('comittee/'.$user->slug) }}" @endif>{{ $user->first_name.' '.$user->last_name }}</a></h3>
								<p><?php echo substr($user->abbreviation, 0, 200) ?></p>
							</div>
						</div>
						</center>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	@endsection
                              