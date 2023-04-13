@extends('admin.layouts.master')
@section('panel-title')Events Settings @endsection
@section('content')
<div class="panel panel-default tabs">                            
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab-conference" role="tab" data-toggle="tab">Conference</a></li>
        <li><a href="#tab-workshop" role="tab" data-toggle="tab">Workshop</a></li>
        <li><a href="#tab-study-abroad" role="tab" data-toggle="tab">Study Abroad</a></li>

    </ul>
    <div class="panel-body tab-content">
                        <div class="tab-pane fade in active" id="tab-conference">
                            <div class="col-xs-2 col-md-3"> <!-- required for floating -->
                                <!-- Nav tabs -->
                                <ul class="nav nav-pills nav-stacked">
                                  <li class="active"><a href="#conf_categories" data-toggle="tab">Categories</a></li>
                                  <li><a href="#conf_payment" data-toggle="tab">Payment</a></li>
                                  <li><a href="#conf_dates" data-toggle="tab">Dates</a></li>
                                </ul>
                            </div>

                            <div class="col-xs-10 col-md-9">
                                <form>
                                <div class="tab-pane fade in active" id="conf_categories">
                                    <div class="row">
                                      <form id="category_form" role="form" method="post" class="form-horizontal">


                                        <div class="panel panel-default">


                                       <div class="panel-heading">
                                        <h3 class="panel-title"><strong>Add</strong> Event Category</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Category</label>
                                                    <div class="col-md-6 col-xs-12">                                                                                            
                                                        <select class="form-control select">
                                                            <option value="0">Choose Category</option>
                                                            <option value="1">Conferences</option>
                                                            <option value="2">Workshops</option>
                                                            <option value="3">Study Abroad</option>
                                                        </select>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>        
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Title</label>
                                                    <div class="col-md-6 col-xs-12">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon">En</span>
                                                            <input type="text" class="form-control" name="category_title">
                                                        </div>                                            
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Description</label>
                                                    <div class="col-md-6 col-xs-12">                                            
                                                        <textarea class="form-control" rows="3" name="category_description"></textarea>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Image</label>
                                                    <div class="col-md-6 col-xs-12">                                            
                                                        <div class="input-group">
                                                            <input type="file" id="image"/>
                                                        </div>                                            
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Title Arabic</label>
                                                    <div class="col-md-6 col-xs-12">                                            
                                                        <div class="input-group">
                                                            <input type="text" class="form-control ar" name="category_title_ar">
                                                            <span class="input-group-addon">ع</span>
                                                        </div>                                            
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Description Arabic</label>
                                                    <div class="col-md-6 col-xs-12">                                            
                                                        <textarea class="form-control ar" rows="6" name="category_description_ar"></textarea>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Image Arabic</label>
                                                    <div class="col-md-6 col-xs-12">                                            
                                                        <div class="input-group">
                                                            <input type="file" id="image_ar"/>
                                                        </div>                                            
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">                                    
                                           <button class="btn btn-primary pull-right">Add</button>
                                       </div>
                                   </div>
                                </form>
                            </div>


                                    <div class="row">
                                        <div class="panel panel-default">

                                            <div class="panel-heading">
                                                <h3 class="panel-title"><strong>Manage</strong> Categories</h3>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Title</th>
                                                            <th>Category</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>2016</td>
                                                            <td>Conferences</td>
                                                            <td>
                                                                <div class="btn-group dropup">
                                                                    <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Actions <span class="caret"></span></a>
                                                                    <ul class="dropdown-menu" role="menu">
                                                                        <li><a href="#">Delete</a></li>
                                                                        <li><a href="#">Edit</a></li>                                                  
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="tab-pane fade in" id="conf_payment">
                                    <div class="row">
                                        <form id="category_form" role="form" method="post" class="form-horizontal">


                                            <div class="panel panel-default">


                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><strong>Add</strong> Event Fees Type</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-md-3 col-xs-12 control-label">Category</label>
                                                            <div class="col-md-6 col-xs-12">                                                                                            
                                                                <select class="form-control select">
                                                                    <option value="0">Choose Category</option>
                                                                    <option value="1">Conferences</option>
                                                                    <option value="2">Workshops</option>
                                                                    <option value="3">Study Abroad</option>
                                                                </select>
                                                                <span class="help-block"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 col-xs-12 control-label">Fees Type</label>
                                                            <div class="col-md-6 col-xs-12">
                                                                <select class="form-control select"  name="fees_type_title">
                                                                    <option value="0">Choose Type</option>
                                                                    <option value="1">Attendant</option>
                                                                    <option value="2">Accomodation</option>
                                                                    <option value="3">Visa</option>
                                                                </select>
                                                                <span class="help-block"></span>                                        
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 col-xs-12 control-label">Fees For</label>
                                                            <div class="col-md-6 col-xs-12">
                                                                    <select class="form-control select"  name="fees_for_title">
                                                                        <option value="0">All</option>
                                                                        <option value="1">Regular</option>
                                                                        <option value="2">Author</option>
                                                                        <option value="3">Co-Author</option>
                                                                    </select>
                                                                    <span class="help-block"></span>                                        
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 col-xs-12 control-label">Options</label>
                                                            <div class="col-md-6 col-xs-12">         
                                                                <label class="check col-md-6"><input type="checkbox" class="icheckbox" /> Egyptian</label>
                                                                <label class="check col-md-6"><input type="checkbox" class="icheckbox" /> Required</label>
                                                                <label class="check col-md-6"><input type="checkbox" class="icheckbox" /> Early Bird</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6"> 
                                                        <div class="form-group">
                                                            <label class="col-md-3 col-xs-12 control-label">Title</label>
                                                            <div class="col-md-6 col-xs-12">                                            
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">En</span>
                                                                    <input type="text" class="form-control" name="category_title">
                                                                </div>                                            
                                                                <span class="help-block"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 col-xs-12 control-label">Description</label>
                                                            <div class="col-md-6 col-xs-12">                                            
                                                                <textarea class="form-control" rows="2" name="category_description"></textarea>
                                                                <span class="help-block"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 col-xs-12 control-label">Title Arabic</label>
                                                            <div class="col-md-6 col-xs-12">                                            
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control ar" name="category_title_ar">
                                                                    <span class="input-group-addon">ع</span>
                                                                </div>                                            
                                                                <span class="help-block"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 col-xs-12 control-label">Description Arabic</label>
                                                            <div class="col-md-6 col-xs-12">                                            
                                                                <textarea class="form-control ar" rows="2" name="category_description_ar"></textarea>
                                                                <span class="help-block"></span>
                                                            </div>
                                                        </div>
                                                    </div>   
                                                </div>
                                                <div class="panel-footer">                                    
                                                    <button class="btn btn-primary pull-right">Add</button>
                                                </div>
                                            </div>

                                        </form>

                                    </div>


                                    <div class="row">
                                        <div class="panel panel-default">

                                            <div class="panel-heading">
                                                <h3 class="panel-title"><strong>Manage</strong> Fees Types</h3>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Fees Type</th>

                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Close submittion</td>
                                                            <td>
                                                                <div class="btn-group dropup">
                                                                    <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Actions <span class="caret"></span></a>
                                                                    <ul class="dropdown-menu" role="menu">
                                                                        <li><a href="#">Delete</a></li>
                                                                        <li><a href="#">Edit</a></li>                                                  
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="conf_dates">
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Abstract Submissions Deadline</label>
                                                    <div class="col-md-6 col-xs-12"> 
                                                        <input type="number" class="form-control" min="0" name="">
                                                        <label class="help-block">Days before conference</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Last Notification for Abstract Acceptance</label>
                                                    <div class="col-md-6 col-xs-12"> 
                                                        <input type="number" class="form-control" min="0" name="">
                                                        <label class="help-block">Days before conference</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Early Payment Deadline</label>
                                                    <div class="col-md-6 col-xs-12"> 
                                                        <input type="number" class="form-control" min="0" name="">
                                                        <label class="help-block">Days before conference</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Full Paper Submission Deadline</label>
                                                    <div class="col-md-6 col-xs-12"> 
                                                        <input type="number" class="form-control" min="0" name="">
                                                        <label class="help-block">Days before conference</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Last Notification for Full-Paper Acceptance</label>
                                                    <div class="col-md-6 col-xs-12"> 
                                                        <input type="number" class="form-control" min="0" name="">
                                                        <label class="help-block">Days before conference</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Regular Payment Deadline</label>
                                                    <div class="col-md-6 col-xs-12"> 
                                                        <input type="number" class="form-control" min="0" name="">
                                                        <label class="help-block">Days before conference</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Late Payment Deadline</label>
                                                    <div class="col-md-6 col-xs-12"> 
                                                        <input type="number" class="form-control" min="0" name="">
                                                        <label class="help-block">Days before conference</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Final Issuing of Letter of Visa (for delegates who need visa entry)</label>
                                                    <div class="col-md-6 col-xs-12"> 
                                                        <input type="number" class="form-control" min="0" name="">
                                                        <label class="help-block">Days before conference</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Letter of Final Acceptance</label>
                                                    <div class="col-md-6 col-xs-12"> 
                                                        <input type="number" class="form-control" min="0" name="">
                                                        <label class="help-block">Days before conference</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Conference Program</label>
                                                    <div class="col-md-6 col-xs-12"> 
                                                        <input type="number" class="form-control" min="0" name="">
                                                        <label class="help-block">Days before conference</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Conference Launch</label>
                                                    <div class="col-md-6 col-xs-12"> 
                                                        <input type="number" class="form-control" min="0" name="">
                                                        <label class="help-block">Days before conference</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">                                    
                                        <button class="btn btn-success pull-right">Update</button>
                                    </div>
                                </div>
                            </div> 

                        </div>
    </div>
</div>
<script>
    $(function(){
        $("#image").fileinput({
            showUpload: false,
            showCaption: false,
            browseClass: "btn btn-danger",
            fileType: "image"
        });
        $("#image_ar").fileinput({
            showUpload: false,
            showCaption: false,
            browseClass: "btn btn-danger",
            fileType: "image"
        });  
    });
</script>
@endsection