@extends('layouts.master')
@section('content')
    <div id="CONDETAILP">
        <div class="container">
            <div class="col-md-12 order">
                <div class="panel myAbstracts">
                    <div class="panel-heading">
                        <h4>MY ABSTRACTS</h4>
                    </div>
                    @for($i = 0; $i < sizeof($abstracts); $i++)
                        <div class="panel-body" id="">
                            <table class="table table-hover">
                                <div class="caption-div">
                                    <div class="caption-div-inner">
                                        <div>
                                            <h3>
                                                {{ $abstracts[$i]['title'] }}
                                            </h3>
                                        </div>
                                        <div>
                                        <div class="go-to-event grayscaled"
                                              onclick="window.open('{{ url('/events/'.$abstracts[$i]['slug']) }}', '_self')">                                         Go To Event
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Submission Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Payment</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $count = sizeof($abstracts[$i]) - 2; ?>
                                @for($ii = 0; $ii < $count; $ii++)
                                    <tr>
                                        <?php
                                        $status = array(
                                            0 => 'Abstract Pending Approval',
                                            1 => 'Abstract Under Revision',
                                            2 => 'Abstract Accetped',
                                            3 => 'Upload Your Full Paper',
                                            4 => 'Full Paper Pending Approval',
                                            5 => 'Full Paper Approved',
                                            6 => 'Full Paper Awaiting Reviewers Decision',
                                            7 => 'Full Paper Accetped',
                                            8 => 'Full Paper Rejected',
                                            9 => 'Abstract Rejected'
                                        );
                                        $payment = array(
                                            0 => '<a href="/abstract/status/' . $abstracts[$i][$ii]['id'] . '" class="go-to-event">View</a></td><td>',
                                            1 => '<a href="/abstract/status/' . $abstracts[$i][$ii]['id'] . '" class="go-to-event">View</a></td><td><a class="go-to-event" href="/payment/' . $abstracts[$i]['slug'] . '">Pay Fees</a>',
                                            2 => '<a href="/abstract/status/' . $abstracts[$i][$ii]['id'] . '" class="go-to-event">Upload</a></td><td><a class="go-to-event" href="/payment/' . $abstracts[$i]['slug'] . '">Pay Fees</a>',
                                            3 => '<a class="go-to-event" href="/abstract/status/' . $abstracts[$i][$ii]['id'] . '">View</a></td><td><a class="go-to-event" href="/payment/' . $abstracts[$i]['slug'] . '">Pay Fees</a>',
                                            4 => '<a class="go-to-event" href="/fullpaper/status/' . $abstracts[$i][$ii]['id'] . '">View</a></td><td><a class="go-to-event" href="/payment/' . $abstracts[$i]['slug'] . '">Pay Fees</a>',
                                            4 => '<a class="go-to-event" href="/fullpaper/status/' . $abstracts[$i][$ii]['id'] . '">View</a></td><td><a class="go-to-event" href="/payment/' . $abstracts[$i]['slug'] . '">Pay Fees</a>',
                                            5 => '<a class="go-to-event" href="/fullpaper/status/' . $abstracts[$i][$ii]['id'] . '">View</a></td><td><a class="go-to-event" href="/payment/' . $abstracts[$i]['slug'] . '">Pay Fees</a>',
                                            6 => '<a class="go-to-event" href="/fullpaper/status/' . $abstracts[$i][$ii]['id'] . '">View</a></td><td>',
                                            7 => '<a class="go-to-event" href="/fullpaper/status/' . $abstracts[$i][$ii]['id'] . '">View</a></td><td>',
                                            8 => '<a class="go-to-event" href="/fullpaper/status/' . $abstracts[$i][$ii]['id'] . '">View</a></td><td>',
                                            9 => '<a class="go-to-event" href="/abstract/status/' . $abstracts[$i][$ii]['id'] . '">View</a></td><td>'
                                        );
                                        ?>
                                        <td width="30%">{{ $abstracts[$i][$ii]['title'] }}</td>
                                        <td width="25%">{{ $abstracts[$i][$ii]['created_at'] }}</td>
                                        <td width="25%"><?php echo $status[$abstracts[$i][$ii]['status']]; ?></td>
                                        <td width="10%">
                                            <?php echo $payment[$abstracts[$i][$ii]['status']]; ?>
                                        </td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <style type="text/css">
        .btn-defaultx {
            background: #0c3852 !important;
            color: #fff !important;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-defaultx:hover {
            background: #a97f18 !important;
            color: #000;
        }

        .evgo {
            float: right;
            margin-right: 10px;
            margin-top: -30px;
        }
    </style>
@endpush
@push('scripts')
@endpush