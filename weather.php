<?php
ob_start();
//include('nav.php');
//include("search.php");

use function PHPSTORM_META\type;

$api_key = "IlMeT70k7xC85zyiAukJlShqQCVzhKb3";
$source = "bitcoin";
if (isset($argv[1])) {
    //$argv[0] is name of script always
    $source = $argv[1];
}
if (isset($_GET["query"])) {
    $source = $_GET["query"];
}
$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);


curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.windy.com/api/webcams/v2/list/category=coast/orderby=popularity/bbox=41.228191,-72.126516,38.173556,-75.454113?show=webcams:image%3Alocation%2Curl&key=IlMeT70k7xC85zyiAukJlShqQCVzhKb3",

    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    //CURLOPT_POSTFIELDS => "apiKey=$api_key&newsSource=$source",
    CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
        //"x-rapidapi-host: $rapid_api_host",
        //"x-rapidapi-key: $rapid_api_key"
    ),
));

$response = curl_exec($curl);
$json = json_decode($response, true);
// echo print_r ($json);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    //echo $response;
    $r = json_encode($response);

    if (isset($_GET["browser"])) {

        echo "<pre>" . var_export($r, true)  . "</pre>";
    } else {
        // echo "<pre>" . $r  . "</pre>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Weather at the Beach</title>
</head>
<body>
    <div class="container">
        
            <h1 class="text-center">Beach info</h1>
        
        <div class="row text-center">
            <?php foreach ($json['result']['webcams'] as $re) { ?>
                <div class="col-md-4 mb-4 ">
                    <div class="thumbnail">
                        <a href="https://www.windy.com/-Weather-warnings-capAlerts?capAlerts,40.553,-73.993,8<?= $re['id'] ?>">
                            <img src="<?= $re['image']['current']['thumbnail'] ?>" alt="Lights" style="width:100%">
                            <div class="caption">
                                <p style="height: 50px;"><?= $re['title'] ?></p>
                            </div>
                        </a>
                      
                    </div>

                </div>
            <?php } ?>
        </div>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

