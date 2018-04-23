<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                FORM VALIDATION 
            </h2>
        </div> 
        <!-- Advanced Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>ADVANCED VALIDATION</h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <form id="form_advanced_validation" method="POST">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="minmaxlength" maxlength="10" minlength="3" required>
                                    <label class="form-label">Min/Max Length</label>
                                </div>
                                <div class="help-info">Min. 3, Max. 10 characters</div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="minmaxvalue" min="10" max="200" required>
                                    <label class="form-label">Min/Max Value</label>
                                </div>
                                <div class="help-info">Min. Value: 10, Max. Value: 200</div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="url" class="form-control" name="url" required>
                                    <label class="form-label">Url</label>
                                </div>
                                <div class="help-info">Starts with http://, https://, ftp:// etc</div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="date" required>
                                    <label class="form-label">Date</label>
                                </div>
                                <div class="help-info">YYYY-MM-DD format</div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" class="form-control" name="number" required>
                                    <label class="form-label">Number</label>
                                </div>
                                <div class="help-info">Numbers only</div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="creditcard" pattern="[0-9]{13,16}" required>
                                    <label class="form-label">Credit Card</label>
                                </div>
                                <div class="help-info">Ex: 1234-5678-9012-3456</div>
                            </div>
                            <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Advanced Validation -->
        
    </div>
</section>