<?php


$appid = "4ce97952-9537-4e51-96e6-ecc31537ff29";

$tennantid = "eef38a1f-720f-4ede-9c7a-79ef6d5dd342";

$secret = "Xx-8Q~GIz6IxScWkgwKK0B8FmqOmQJQaYEmsGan3";

$login_url ="https://login.microsoftonline.com/".$tennantid."/oauth2/v2.0/authorize";


session_start ();

$_SESSION['state']=session_id();

//echo "<h1>MS OAuth2.0 Demo </h1><br>";


if (isset ($_SESSION['msatg'])){

   //echo "<h2>Authenticated ".$_SESSION["uname"]." </h2><br> ";

   //echo '<p><a href="?action=logout">Log Out</a></p>';

   curl_close ($ch);

   header ('Location: https://tableauauto.azurewebsites.net/dashboard');


} //end if session

else   //echo '<h2><p>You can <a href="?action=login">Log In</a> with Microsoft</p></h2>';
if (isset($_GET['action'])) {
   // code... do not cal
if ($_GET['action'] == 'login'){

   $params = array ('client_id' =>$appid,

      'redirect_uri' =>'https://tableauauto.azurewebsites.net/',

      'response_type' =>'token',

       'response_mode' =>'form_post',

      'scope' =>'https://graph.microsoft.com/User.Read',

      'state' =>$_SESSION['state']);

   header ('Location: '.$login_url.'?'.http_build_query ($params));

}
}

if (array_key_exists ('access_token', $_POST))

 {

   

   $_SESSION['t'] = $_POST['access_token'];

   $t = $_SESSION['t'];

$ch = curl_init ();

curl_setopt ($ch, CURLOPT_HTTPHEADER, array ('Authorization: Bearer '.$t,

                                            'Conent-type: application/json'));

//curl_setopt ($ch, CURLOPT_URL, "https://graph.microsoft.com/v1.0/me/");

curl_setopt ($ch, CURLOPT_URL, "https://graph.microsoft.com/v1.0/me?\$select=id,employeeId,displayName,givenName,surname,department,mail,userPrincipalName");

// curl_setopt ($ch, CURLOPT_URL, "https://graph.microsoft.com/v1.0/me");

curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

$rez = json_decode (curl_exec ($ch), 1);

if (array_key_exists ('error', $rez)){  

 var_dump ($rez['error']);    

 die();

}

else  {

$_SESSION['msatg'] = 1;  //auth and verified

$_SESSION['uname'] = $rez["displayName"];

$_SESSION['mail'] = $rez["userPrincipalName"];

$_SESSION['email'] = $rez["mail"];

$_SESSION['empid'] = $rez["employeeId"];

$_SESSION['id'] = $rez["id"];


}

curl_close ($ch);

   header ('Location: https://tableauauto.azurewebsites.net/dashboard');

}

if (isset($_GET['action'])) {
if ($_GET['action'] == 'logout'){

   unset ($_SESSION['msatg']);

   header ('Location: https://tableauauto.azurewebsites.net/index');
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tableau Automation Management</title>
  <link rel="icon" type="image/x-icon" href="dist/img/favicon.ico">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Tableau</b><br>Automation Management</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <div class="social-auth-links text-center mb-3">
        <a href="?action=login" class="btn btn-block btn-info" >
          <i class="fas fa-user"></i> Sign in With Azure AD
        </a>
      </div>
      <!-- /.social-auth-links -->

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>