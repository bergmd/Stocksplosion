<?php
    // Variables
    $error_name = "";
    $error_code = "";
    $error_exists = false;
    $company_name = "";
    $company_symbol = "";
    
    // This is a self posted form, So check if the for has a POST request or accessed directly
    if(isset($_POST['stock_name']) && isset($_POST['search']))
    {
        // Get the POST data if the form has been filled
        $stock_name = trim($_POST['stock_name']);
        // Recommendation text and the recommendation action
        $recommendation_text = "Random Recommendation Text";
        $recommendation = "";

        // initialize curl
        $ch = curl_init();
        // set curl options and setting
        curl_setopt($ch, CURLOPT_URL, "http://stocksplosion.apsis.io/api/company/$stock_name?startdate=20150501&enddate=20150501");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        
        // process the request and get the results back
        $response = curl_exec($ch);

        // if the request fails
        if ($response === false)
        {
            // get the error code and error message
            $error_name = curl_errno($ch);
            $error_code = curl_error($ch);
            $error_exists = true;
        }
        // successful response
        else
        {
            // convert the response to PHP object
            $response =  json_decode($response);

            
            /*
            * The section below handles the response from the API. App sets up recommendations here
            * This section currently contains arbitrary rules. 
            * For real application these rules should be rewritten as per business rules
            */
            if(empty($response) || is_null($response)){
                // populate custom error message if there is no response
                // please provide more details in case of rel application here
                $error_name = "Incorrect Company code";
                $error_code = 1000;
                $error_exists = true;
            }
            else
            {
                // If the response from the api contains proper data
                // get the company name
                $company_name = $response->company->name;
                // get the compane ticker code
                $company_symbol = $response->company->symbol;

                // BUSINESS RULES TO BUY , SELL or WAIT 
                // Buy stock : if Company code contains a vowel
                if(preg_match_all('/[aeiou]/i', $stock_name, $ignore) > 0){
                    $recommendation_text = "Buy Stocks : This stock contains a vowel.";
                    $recommendation = "Buy";
                }
                // WAIT : If the company code does not have a vowel and has either of [b, c, d, f, g]
                elseif (preg_match_all('/[bcdfg]/i', $stock_name, $ignore) > 0){
                    $recommendation_text = "Wait : This stock contains either of [b, c, d, f, g]";
                    $recommendation = "Wait";
                }
                // SELL stocks : if company does not have a vowel or either of [b, c, d, f, g]
                else{
                    $recommendation_text = "Sell Stock : Does not have a vowel and Does not contain [b, c, d, f, g]";
                    $recommendation = "Sell";
                }
            }
        }
        // Close the curl connection after each request
        curl_close($ch);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Test</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <!-- custom styles -->
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
            <hr/>
            <form action="" method="POST" class="form-horizontal" role="form">
                <div class="col-lg-4 col-lg-offset-4 col-sm-8 col-sm-offset-2 col-xs-12">
                    <div class="input-group">
                        <input type="text" class="form-control" name="stock_name" placeholder="Please provide the company stock symbol" required="required" >
                        <span class="input-group-btn">
                        <input type="submit" name="search" class="btn btn-primary text-capitalize" value="Go!!">
                        </span>
                        </div>
                    </div>
                </form>
                <br/><br/><br/>
            </div>
            <div class="container">
                <br/>
                <!-- if there are any error only then show the below section -->
                <?php if($error_exists): ?>
                <div class="alert alert-danger clearfix">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Sorry an error occured</strong>
                    <ul class="list-unstyled">
                        <li>Error Name : <?=$error_name;?></li>
                        <li>Error Code : <?=$error_code;?></li>
                    </ul>
                </div>
                <!-- if there is a proper response fom the api then show the recommendaions -->
                <?php elseif(!$error_exists && isset($_POST['search'])): ?>
                <div class="alert alert-success clearfix">
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
                <!-- The below section shows some sample data which could be used for testing -->
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