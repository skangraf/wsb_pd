<?php
// min requirements
include_once '../../vendor/feelcom/wsb/minequirements.php';
include_once '../../vendor/feelcom/wsb/Auth.php';
use feelcom\wsb as wsb;

//New auth object
$auth= new wsb\Auth();

//if send form post user & passwors data - try to login
if(isset($_POST['inputUsername']) && isset($_POST['inputPassword'])){
	$user = htmlentities($_POST['inputUsername']);
	$pass = htmlentities($_POST['inputPassword']);
	//$cos1 = $cos->login("ddd","fff");
	$cos1 = $auth->login($user,$pass);
}

//if user is logged - move to index site
if($auth->cookie_login()){
	header('Location: index.php');
}

//including header file
require_once( 'header.php' );
?>
<!-- body of login form -->
<body class="d-flex flex-column h-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="login_form">
                        <form class="form-signin" method="post">
                            <div class="text-center mb-4">
                                <img class="mb-4" src="../img/logo.png" alt="logo">
                            </div>

                            <div class="form-label-group">
                                <input type="text" id="inputUsername" name="inputUsername" class="form-control" placeholder="Nazwa użytkownika" required autofocus>
                                <label for="inputUsername">Nazwa użytkownika</label>
                            </div>

                            <div class="form-label-group">
                                <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Hasło" required>
                                <label for="inputPassword">Hasło</label>
                            </div>

                            <button class="btn btn-lg btn-primary btn-block" type="submit">Zaloguj</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


<?php
//including footer file
require_once( 'footer.php');
?>
