@extends('admin.layouts.master')

@section('content')
                    <!-- START WIDGETS -->                    
                    <div class="row">
                        <div class="col-md-4">
                            
                            <!-- START WIDGET SLIDER -->
                            <div class="widget widget-default widget-carousel" style="padding: 0!important">
                                <div class="owl-carousel" id="owl-example">
                                    <div class="widget widget-success" style="margin: 0!important">
                                        <div class="widget-item-left">
                                            <br>
                                            <span class="fa fa-dollar"></span>
                                        </div>                             
                                        <div class="widget-data">                                   
                                            <div class="widget-title" style="font-size: 22px!important">Payments</div>                                                
                                            <div class="widget-subtitle" style="color:#f9f9f9!important">This Week</div>
                                            <div class="widget-int">{{ $cPayments }}</div>
                                        </div>
                                    </div>
                                    <div class="widget widget-info" style="margin: 0!important">
                                        <div class="widget-item-left">
                                            <br>
                                            <span class="fa fa-bullhorn"></span>
                                        </div>                             
                                        <div class="widget-data">                                    
                                            <div class="widget-title" style="font-size: 22px!important">Conferences</div>
                                            <div class="col-md-12">
                                                <div class="widget-subtitle" style="color:#f9f9f9!important">New Registers</div>
                                                <div class="widget-int">{{$cConferences}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget widget-warning" style="margin: 0!important">
                                        <div class="widget-item-left">
                                            <br>
                                            <span class="fa fa-briefcase"></span>
                                        </div>                             
                                        <div class="widget-data">                                   
                                            <div class="widget-title" style="font-size: 22px!important">Workshops</div>
                                            <div class="col-md-12">
                                                <div class="widget-subtitle" style="color:#f9f9f9!important">New Registers</div>
                                                <div class="widget-int">{{$cWorkshops}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget widget-primary" style="margin: 0!important">
                                        <div class="widget-item-left">
                                            <br>
                                            <span class="fa fa-certificate"></span>
                                        </div>                             
                                        <div class="widget-data">                                    
                                            <div class="widget-title" style="font-size: 22px!important">Study Abroad</div>
                                            <div class="col-md-12">
                                                <div class="widget-subtitle" style="color:#f9f9f9!important">New Registers</div>
                                                <div class="widget-int">{{$cStudy}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                            
                                <div class="widget-controls" style="margin-top: -22px!important;padding-bottom: 22px">

                                </div>                         
                            </div>         
                            <!-- END WIDGET SLIDER -->
                            
                        </div>
                        <div class="col-md-4">
                            
                            <div class="widget widget-default widget-carousel" style="padding: 0!important">
                                <div class="owl-carousel" id="owl-example">
                                    <div class="widget widget-danger" style="margin: 0!important;cursor: pointer;">
                                        <div class="widget-item-left">
                                            <span class="fa fa-envelope"></span>
                                        </div>                             
                                        <div class="widget-data">
                                            <div class="widget-int num-count">{{$messages}}</div>
                                            <div class="widget-title">New messages</div>
                                            <div class="widget-subtitle" style="color:#f9f9f9!important">In your contact us</div>
                                        </div>    
                                    </div>
                                    <div class="widget widget-warning" style="margin: 0!important;cursor: pointer;">
                                        <div class="widget-item-left">
                                            <span class="fa fa-bell"></span>
                                        </div>                             
                                        <div class="widget-data">
                                            <div class="widget-int num-count">{{$notifications}}</div>
                                            <div class="widget-title">New notifications</div>
                                            <div class="widget-subtitle" style="color:#f9f9f9!important">Unread</div>
                                        </div>    
                                    </div>
                                </div>                            
                                <div class="widget-controls" style="margin-top: -22px!important;padding-bottom: 22px">

                                </div>  
                            </div>
                            <!-- START WIDGET MESSAGES -->
                            
                        </div>
                        <div class="col-md-4">
                            
                            <!-- START WIDGET CLOCK -->
                            <div class="widget widget-default widget-padding-sm" style="cursor: default!important;background-color: gold!important">
                                <div class="widget-big-int plugin-clock">00:00</div>                            
                                <div class="widget-subtitle plugin-date">Loading...</div>
                                <div class="widget-controls">                                
                                    
                                </div>                            
                                <div class="widget-buttons widget-c3"  style="padding: 13.5px 0">
                                    <div class="col">
                                        <a href="/admin/all-users/profile/{{Auth::user()->first_name}}"><span class="fa fa-cog"></span></a>
                                    </div>
                                    <div class="col">
                                        <a href="/admin/notifications"><span class="fa fa-bell"></span></a>
                                    </div>
                                    <div class="col">
                                        <a href="/admin/messages"><span class="fa fa-envelope"></span></a>
                                    </div>
                                </div>                            
                            </div>  
                            <!-- END WIDGET CLOCK -->
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                            <div class="widget widget-default widget-item-icon" style="cursor:pointer" onclick="location.href='/admin/all-users';">
                                <div class="widget-item-left">
                                    <span class="fa fa-user"></span>
                                </div>
                                <div class="widget-data">
                                    <div class="widget-int num-count">{{$users}}</div>
                                    <div class="widget-title">Registred users</div>
                                    <div class="widget-subtitle">This week</div>
                                </div>                          
                            </div>                            
                            <!-- END WIDGET REGISTRED -->
                            
                        </div>
                        

                        <div class="col-md-3">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-default widget-item-icon">
                                <div class="widget-item-left">
                                    <span class="fa fa-users"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" style="font-size: 16px!important">Users</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/all-users/create';">Add User</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/all-users';">All Users</div>
                                </div>      
                                <div class="widget-controls"> 

                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
                            
                        </div>

                        <div class="col-md-3">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-default widget-item-icon">
                                <div class="widget-item-left">
                                    <span class="fa fa-trophy"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" style="font-size: 16px!important">Admins</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/users/admins/make';">Make</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/users/admins';">Manage</div>
                                </div>      
                                <div class="widget-controls"> 

                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
                            
                        </div>

                        <div class="col-md-3">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-default widget-item-icon">
                                <div class="widget-item-left">
                                    <span class="fa fa-user"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" style="font-size: 16px!important">Scientific Committee</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/users/scientific/make';">Make</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/users/scientific';">Manage</div>
                                </div>      
                                <div class="widget-controls"> 

                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-info widget-item-icon">
                                <div class="widget-item-left">
                                    <span class="fa fa-bullhorn"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" style="font-size: 22px!important">Conferences</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/events/conference/create';">Create</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/events/conference';">Manage</div>
                                </div>      
                                <div class="widget-controls"> 

                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
                            
                        </div>
                        <div class="col-md-4">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-warning widget-item-icon">
                                <div class="widget-item-left">
                                    <span class="fa fa-briefcase"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" style="font-size: 22px!important">Workshops</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/events/workshop/create';">Create</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/events/workshop';">Manage</div>
                                </div>      
                                <div class="widget-controls"> 

                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
                            
                        </div>

                        <div class="col-md-4">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-primary widget-item-icon">
                                <div class="widget-item-left">
                                    <span class="fa fa-certificate"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" style="font-size: 22px!important">Study Abroad</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/events/studyabroad/create';">Create</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/events/studyabroad';">Manage</div>
                                </div>      
                                <div class="widget-controls"> 

                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-danger widget-item-icon">
                                <div class="widget-item-left">
                                    <span class="fa fa-book"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" style="font-size: 22px!important">Book Series</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/events/bookseries/create';">Create</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/events/bookseries';">Manage</div>
                                </div>      
                                <div class="widget-controls"> 

                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
                            
                        </div>
                        <div class="col-md-4">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-default widget-item-icon">
                                <div class="widget-item-left">
                                    <span class="fa fa-graduation-cap"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" style="font-size: 22px!important">Studies</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/events/studies';">Manage</div>
                                </div>      
                                <div class="widget-controls"> 

                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
                            
                        </div>
                        <div class="col-md-4">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-success widget-item-icon">
                                <div class="widget-item-left">
                                    <span class="fa fa-dollar"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count">Payments</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/payments/create';">Add New</div>
                                    <div class="widget-title" style="cursor:pointer" onclick="location.href='/admin/payments';">Manage</div>
                                </div>      
                                <div class="widget-controls"> 

                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
                            
                        </div>
                    </div>
                    <!-- END WIDGETS -->     
@endsection
