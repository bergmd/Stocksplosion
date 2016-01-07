<?php
$error_name = "";
$error_code = "";
$error_exists = false;
$company_name = "";
$company_symbol = "";
if(isset($_POST['stock_name']) && isset($_POST['search'])){
$stock_name = trim($_POST['stock_name']);
$recommendation_text = "Random Recommendation Text";
$recommendation = "";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://stocksplosion.apsis.io/api/company/$stock_name?startdate=20150501&enddate=20150501");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
$response = curl_exec($ch);
if ($response === false)
{
    $error_name = curl_errno($ch);
    $error_code = curl_error($ch);
    $error_exists = true;
}
else
{
    $response =  json_decode($response);
    if(empty($response) || is_null($response)){
    $error_name = "Incorrect Company code";
$error_code = 1000;
    $error_exists = true;
    }
    else{
    $company_name = $response->company->name;
$company_symbol = $response->company->symbol;
if(preg_match_all('/[aeiou]/i', $stock_name, $ignore) > 0){
$recommendation_text = "Buy Stocks : This stock contains a vowel.";
$recommendation = "Buy";
}
elseif (preg_match_all('/[bcdfg]/i', $stock_name, $ignore) > 0){
$recommendation_text = "Wait : This stock contains either of [b, c, d, f, g]";
$recommendation = "Wait";
}
else{
$recommendation_text = "Sell Stock : Does not have a vowel and Does not contain [b, c, d, f, g]";
$recommendation = "Sell";
}
    }
}
curl_close($ch);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Test</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <style>
            .bg-inverse {background:#444;color:#fff;}
            .bg-grey    {background:#eee;color:#222;}
            .padding-is {padding:60px 0px 60px 0px;}
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row bg-inverse">
                <code class='lead bg-primary'>Stocksplosion</code>
                <small>Trading apis</small>
            </div>
        </div>
        <div class="container-fluid bg-grey padding-is">
            <h3 class="text-center">Stocksplosion <small>[API for stock recommendations]</small></h3>
            <!-- <div class='text-center'><small>Please enter your stock symbol for testing</small></div> -->
            <hr/>
            <form action="" method="POST" class="form-horizontal" role="form">
                <div class="col-lg-4 col-lg-offset-4 col-sm-8 col-sm-offset-2 col-xs-12">
                    <div class="input-group">
                        <input type="text" class="form-control" name="stock_name" placeholder="Please provide the company stock symbol" required="required" >
                        <span class="input-group-btn">
                        <!-- <button class="btn btn-default" type="button">Go!</button> -->
                        <input type="submit" name="search" class="btn btn-primary text-capitalize" value="Go!!">
                        </span>
                        </div><!-- /input-group -->
                    </div>
                </form>
                <br/><br/><br/>
            </div>
            <div class="container">
                <br/>
                <?php if($error_exists): ?>
                <div class="alert alert-danger clearfix">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Sorry an error occured</strong>
                    <ul class="list-unstyled">
                        <li>Error Name : <?=$error_name;?></li>
                        <li>Error Code : <?=$error_code;?></li>
                    </ul>
                </div>
                <?php elseif(!$error_exists && isset($_POST['search'])): ?>
                <div class="alert alert-success clearfix">
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
                    <strong>The search produced below results</strong>
                    <div class="row">
                        <div class="col-xs-12">Company Name : <?=$company_name?></div>
                        <div class="col-xs-12">Company Symbol : <?=$company_symbol?></div>
                        <div class="col-xs-12">Recommendation : <?=$recommendation_text?></div>
                    </div>
                    <div class="row">
                        <br/>
                        <div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
                            <button type="button" class="btn btn-info btn-block"><?=$recommendation?></button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="panel-group" id="accordion" role="tablist" >
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <div class="text-capitalize">Help : <small> Click to hide</small></div>
                            </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <table class="panel-body table table-condensed ">
                                <tbody>
                                    <tr>
                                        <td>Brown, Harvey and Moen : NBUW</td><td>Beier-Rice : DXBT</td><td> Wuckert, Doyle and Schuppe : VRMZ</td><td>Herman-Bogan : KZER</td>
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
                    </div>
                </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script  type="text/javascript" src="js/bootstrap.min.js"></script>
        </body>
    </html>