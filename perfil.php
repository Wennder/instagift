<?php
$menuClass = array("","","");
$title = "Suas fotos viram presentes";
session_start();
include("inc/header_site.php");
include("WebServer/Instagram/Instagram.php");
$mError = "";
if (isset($_GET['access_denied'])){
    $mError .= "Acesso Negado!";
    if ($_GET['error_reason']){
        $mError .= " O usuário negou o acesso ao aplicativo.";
    }
}
$access_token_parameters = array(
        'client_id'                =>     '097713367ef9406db262c4b7592b43bc',
        'client_secret'            =>     '171763c7c85e456e82b23f42ac3682f1',
        'grant_type'               =>     'authorization_code',
        'redirect_uri'             =>     'http://localhost/instagift/perfil.php'
);
if(isset($_GET['code']) && !isset($_SESSION['instaAccess'])) {
    $code = $_GET['code'];

    $url = "https://api.instagram.com/oauth/access_token";

    $access_token_parameters['code'] = $code;
    
    $curl = curl_init($url);    // we init curl by passing the url
    curl_setopt($curl,CURLOPT_POST,true);   // to send a POST request
    curl_setopt($curl,CURLOPT_POSTFIELDS,$access_token_parameters);   // indicate the data to send
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);   // to perform the curl session
    curl_close($curl);   // to close the curl session

    $arr = json_decode($result,true);
    
    if (!isset($arr['OAuthException'])){
        $_SESSION['instaAccess'] = $arr;
    }

}

if (isset($_SESSION['instaAccess'])){
    echo "<pre>";
    var_dump($_SESSION);
    echo "</pre>";
    
    $Instagram = new Instagram($access_token_parameters);
    $Instagram->setAccessToken($_SESSION["instaAccess"]["access_token"]);
    
    $userInfo = $Instagram->getUser($_SESSION["instaAccess"]["user"]["id"]);
    
    $response = json_decode($userInfo, true);
    
    // Informações do usuário! :)
    echo "<pre>";
    var_dump($response);
    echo "</pre>";
    
}

echo "https://api.instagram.com/v1/users/".$_SESSION["instaAccess"]["user"]['id']."/?access_token=".$_SESSION["instaAccess"]['access_token'];

?>
        <script>
            $(function(){
                    $('#slides').slides({
                            preload: true,
                            preloadImage: 'images/site/loading.gif',
                            play: 5000,
                            pause: 2500,
                            hoverPause: true
                    });
            });
        </script>
        <div class="clearfix"></div>
        <div class="row" style="margin: 30px 0px;">
            <h2>Login with one of your social network account.</h2>
            <?php
            if ($mError != ""){
                echo "<div>";
                echo $mError;
                echo "</div>";
            }
            ?>
            <div>
                <a href="https://api.instagram.com/oauth/authorize/?client_id=097713367ef9406db262c4b7592b43bc&redirect_uri=http://localhost/instagift/perfil.php&response_type=code" class="btn large info">Login with Instagram</a>
            </div>
        </div>
        <div class="row quemja">
        	<div class="span12">
            	<div class="titquemja"></div>
                <div class="imgsquemja">
                	<img src="images/site/quemjamodelo.png" alt="1">
                    <img src="images/site/quemjamodelo.png" alt="2">
                    <img src="images/site/quemjamodelo.png" alt="3">
                    <img src="images/site/quemjamodelo.png" alt="4">
                    <img src="images/site/quemjamodelo.png" alt="5">
                    <img src="images/site/quemjamodelo.png" alt="6">
                    <img src="images/site/quemjamodelo.png" alt="7">
                    <img src="images/site/quemjamodelo.png" alt="8">
                    <img src="images/site/quemjamodelo.png" alt="9">
                    <img src="images/site/quemjamodelo.png" alt="10">
                </div>
            </div>
        </div>
<?php
include("inc/footer_site.php");
?>