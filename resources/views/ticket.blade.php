<!<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Ticket</title>
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" />
       <style>
            section{width: 100%;display: flex;justify-content: center;align-items: center;
                overflow: hidden;
                position: relative;
                z-index: 0;
            }
            .qr-card{
                /* max-width: 460px; */
                background: #fff;
                box-shadow: 0px 0px 8px -4px black;
                border-radius: 5px;
                /* border: 4px #bbbbbb dashed; */
                position: relative;
                z-index: 22;
            }
            /* .line_maile{
                position: absolute;
                width: 100%;
            } */

            .line_maile{
                position: absolute;
                display: block;
                width: 100%;
                background: #0e293c;
                transform: skewY(32deg);
                z-index: 20;
                right: 0;
            }
            .head-card, .footer-card{
                padding: 10px;
                /* border-bottom: 2px solid #dadada; */
                /* color: #a88028; */
                color: #7d787e;
                text-align: center;
            }
            .head-card > img{
                max-width: 250px;
            }

            .ft-head{
                font-weight: 400;
            }

            .footer-card{
                border: none;
                /* border-top:  2px solid #dadada; */
                color: #7d787e;

            }   

            .qr_link a{
                display: inline-block;
                color: #7d787e;
                font-size: 29px;
                margin: 0 5px;
                transition: all 0.1s linear;
            }
            .qr_link a:hover{
                color: #a88028;
                transform: scale(1.4);
            }
 
            .tm-ierek{
                color: #a88028;
                display: inline-block;
            }
            .tm-ierek:hover{
                color: #a88028; 
            }
            .qr-item > div{
                margin: auto;
                transform: scale(.8);
                -webkit-transform: scale(.8);
                -o-transform: scale(.8);
                -moz-transform: scale(.8);
            }
        </style>
    </head>
    <body>
        <section class="row m-0">
            
            <!--__________________________ -->
            <div class="line_maile"></div>
            <!--__________________________ -->
            
            
        
            <div class="qr-card col-x-12">
                <div class="w-100 head-card px-3">
                    <img class="d-block mx-auto mb-3 img-fluid" src="https://www.ierek.com/IerekLogo.png" />
                    
          
                    <h5 class="ft-head">{{$eventTitle}}</h5>
                    <p class="mt-3 text-center"><span class="tm-ierek"> {{$start_date}} </span> and until <span  class="tm-ierek"> {{$end_date}}</span>. <br>Location, <span  class="tm-ierek">{{$location}}</span></p>
                </div>

               
               
                 <div class="w-100 qr-item p-3">
                    {!!DNS2D::getBarcodeHTML("{{$barcode}}", 'QRCODE')!!}

                </div>
                   
                     <!--<div  class="w-100 qr-item p-3">{!!DNS2D::getBarcodeHTML('{{$barcode}}', 'QRCODE')!!}</div>-->

            

                <div class="w-100 footer-card pt-3 ">
                    <p class="mt-3 text-center qr_link">
                        <a href="https://www.facebook.com/Ierek.Institute/"  target="_blank"> <i class="fab fa-facebook-square"></i></a>

                        <a href="https://twitter.com/ierek_institute" target="_blank"><i class="fab fa-twitter-square"></i></a>

                        <a href="https://www.linkedin.com/company/ierek-institution/" target="_blank"><i class="fab fa-linkedin"></i></a>

                        <a href="https://www.youtube.com/channel/UCVp7eGOwMqTYtEYYxJL0uow" target="_blank"><i class="fab fa-youtube-square"></i></a>
                     
                        <a href="https://www.instagram.com/ierek_institute/" target="_blank"><i class="fab fa-instagram"></i></a>

                        <a href="https://play.google.com/store/apps/details?id=com.makdev.ierek" target="_blank"><i class="fab fa-google-play"></i></a>

                    </p>
                    <p class="small">
                        Copyrights Reseved for <a class="tm-ierek" href="http://www.ierek.com" target="_blank">ierek.com</a> <br>
                        <a href="mailto:info@ierek-scholar.org" class="tm-ierek">info@ierek-scholar.org</a>
                    </p>
                </div>                
            </div>
        </section>

        <script>
            var qr_dom = document.querySelectorAll("section")[0],
                qr_back = document.getElementsByClassName("line_maile")[0]
            window.onload = function (){
                qr_dom.style.minHeight = window.innerHeight + "px";
                qr_back.style.minHeight = window.innerHeight + "px";
            }
        </script>
    </body>
</html>

















