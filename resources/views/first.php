<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title></title>
    <link href="css/fontcss.css" rel="stylesheet" type="text/css">
    <link href="css/fonticon.css" rel="stylesheet" type="text/css">

    <link href="css/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="css/node-waves/waves.css" rel="stylesheet" />
    <link href="css/animate-css/animate.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet">
    <link href="css/themes/all-themes.css" rel="stylesheet" />

    <link href="css/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
    <link href="css/waitme/waitMe.css" rel="stylesheet" />
    <link href="css/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
</head>

<body class="theme-red">

<section class="">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <h2 class="card-inside-title">INPUT</h2>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Date" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Github URL" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="TaskID" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Update" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Tasked hours" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align:right;">
                                <button type="button" class="btn btn-primary m-t-15 waves-effect" onClick="upSave();">Save</button>
                                <button type="button" class="btn btn-primary m-t-15 waves-effect" onClick="onAdd();">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section> 
    <section class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <table id="mainTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>TaskID</th>
                                        <th>Update</th>
                                        <th>Track</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Car</td>
                                        <td>100</td>
                                        <td>200</td>
                                        <td>0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="css/jquery/jquery.min.js"></script>
    <script src="css/bootstrap/js/bootstrap.js"></script>
    <script src="css/bootstrap-select/js/bootstrap-select.js"></script>
    <script src="css/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script src="css/node-waves/waves.js"></script>
    <script src="css/editable-table/mindmup-editabletable.js"></script>
    
    <script src="css/autosize/autosize.js"></script>
    <script src="css/momentjs/moment.js"></script>
    <script src="css/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <script src="js/pages/tables/editable-table.js"></script>
    <script src="js/pages/forms/basic-form-elements.js"></script>
   <!-- <script src="js/admin.js"></script>
    <script src="js/demo.js"></script> -->


</body>

</html>