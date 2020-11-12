<?php
// min requirements
include_once '../../vendor/feelcom/wsb/minequirements.php';
include_once '../../vendor/feelcom/wsb/Auth.php';
include_once '../../vendor/feelcom/wsb/Kalendarz.php';
use feelcom\wsb as wsb;


// display names of months in PL language
setlocale(LC_TIME,'pl_PL.UTF8');


$auth = new wsb\Auth();

if(!$auth->cookie_login()){
	header('Location: login.php');

}
else {
	$cal = new wsb\Kalendarz();
	require_once( 'header.php' );
}
?>
	<body>
	    <div id="wrapper" class="toggled">
	        <!-- Sidebar -->
	        <div id="sidebar-wrapper" >
	            <div id="menu-toggle" class="toogle-menu">
	                <div id="close" class="fas fa-angle-double-left"></div>
	            </div>
	            <ul class="sidebar-nav">
	                <li class="sidebar-brand">
	                    <a href="/panel/">Kalendarz</a>
	                </li>
	                <li>
	                    <a href="/panel/rezerwacje.php">Rezerwacje</a>
	                </li>
	                <li>
	                    <a href="/panel/logout.php">Wyloguj</a>
	                </li>
	            </ul>
	        </div>
	        
	        <!-- start of section rezerwacje-->
		    <div id="page-content-wrapper-index">    
		        <section id="rezerwacje" >
		            <div class="container">
		                <div class="row rezerwacje-content">
		                    <div class="col-lg-12">
		                        <div class="rezerwacje-card">
									<?php  echo $cal->userReservation() ?>
		                        </div>
		                    </div>
		
		                </div>
		            </div>
		        </section>
		     </div>
        </div>
<?php
	require_once( 'footer.php');
?>