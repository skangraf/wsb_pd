<?php
// check min. requirements
include_once '../vendor/feelcom/wsb/minequirements.php';
require_once( "header.php" );


//alias for vendor feelcom\wsb as wsb - it's shorter
use feelcom\wsb as wsb;


?>
	<!-- CONTENT -->

	<main>

    	<!-- start of section oferta -->
		<section id="oferta">
            <div class="container">
                <div class="row">
                    <h2 class="oferta_header_top">Nasza</h2>
                    <h2 class="oferta_header_bottom">oferta:</h2>
                </div>
                <div class="row oferta-content">
                    <div class="col-lg-4">
                        <div class="oferta-card">
                            <img src="./img/oil.png" class="oferta-img-top rounded-circle" alt="...">
                            <div class="oferta-body">
                                <h2>Wymiana oleju</h2>
                                <p class="card-text">
                                    Wymiana oleju to podstawowa czynność podczas eksploatacji pojazdu. Wykonuje się ją najczęściej nie bez powodu, olej zapewnia smarowanie oraz chłodzenie każdego silnika bez wyjątków. Jest elementem, który zużywa się najszybciej szczególnie, jeśli znacznie obciążamy silnik i nie zapewniamy mu optymalnego smarowania, ma to miejsce szczególnie na krótkich odcinkach, czyli w ruchu miejskim. Wymiana oleju powinna zawsze wiązać się z wymianą filtra oleju. Filtr oczyszcza olej z mikro zanieczyszczeń, które negatywnie wpływają na trwałość silników.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="oferta-card">
                            <img src="./img/clima.png" class="oferta-img-top rounded-circle" alt="...">
                            <div class="oferta-body">
                                <h2>Serwis klimatyzacji</h2>
                                <p class="card-text">
                                    Obsługę serwisu klimatyzacji wykonujemy na urządzeniu TEXA KONFORT 780R BI-GAS.
                                    Nowoczesna stacja klimatyzacji zdolna jest do jednoczesnej obsługi tradycyjnego czynnika chłodniczego R134a oraz nowego R1234YF, obowiązkowego w nowo homologowanych pojazdach w Europie. Obsługujemy również pojazdy hybrydowe i elektryczne..
                                    Klimatyzacja samochodowa jest układem który wymaga regularnego serwisowania. Podstawowymi czynnościami które wchodzą w skład serwisu klimatyzacji są:
                                </p>
                                <ul>
                                    <li>kontrola układu klimatyzacji,</li>
                                    <li>uzupełnienie czynnika,</li>
                                    <li>odgrzybianie,</li>
                                    <li>dezynfekcja nawiewu.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="oferta-card">
                            <img src="./img/breakes.png" class="oferta-img-top rounded-circle" alt="...">
                            <div class="oferta-body">
                                <h2>Układy hamulcowe</h2>
                                <p class="card-text">
                                    Nasz serwis specjalizuję się w profesjonalnej obsłudze serwisowej oraz naprawie układów hamulcowych . Posiadamy specjalistyczne wyposażenie do obsługi serwisowej układu hamulcowego : rolki hamulcowe , przyrząd do badania płynu hamulcowego , przyrząd do wymiany nadciśnieniowo oraz podciśnieniowo płynu hamulcowego , przyrząd do obsługi serwisowej układu hamulcowego , komputer diagnostyczny do obsługi układu hamulcowego.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</section>
		<!-- start of section oferta -->

        <!-- start of section rezerwacje-->
        <section id="rezerwacje" >
            <div class="container">
                <div class="row">
                    <h2 class="rezerwacje_header_top">Zarezerwuj</h2>
                    <h2 class="rezerwacje_header_bottom">wizytę:</h2>
                </div>
                <div class="row rezerwacje-content">
                    <div class="col-lg-12">
                        <div class="rezerwacje-card">
                            <?php
                             echo $cal->userReservation();
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- start of section rezerwacje -->

        <!-- start of section kontakt-->
        <section id="kontakt">
            <div class="row">
                <div class="col-lg-6">
                    <div id="googleMap" style="width:100%; height:550px;"></div>
                    <script>
                        function floMap() {
                            let place = {lat: 52.403714, lng: 16.929161};

                            let map = new google.maps.Map(document.getElementById('googleMap'), {
                                zoom: 12,
                                center: place,
                                fullscreenControl: true
                            });
                            let marker = new google.maps.Marker({
                                position: place,
                                map: map
                            });
                        }
                    </script>

                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC9ujI02A2TuTRtgCVw1fJuGpNYwUozGDg&callback=floMap"></script>
                </div>

                <div class="col-lg-6">
                    <div class="kontakt">
                        <h3 class="kontakt-title">Kontakt</h3>
                        <div class="kontakt-body">
                            <ul class="list-unstyled">
                                <li>
                                    <div class="media">
                                        <div class="kontakt-left"> <i class="fab fa-battle-net"></i> </div>
                                        <div class="kontakt-right"> AutoService "CAROBD"</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <div class="kontakt-left"> <i class="fas fa-road "></i>  </div>
                                        <div class="kontakt-right">ul. Ogrodowa 5</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <div class="kontakt-left"> <i class="fas fa-map-marker-alt"></i>  </div>
                                        <div class="kontakt-right">60-589 Poznań</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <div class="kontakt-left"> <i class="fas fa-phone"></i> </div>
                                        <div class="kontakt-right"> 0 700 225 052 </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <div class="kontakt-left"> <i class="fas fa-at"></i> </div>
                                        <div class="kontakt-right"> <a href="mailto:biuro@carobd.pl">biuro@carobd.pl</a> </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- start of section kontakt -->
<?php
require_once( "footer.php" );
?>