<!DOCTYPE html>
<html>
    <head>
        <title>Test</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>Stocksplosion  <small>Trading apis</small></h1>
            </div>
            <div class="container">
                <h3>Please enter your stock symbol for testing</h3>
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading text-capitalize">for example : <small> These companies are just for demo and would be removed later</small></div>
                    <!-- Table -->
                    <table class="table table-condensed table-bordered">
                        <tbody>
                            <tr>
                                <td>Brown, Harvey and Moen : NBUW</td><td>Beier-Rice : DXBT</td><td> Wuckert, Doyle and Schuppe : VRM</td><td>Herman-Bogan : KZER</td>
                            </tr>
                            <tr>
                                <td>Batz-Ruecker : PVNQ</td><td>Welch LLC : IHXT</td><td>Oberbrunner-Christiansen : ZFIF</td><td>Hyatt-Bradtke : VPCN</td>
                            </tr>
                            <tr>
                                <td>White Ltd : CNPB</td><td>Lesch and Sons : WQGP</td><td></td><td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr/>
                <form action="" method="POST" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="input" class="col-sm-2 control-label">Company symbol : </label>
                        <div class="col-sm-10">
                            <input type="text" name="" id="input" class="form-control" value="" placeholder="Please provide the company stock symbol" required="required" pattern="" title="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script  type="text/javascript" src="js/bootstrap.min.js"></script>
    </body>
</html>