<?php if(isset($_POST['stock_name']) && isset($_POST['search'])){
	$stock_name = trim($_POST['stock_name']);
	$error_name = "";
	$error_code = "";
	$error_exists = false;
	$company_name = "";
	$company_symbol = "";
	$recommendation = "Random Recommendation";
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
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>Stocksplosion  <small>Trading apis</small></h1>
            </div>
            <?php if($error_exists): ?>
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Sorry an error occured</strong>
                <ul class="list-unstyled">
                    <li>Error Name : <?=$error_name;?><li/>
                        <li>Error Code : <?=$error_code;?></li>
                    </ul>
                </div>
                <?php elseif(!$error_exists && isset($_POST['search'])): ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>The search produced below results</strong>
                    <div class="row">
                    <div class="col-xs-12">Company Name : <?=$company_name?></div>
                    <div class="col-xs-12">Company Symbol : <?=$company_symbol?></div>
                    <div class="col-xs-12">Recommendation : <?=$recommendation?></div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <div class="text-capitalize">for example : <small> These companies are just for demo and would be removed later</small></div>
                            </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <table class="panel-body table table-condensed ">
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
                    </div>
                </div>
                <hr/>
                <form action="" method="POST" class="form-horizontal" role="form">
                    <h3>Please enter your stock symbol for testing</h3>
                    <div class="form-group">
                        <label for="input" class="col-sm-2 control-label">Company symbol : </label>
                        <div class="col-sm-10">
                            <input type="text" name="stock_name" id="input" class="form-control" value="" placeholder="Please provide the company stock symbol" required="required" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <input type="submit" name="search" class="btn btn-primary text-capitalize" value="Get Recommendation">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script  type="text/javascript" src="js/bootstrap.min.js"></script>
    </body>
</html>