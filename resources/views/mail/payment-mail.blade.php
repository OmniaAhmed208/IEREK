<?php $host = "https://www.ierek.com"; ?>
<html style="margin:0;padding:0">
<head>
    <style>
        .barcode-generator{
            text-align: center;
        }

    </style>
</head>



<div style="margin:0;padding:0;width:100%;margin:0 auto;height:auto;background-position:top;background-repeat:repeat-x;background-image:url(<?php echo $host; ?>/mailbg2.jpg);background-size:cover">

    <center><img src="<?php echo $host; ?>/IerekLogo.png" alt="logo"></center>

    <div style="width:80%;;margin:0 auto;font-family:Verdana;background:rgba(255,255,255,0.7);padding:10px;padding-bottom:40px;color:#666;border:1px solid #999;">
        <div style="width:90%;margin:0 auto ;">



            <h3 style="text-align:center">
                You are now registered in this conference.
            </h3>
            <h3 style="text-align:center">

            This ticket includes the details needed for registration at the conference.
            </h3>
            <h3 style="text-align:center">

            Do not forget to print and bring it with you!

            <h3 style="text-align:center">

            If you face any technical issues, please contact us on: info@ierek-scholar.org
            </h3>











                <tr>
                    <td  style="padding:8px;" class='barcode-generator'>link</td>


                    <a href="{{$link}}"> click here to  show your ticket  </a>
                </tr>









            {{--</table>--}}

        </div>

    </div>


    <div style="width:90%;height:100px;padding:1em;margin:0 auto;">
        <center><a href="https://www.facebook.com/Ierek.Institute/"><img src="<?php echo $host; ?>/social/fb.png"></a>&ensp;<a href="https://twitter.com/ierek_institute"><img src="<?php echo $host; ?>/social/tw.png"></a>&ensp;<a href="https://www.linkedin.com/company/ierek-institution/"><img src="<?php echo $host; ?>/social/li.png"></a>&ensp;<a href="https://www.youtube.com/channel/UCVp7eGOwMqTYtEYYxJL0uow"><img src="<?php echo $host; ?>/social/yo.png"></a>&ensp;<a href="https://www.instagram.com/ierek_institute/"><img src="<?php echo $host; ?>/social/in.png"></a>&ensp;<a href="https://play.google.com/store/apps/details?id=com.makdev.ierek"><img src="<?php echo $host; ?>/social/pl.png"></a><br>
            <small style="color:#999">Copytights Reserved for IEREK.COM<br>info@ierek-scholar.org</small>
        </center>
    </div>
</div>
</html>