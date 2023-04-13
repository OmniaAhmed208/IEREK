@extends('layouts.master')
@section('content')
    <style type="text/css">
        .msgs-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .msgs-list li {
            margin: 0;
            padding: 0.75em;
            min-height: 60px;
            border-bottom: 1px solid #f1f1f1;
            cursor: pointer;
            border-left: 3px #e9e9e9 solid;
        }

        .msgs-list li.active {
            background: #f1f1f1;
            border-left: 3px #e7e7e7 solid;
        }

        .msgs-list li.active:hover {
            background: #f1f1f1;
            border-left: 3px #e7e7e7 solid;
            cursor: default;
        }

        .msgs-list li.unread {
            font-weight: 700;
        }

        .msgs-list li:hover {
            background: #f9f9f9;
            border-left: 3px #a97f18 solid;
        }
    </style>
    <script>
        (function (factory) {
            if (typeof define === 'function' && define.amd) {
                // AMD. Register as an anonymous module.
                define(['jquery'], factory);
            } else if (typeof module === 'object' && typeof module.exports === 'object') {
                factory(require('jquery'));
            } else {
                // Browser globals
                factory(jQuery);
            }
        }(function ($) {
            $.timeago = function (timestamp) {
                if (timestamp instanceof Date) {
                    return inWords(timestamp);
                } else if (typeof timestamp === "string") {
                    return inWords($.timeago.parse(timestamp));
                } else if (typeof timestamp === "number") {
                    return inWords(new Date(timestamp));
                } else {
                    return inWords($.timeago.datetime(timestamp));
                }
            };
            var $t = $.timeago;

            $.extend($.timeago, {
                settings: {
                    refreshMillis: 60000,
                    allowPast: true,
                    allowFuture: false,
                    localeTitle: false,
                    cutoff: 0,
                    autoDispose: true,
                    strings: {
                        prefixAgo: null,
                        prefixFromNow: null,
                        suffixAgo: "",
                        suffixFromNow: "now",
                        inPast: 'any moment now',
                        seconds: "few seconds",
                        minute: "minute ago",
                        minutes: "%d mins",
                        hour: "1 hour",
                        hours: "%d hrs",
                        day: "yesterday",
                        days: "%d days",
                        month: "month ago",
                        months: "%d months",
                        year: "year",
                        years: "%d years",
                        wordSeparator: " ",
                        numbers: []
                    }
                },

                inWords: function (distanceMillis) {
                    if (!this.settings.allowPast && !this.settings.allowFuture) {
                        throw 'timeago allowPast and allowFuture settings can not both be set to false.';
                    }

                    var $l = this.settings.strings;
                    var prefix = $l.prefixAgo;
                    var suffix = $l.suffixAgo;
                    if (this.settings.allowFuture) {
                        if (distanceMillis < 0) {
                            prefix = $l.prefixFromNow;
                            suffix = $l.suffixFromNow;
                        }
                    }

                    if (!this.settings.allowPast && distanceMillis >= 0) {
                        return this.settings.strings.inPast;
                    }

                    var seconds = Math.abs(distanceMillis) / 1000;
                    var minutes = seconds / 60;
                    var hours = minutes / 60;
                    var days = hours / 24;
                    var years = days / 365;

                    function substitute(stringOrFunction, number) {
                        var string = $.isFunction(stringOrFunction) ? stringOrFunction(number, distanceMillis) : stringOrFunction;
                        var value = ($l.numbers && $l.numbers[number]) || number;
                        return string.replace(/%d/i, value);
                    }

                    var words = seconds < 45 && substitute($l.seconds, Math.round(seconds)) ||
                        seconds < 90 && substitute($l.minute, 1) ||
                        minutes < 45 && substitute($l.minutes, Math.round(minutes)) ||
                        minutes < 90 && substitute($l.hour, 1) ||
                        hours < 24 && substitute($l.hours, Math.round(hours)) ||
                        hours < 42 && substitute($l.day, 1) ||
                        days < 30 && substitute($l.days, Math.round(days)) ||
                        days < 45 && substitute($l.month, 1) ||
                        days < 365 && substitute($l.months, Math.round(days / 30)) ||
                        years < 1.5 && substitute($l.year, 1) ||
                        substitute($l.years, Math.round(years));

                    var separator = $l.wordSeparator || "";
                    if ($l.wordSeparator === undefined) {
                        separator = " ";
                    }
                    return $.trim([prefix, words, suffix].join(separator));
                },

                parse: function (iso8601) {
                    var s = $.trim(iso8601);
                    s = s.replace(/\.\d+/, ""); // remove milliseconds
                    s = s.replace(/-/, "/").replace(/-/, "/");
                    s = s.replace(/T/, " ").replace(/Z/, " UTC");
                    s = s.replace(/([\+\-]\d\d)\:?(\d\d)/, " $1$2"); // -04:00 -> -0400
                    s = s.replace(/([\+\-]\d\d)$/, " $100"); // +09 -> +0900
                    return new Date(s);
                },
                datetime: function (elem) {
                    var iso8601 = $t.isTime(elem) ? $(elem).attr("datetime") : $(elem).attr("title");
                    return $t.parse(iso8601);
                },
                isTime: function (elem) {
                    // jQuery's `is()` doesn't play well with HTML5 in IE
                    return $(elem).get(0).tagName.toLowerCase() === "time"; // $(elem).is("time");
                }
            });

            // functions that can be called via $(el).timeago('action')
            // init is default when no action is given
            // functions are called with context of a single element
            var functions = {
                init: function () {
                    var refresh_el = $.proxy(refresh, this);
                    refresh_el();
                    var $s = $t.settings;
                    if ($s.refreshMillis > 0) {
                        this._timeagoInterval = setInterval(refresh_el, $s.refreshMillis);
                    }
                },
                update: function (timestamp) {
                    var date = (timestamp instanceof Date) ? timestamp : $t.parse(timestamp);
                    $(this).data('timeago', {datetime: date});
                    if ($t.settings.localeTitle) {
                        $(this).attr("title", date.toLocaleString());
                    }
                    refresh.apply(this);
                },
                updateFromDOM: function () {
                    $(this).data('timeago', {datetime: $t.parse($t.isTime(this) ? $(this).attr("datetime") : $(this).attr("title"))});
                    refresh.apply(this);
                },
                dispose: function () {
                    if (this._timeagoInterval) {
                        window.clearInterval(this._timeagoInterval);
                        this._timeagoInterval = null;
                    }
                }
            };

            $.fn.timeago = function (action, options) {
                var fn = action ? functions[action] : functions.init;
                if (!fn) {
                    throw new Error("Unknown function name '" + action + "' for timeago");
                }
                // each over objects here and call the requested function
                this.each(function () {
                    fn.call(this, options);
                });
                return this;
            };

            function refresh() {
                var $s = $t.settings;

                //check if it's still visible
                if ($s.autoDispose && !$.contains(document.documentElement, this)) {
                    //stop if it has been removed
                    $(this).timeago("dispose");
                    return this;
                }

                var data = prepareData(this);

                if (!isNaN(data.datetime)) {
                    if ($s.cutoff === 0 || Math.abs(distance(data.datetime)) < $s.cutoff) {
                        $(this).text(inWords(data.datetime));
                    } else {
                        if ($(this).attr('title').length > 0) {
                            $(this).text($(this).attr('title'));
                        }
                    }
                }
                return this;
            }

            function prepareData(element) {
                element = $(element);
                if (!element.data("timeago")) {
                    element.data("timeago", {datetime: $t.datetime(element)});
                    var text = $.trim(element.text());
                    if ($t.settings.localeTitle) {
                        element.attr("title", element.data('timeago').datetime.toLocaleString());
                    } else if (text.length > 0 && !($t.isTime(element) && element.attr("title"))) {
                        element.attr("title", text);
                    }
                }
                return element.data("timeago");
            }

            function inWords(date) {
                return $t.inWords(distance(date));
            }

            function distance(date) {
                return (new Date().getTime() - date.getTime());
            }

            // fix for IE6 suckage
            document.createElement("abbr");
            document.createElement("time");
        }));
    </script>
    <div class="container">
        <div class="panel panel-default view-profile-notifications" id="view-profile">
            <div class="panel-heading">
                <h3 class="panel-title">Notifications</h3>
            </div>
            <div class="panel-body" style="background:#f9f9f9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-body"
                                 style="padding:0;margin:0;max-height:400px;overflow-y:scroll">
                                <div class="row" style="padding:0;margin:0">
                                    <ul class="msgs-list">
                                        @foreach($notifications as $n)

                                            <li id="li-msg{{$n->notification_id}}" data-title="{{$n->title}}"
                                                data-md="li-msg{{$n->notification_id}}"
                                                class="aMsg @if($n->read == 0) unread @endif"
                                                onclick="getMessage({{$n->notification_id}})">
                                                <a href="#message" style="display:inline-block;"><i
                                                            style="color:rgba(255,255,255,0.99); line-height: 30px;text-shadow: 0 0 3px rgba(0,0,0,0.5) ;text-align: center; vertical-align: middle; width: 30px; height: 30px; border-radius: 50% ;background-color: {{$n->color}};"
                                                            class="fa fa-{{$n->icon}}"></i> {{$n->title}}</a><br>
                                                <div class="pull-right" style="display:inline-block; font-size: 13px">
                                                    <time class="timeago" datetime="{{$n->created_at}}"></time>
                                                </div>
                                                <br><i style="font-family: Tahoma!important;    font-size: 12px!important;
    color: grey;float:right;font-style: normal;font-weight: 300!important">{{date('jS F, Y h:i A' ,strtotime($n->created_at))}}</i>
                                                <p style="white-space: pre-wrap; padding:0em 1em"
                                                   id="body{{$n->notification_id}}" class="nbody"></p>
                                                <div class="clearfix"></div>
                                                <a class="btn pull-right" onclick="deleteMsg({{$n->notification_id}});"><i
                                                            class="fa fa-times" style="color:red"></i></a><a
                                                        class="btn pull-right" href="{{$n->url}}"><i
                                                            class="fa fa-link"></i></a>
                                                <div class="clearfix"></div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var curMsg;
        var curTitle;
        var gettingMsg = 0;

        function getMessage(id) {
            if (gettingMsg == 0) {
                $.ajax({
                    type: 'GET',
                    url: '/notifications/body/' + id,
                    dataType: 'json',
                    timeOut: 10000,
                    beforeSend: function () {
                        gettingMsg = 1;
                        $('#body' + id).html('<center><img src="loading.gif"></center>');
                    },
                    success: function (response) {
                        if (response.success == true) {
                            var target = document.getElementById('logs');
                            var result = response.result;
                            try {
                                json = JSON.parse(result['description']);
                                json = JSON.stringify(json);
                                json = json.replace(/<:/g, '</td></tr><tr><td><span>');
                                json = json.replace(/:>/g, '</span>');
                                json = json.replace(/{/g, '');
                                json = json.replace(/}/g, '');
                                json = json.replace(/,/g, '');
                                json = json.replace(/"/g, '');
                                json = json.replace(/:/g, '');
                                json = json.replace(/&&/g, '<td style="background:rgba(0,255,0,0.05)">');
                                json = json.replace(/##/g, '</td><td style="background:rgba(255,0,0,0.05)">');
                                json = '<table class="table table-hover table-striped table-bordered"><thead><tr><th>Value</th><th><span style="color:green">New</span></th><th><span style="color:red">Old</span></th></tr></thead><tbody>' + json + '</tbody></table>'
                            } catch (e) {
                                json = result['description'];
                            }
                            $('.nbody').each(function () {
                                $(this).html('');
                            });
                            $('#body' + id).html('<br>' + json);
                            gettingMsg = 0;
                        }
                    },
                    error: function (response) {
                        informX('Your session was ended, please refresh the page.')
                    }
                });
            } else {
                informX('Be patient please, I am working to bring your notifications =)');
            }
        }

        $(document).ready(function () {
            $('.aMsg').each(function () {
                $(this).on('click', function () {
                    $('.aMsg').each(function () {
                        $(this).removeClass('active');
                    });
                    curMsg = $(this).data('md');
                    curTitle = $(this).data('title');
                    $(this).addClass('active');
                    $(this).removeClass('unread');
                });
            });
        });

        function deleteMsg(id) {

            var target = document.getElementById('body' + id);
            $.ajax({
                type: 'GET',
                url: '/notifications/delete/' + id,
                dataType: 'json',
                timeOut: 10000,
                beforeSend: function () {
                    $(target).html('<center><img src="loading.gif"></center>');
                },
                success: function (response) {
                    if (response.success == true) {
                        $('#li-msg' + id).toggle('slide', function () {
                            $('#li-msg' + id).remove()
                        });
                        //returnN('<i class="fa fa-trash"></i><small style="font-family: Tahoma!important"> Notification deleted successfully.</small>', '#666', 20000);


                    }
                },
                error: function (response) {
                    informX('Your session was ended, please refresh the page.')
                }
            });

        }

        $(document).ready(function () {
            $(".timeago").timeago();
        });
    </script>
@endpush