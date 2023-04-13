<?php $host = "https://www.ierek.com"; ?>
<html style="margin:0;padding:0">
	<head></head>
	<div style="margin:0;padding:0;width:100%;margin:0 auto;height:auto;background-position:top;background-repeat:repeat-x;background-image:url(<?php echo $host; ?>/mailbg2.jpg)">

		<center><img src="<?php echo $host; ?>/IerekLogo.png" alt="logo"></center>

		<div style="width:80%;height:auto;margin:0 auto;font-family:Verdana;background:rgba(255,255,255,0.7);padding:10px;color:#666;border:1px solid #999;">
			<div style="width:90%;margin:0 auto">
				<center><h2>{{$title}}</h2></center>
				<p style="font-size:14px">
				<?php echo $content; ?>
				</br>
				<p>
				From: {{$myname}} ({{$from}})<br>
				</p>
			</div>
		</div>
		<div style="width:90%;height:100px;padding:1em;">
			<center><a href="https://www.facebook.com/Ierek.Institute/"><img src="<?php echo $host; ?>/social/fb.png"></a>&ensp;<a href="https://twitter.com/ierek_institute"><img src="<?php echo $host; ?>/social/tw.png"></a>&ensp;<a href="https://www.linkedin.com/company/ierek-institution/"><img src="<?php echo $host; ?>/social/li.png"></a>&ensp;<a href="https://www.youtube.com/channel/UCVp7eGOwMqTYtEYYxJL0uow"><img src="<?php echo $host; ?>/social/yo.png"></a>&ensp;<a href="https://www.instagram.com/ierek_institute/"><img src="<?php echo $host; ?>/social/in.png"></a>&ensp;<a href="https://play.google.com/store/apps/details?id=com.makdev.ierek"><img src="<?php echo $host; ?>/social/pl.png"></a><br>
			<small style="color:#999">Copytights Reserved for IEREK.COM<br>info@ierek-scholar.org</small>
			</center>
		</div>
	</div>
</html>