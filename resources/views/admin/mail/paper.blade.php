<?php $host = "https://www.ierek.com"; ?>
<html style="margin:0;padding:0">
	<head></head>
	<div style="margin:0;padding:0;width:100%;margin:0 auto;height:auto;background-position:top;background-repeat:repeat-x;background-image:url(<?php echo $host; ?>/mailbg2.jpg)">

		<center><img src="<?php echo $host; ?>/IerekLogo.png" alt="logo"></center>

		<div style="width:80%;height:auto;margin:0 auto;font-family:Verdana;background:rgba(255,255,255,0.7);padding:10px;color:#666;border:1px solid #999;">
			<div style="width:90%;margin:0 auto">
				<center><h1>{{$title}}</h1></center>
				<p style="white-space:wrap">
				Dear {{$name}},<br>


Thank you for being a reviewer with the IEREK community.<br>

A paper with the ID “{{$paper_code}}” has been submitted to the conference “{{$event_name}}”.<br>


IEREK invites you to review this paper, where the abstract has been put at the end of this email for your reference.<br>
					Please find below the link to accept or decline our request.<br>
					The link will be directing you to a second page in order to complete the process.<br>

Kindly  <a href="{{url('revision/paper')}}">Click Here</a>


 In case you accept our invitation,submit the review on:{{$expire_date}}
					<br>

We thank you for being a member of our IEREK scientific committee, and we look forward to your reply soon. 
Regards,
					<br>

Abstract :
					<br>
  {{$abstract_content}}

               Download paper link <a href="{{url('file/3/'.$paper_id)}}">Click Here</a>
               Download evaluation paper <a href="{{url('/evaluation-papers/evaluation-sheet.docx')}}">Click Here</a>
				</p>
			</div>
		</div>
		<div style="width:90%;height:100px;padding:1em;">
			<center><a href="https://www.facebook.com/Ierek.Institute/"><img src="<?php echo $host; ?>/social/fb.png"></a>&ensp;<a href="https://twitter.com/ierek_institute"><img src="<?php echo $host; ?>/social/tw.png"></a>&ensp;<a href="https://www.linkedin.com/company/ierek"><img src="<?php echo $host; ?>/social/li.png"></a>&ensp;<a href="https://www.youtube.com/channel/UCVp7eGOwMqTYtEYYxJL0uow"><img src="<?php echo $host; ?>/social/yo.png"></a>&ensp;<a href="https://www.instagram.com/ierek_institute/"><img src="<?php echo $host; ?>/social/in.png"></a>&ensp;<a href="https://play.google.com/store/apps/details?id=com.makdev.ierek"><img src="<?php echo $host; ?>/social/pl.png"></a><br>
			<small style="color:#999">Copytights Reserved for IEREK.COM<br>info@ierek-scholar.org</small>
			</center>
		</div>
	</div>
</html>