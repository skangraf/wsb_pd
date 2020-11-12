<?php
// check min. requirements
include_once '../vendor/feelcom/wsb/minequirements.php';
include_once '../vendor/feelcom/wsb/Kalendarz.php';
use feelcom\wsb as wsb;

// check is set variable $_GET['month'] & $_GET['year'] if not assign current month & year
if (isset($_GET['month'])){
	$month = (int)$_GET['month'];
}
else
{
	$month = date('m');
}

if (isset($_GET['year'])){
	$year = (int)$_GET['year'];
}
else
{
	$year = date('Y');
}

$cal = new wsb\kalendarz($month,$year);

?>
<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Marcin Dąbrowski, Dominik Dymarski, Filipiak Arkadiusz, Pietrowski Szymon">
    <title>Rezerwacja wizyt w serwisie samochodowym</title>


	<!-- Bootstrap core CSS -->
	<link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- custom CSS -->
	<link href="./css/custom.css?v=0.0009" rel="stylesheet">

    <!-- fonts CSS -->
	<link href="./css/fonts.css" rel="stylesheet">


</head>
<body id="top">



<!-- start of header -->
<header class="onas">

    <!-- start of navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="./img/logo2.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#onas">O nas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#oferta">Oferta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#rezerwacje">Rezerwacja</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#kontakt">Kontakt</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <!-- end of navigation -->

    <!-- start of onas content -->
    <div class="container h-100">
        <div class="row">

            <div class="col-lg-6 onas-left">

            </div>
            <div class="col-lg-6">
                <div class="onas-right">
                    <h1>O Firmie</h1>
                    <p>Auto Serwis CAROBD to firma, która została założona w 1982 roku i nieprzerwanie od ponad 30 lat świadczy usługi z zakresu naprawy samochodów. Dzięki temu, że posiadamy 3, w pełni wyposażone stanowiska naprawcze, bogate doświadczenie oraz spory zasób wiedzy nasza firma jest nie tylko godna zaufania, ale również warta polecenia. Poczekalnia z dostępem do Internetu, pyszna kawa oraz miła obsługa sprawiają, że nasi Klienci mogą liczyć na indywidualne podejście. Atutami naszej firmy są rzetelność, uczciwość i terminowość, które potwierdza nasza wieloletnia obecność na rynku oraz obszerne grono dotychczasowych klientów.
                        Jako członek ogólnopolskiej sieci Leader Service i Motointegrator możemy zagwarantować skuteczne naprawy wszystkich marek samochodów dostawczych i osobowych.
                        Zajmujemy się montażem podzespołów, które pochodzą od renomowanych producentów. Naszym Klientom polecamy wykorzystanie części oryginalnych, dzięki czemu użytkowanie samochodu bez usterek będzie z pewnością bezpieczniejsze i dłuższe.
                        Wycenę napraw przeprowadzanych w naszym salonie opieramy na danych katalogowych firmy AUDACON. Stosujemy zasady nowej Dyrektywy UE MVBER nr, 46/2010 która uprawnia nas do wykonywania napraw gwarancyjnych nowych samochodów.
                        Zainteresowanym przeprowadzamy również naprawę silnika. Na miejscu posiadamy własną szlifiernię oferując tym samym naszym Klientom kompleksowe usługi naprawy.
                        Oferujemy także napełnianie klimatyzacji oraz ustawianie geometrii zawieszenia.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- end of onas content -->
</header>
<!-- end of header -->