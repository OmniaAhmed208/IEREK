<?php $host = "https://www.ierek.com"; ?>
<html style="margin:0;padding:0">
<head></head>
<div style="margin:0;padding:0;width:100%;margin:0 auto;height:auto;background-position:top;background-repeat:repeat-x;background-image:url(<?php echo $host; ?>/mailbg2.jpg);background-size:cover">

    <center><img src="<?php echo $host; ?>/IerekLogo.png" alt="logo"></center>

    <div style="width:80%;;margin:0 auto;font-family:Verdana;background:rgba(255,255,255,0.7);padding:10px;padding-bottom:40px;color:#666;border:1px solid #999;">
        <div style="width:90%;margin:0 auto ;">
            <h3 style="text-align:center">Form Application</h3>

            <table border="1" style="margin:0 auto;">
                <tr>
                    <td  style="padding:8px;">Event</td>
                    <td style="padding:8px;">{{$eventName}}</td>
                </tr>
                <tr>
                    <td  style="padding:8px;">The undersigned (FORENAME, SURNAME)</td>
                    <td style="padding:8px;">{{$app_undersigned_name}}</td>
                </tr>
                <tr>
                    <td style="padding:8px;">Date of birth</td>
                    <td style="padding:8px;">{{$app_date_birth_day}}</td>

                </tr>
                <tr>
                    <td style="padding:8px;">City</td>
                    <td style="padding:8px;">{{$app_city}}</td>

                </tr>
                <tr>
                    <td style="padding:8px;">State</td>
                    <td style="padding:8px;">{{$app_state}}</td>

                </tr>

                <tr>
                    <td style="padding:8px;">State of residence</td>
                    <td style="padding:8px;">{{$app_state_of_residence}}</td>

                </tr>

                <tr>
                    <td style="padding:8px;">Permanent address</td>
                    <td style="padding:8px;">{{$app_permanent_address}}</td>

                </tr>

                <tr>
                    <td style="padding:8px;">Email</td>
                    <td style="padding:8px;">{{$app_email}}</td>

                </tr>

                <tr>
                    <td style="padding:8px;">Signature</td>
                    <td style="padding:8px;">{{$app_signature}}</td>

                </tr>

            </table>

        </div>

    </div>


    <div style="width:90%;height:100px;padding:1em;margin:0 auto;">
        <center><a href="https://www.facebook.com/Ierek.Institute/"><img src="<?php echo $host; ?>/social/fb.png"></a>&ensp;<a href="https://twitter.com/ierek_institute"><img src="<?php echo $host; ?>/social/tw.png"></a>&ensp;<a href="https://www.linkedin.com/company/ierek-institution/"><img src="<?php echo $host; ?>/social/li.png"></a>&ensp;<a href="https://www.youtube.com/channel/UCVp7eGOwMqTYtEYYxJL0uow"><img src="<?php echo $host; ?>/social/yo.png"></a>&ensp;<a href="https://www.instagram.com/ierek_institute/"><img src="<?php echo $host; ?>/social/in.png"></a>&ensp;<a href="https://play.google.com/store/apps/details?id=com.makdev.ierek"><img src="<?php echo $host; ?>/social/pl.png"></a><br>
            <small style="color:#999">Copytights Reserved for IEREK.COM<br>info@ierek-scholar.org</small>
        </center>
    </div>
</div>
</html>