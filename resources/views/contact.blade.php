@extends('layouts.master')
@section('content')
    <style>
        .sendErrors {
            color: red;
            font-size: 13px;
            display: none;
            transition: 0.5s;
        }
    </style>

    <div class="container">
        <figure class="cover-img">
            <img src="uploads/images/contact.jpg" alt=""/>
        </figure>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Contact Us</h3>
            </div>
            <div class="panel-body ierekpanel-b whitebackground">
                <div class="contacts-messages insidepanel insidepanel-styles">
                    <div style="display:none" class="bg-success message">
                        <strong>Thank You</strong><br>Your message has been successfully sent, we will get back to you
                        soon.
                    </div>
                    <form action="" method="post" name="cont_form" id="cont_form">
                        <div class="row">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" id="name"
                                           placeholder="Enter Your Name" value="">
                                    <span class="sendErrors nameError">Please Enter Your Name</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="email" id="email"
                                           placeholder="Enter Your E-mail" value="">
                                    <span class="sendErrors emailError">Please Enter Your Email</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="subject" autocomplete="off"
                                           id="sunbject" placeholder="Enter Subject" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control textarea" rows="6" name="message" id="message"
                                              placeholder="Your Message"></textarea>
                                    <span class="sendErrors messageError">Please Enter Your Message</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success pull-right" id="send">Send</button>
                                <img src="{{ url('loading.gif') }}" alt="Loading" style="display:none" id="send_gif">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-12">

                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Our Branches</h3>
            </div>
            <div class="panel-body ierekpanel-b whitebackground">
                <div class="container-fluid">
                    <div class="row">
                        <?php echo $content->content; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
    <script>
        $('#send').on('click', function (event) {
            event.preventDefault();
            var loading = document.getElementById('send_gif');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var formData = $('#cont_form').serialize();
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var message = document.getElementById('message').value;
            var err = 0;
            $('.sendErrors').each(function () {
                $(this).hide();
            });
            if (name == '') {
                $('.nameError').show();
                err = 1;
            }
            if (email == '') {
                $('.emailError').show();
                err = 1;
            }
            if (message == '') {
                $('.messageError').show();
                err = 1;
            }

            if (err == 0) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url("/contact-us/send") }}',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function (xhr) {
                        //loading ajax animation
                        $(loading).show();
                        $('.sendErrors').each(function () {
                            $(this).hide();
                        });
                    },
                    success: function (response) {
                        $(loading).hide();
                        returnN('Message Sent successfully', 'green', 10000);
                        $('input[type=text]').each(function () {
                            $(this).val('');
                        });
                        $('textarea').each(function () {
                            $(this).val('');
                        });
                    },
                    error: function (response) {
                        $(loading).hide();
                    }
                });
            }
        });
    </script>
@endpush