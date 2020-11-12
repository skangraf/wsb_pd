+function ($) {

    $(document).ready(function () {

        allowAjaxSend = true;

        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
            $("#close").toggleClass("fa-angle-double-left fa-angle-double-right");
        });

        $("#rezerwacje").on('click', '#previous_month', function () {

            let month = $(this).data('month');
            let year = $(this).data('year');

            if (month === 1) {
                month = 12;
                year--;
            } else {
                month--;
            }

            getReservation(month, year);

        });

        $("#rezerwacje").on('click', '#next_month', function () {

            let month = $(this).data('month');
            let year = $(this).data('year');


            if (month === 12) {
                month = 1;
                year++;
            } else {
                month++;
            }

            getReservation(month, year);

        });

        $("#rezerwacje").on('click', '#month', function () {

            $('.year-list').css('display', 'none');
            $('.month-list').css('display', 'block');
        });

        $("#rezerwacje").on('click', '.month-options', function () {

            $('.month-list').css('display', 'none');

            let month = $(this).data('month');
            let year = $(this).data('year');
            getReservation(month, year);
        });

        $("#rezerwacje").on('click', '#year', function () {

            $('.month-list').css('display', 'none');
            $('.year-list').css('display', 'block');
        });

        $("#rezerwacje").on('click', '.year-options', function () {

            $('.year-list').css('display', 'none');

            let month = $(this).data('month');
            let year = $(this).data('year');
            getReservation(month, year);

        });

        function getReservation(month,year){

            if (allowAjaxSend)
            {
                $.ajax({
                    url: "ajax_adm.php",
                    type: 'POST',
                    data: 'action=getReservationUserAjax&month='+month+'&year='+year,
                    beforeSend: function(){
                        allowAjaxSend = false;
                    },
                    complete: function(){
                        allowAjaxSend = true;
                    },


                    success: function(msg){
                        if(msg.length){
                            let ret = JSON.parse(msg);

                            if(ret['code'] === 0){
                                $( '.rezerwacje-card' ).empty();
                                var htmlString = ret['html'];
                                $( '.rezerwacje-card' ).append( htmlString );
                            }
                            else{
                                alert('Przepraszamy wystąpił błąd: \r \n '+ret['html']+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
                            }
                        }
                    }

                });
            }

        }

        $("#rezerwacje").on('click', '#check_reservations', function () {

            $('#checkModal').modal('show');

        });


        $("#checkForm").submit(function(event){

            event.preventDefault();
            checkReservation();
        });

        function checkReservation() {

            let request = $.ajax({
                url: "/ajax_req.php",
                method: "POST",
                data: 'action=checkReservationUserAjax&' + $('form.checkForm').serialize(),
                dataType: "json"
            });

            request.done(function (data) {

                let opt = "";

                if (data.length > 0) {

                    opt += ' <div class="table-responsive-sm">\n' +
                        '<table class="table thead-dark">\n' +
                        '  <thead class="thead-dark">\n' +
                        '    <tr>\n' +
                        '      <th scope="col">lp.</th>\n' +
                        '      <th scope="col">data</th>\n' +
                        '      <th scope="col">godzina</th>\n' +
                        '      <th scope="col">nr rej</th>\n' +
                        '      <th scope="col">marka</th>\n' +
                        '      <th scope="col">model</th>\n' +
                        '      <th scope="col">usługa</th>\n' +
                        '    </tr>\n' +
                        '  </thead>\n' +
                        '  <tbody>';

                    for (let i = 0, max = data.length; i < max; i++) {
                        let lp = i + 1;
                        opt += '    <tr>\n' +
                            '      <th scope="row">' + lp + '</th>\n' +
                            '      <td>' + data[i].date + '</td>\n' +
                            '      <td>' + data[i].houre + '</td>\n' +
                            '      <td>' + data[i].carRegNo + '</td>\n' +
                            '      <td>' + data[i].make + '</td>\n' +
                            '      <td>' + data[i].model + '</td>\n' +
                            '      <td>' + data[i].service + '</td>\n' +
                            '    </tr>';
                    }

                    opt += '  </tbody>\n' +
                        '</table>\n' +
                        '</div>';
                } else {
                    opt += '<div class="no_reservations">Brak wyników</div>';
                }

                // $('#carService').append(opt);
                infoModal(opt);
            });

            request.fail(function (jqXHR, textStatus) {
                alert('Przepraszamy wystąpił błąd: \r \n ' + textStatus + ' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });

        }


        $("#rezerwacje").on('click', '.adm_check', function () {

            let date = $(this).data('date');

            checkDayReservation(date);
        });


        function checkDayReservation(date) {

            let request = $.ajax({
                url: "ajax_adm.php",
                method: "POST",
                data: 'action=checkDayReservationAjax&date='+date,
                dataType: "json"
            });

            request.done(function(data){

                let opt="";

                if(data.length >0) {

                    opt += ' <div class="table-responsive-sm">\n' +
                        '<table class="table thead-dark">\n' +
                        '  <thead class="thead-dark">\n' +
                        '    <tr>\n' +
                        '      <th scope="col">lp.</th>\n' +
                        '      <th scope="col">nr tel.</th>\n' +
                        '      <th scope="col">godzina</th>\n' +
                        '      <th scope="col">nr rej.</th>\n' +
                        '      <th scope="col">marka</th>\n' +
                        '      <th scope="col">model</th>\n' +
                        '      <th scope="col">usługa</th>\n' +
                        '    </tr>\n' +
                        '  </thead>\n' +
                        '  <tbody>';

                    for (let i = 0, max = data.length; i < max; i++) {
                        let lp = i + 1;
                        opt += '    <tr>\n' +
                            '      <th scope="row">' + lp + '</th>\n' +
                            '      <td>' + data[i].cusPhone + '</td>\n' +
                            '      <td>' + data[i].houre + '</td>\n' +
                            '      <td>' + data[i].carRegNo + '</td>\n' +
                            '      <td>' + data[i].make + '</td>\n' +
                            '      <td>' + data[i].model + '</td>\n' +
                            '      <td>' + data[i].service + '</td>\n' +
                            '    </tr>';
                    }

                    opt += '  </tbody>\n' +
                        '</table>\n' +
                        '</div>';
                }
                else
                {
                    opt += '<div class="no_reservations">Brak wyników</div>';
                }

                // $('#carService').append(opt);
                infoModal(opt);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });

        }

        $("#rezerwacje").on('click', '.get_details', function () {

            let id = $(this).data('resid');

            getReservationDetails(id);

        });

        function getReservationDetails(id) {

            let request = $.ajax({
                url: "ajax_adm.php",
                method: "POST",
                data: 'action=getReservationDetailsAjax&id='+id,
                dataType: "json"
            });

            request.done(function(data){

                let opt="";

                if(data.length >0) {

                    opt += ' <div class="table-responsive-sm">\n' +
                        '<table class="table thead-dark">\n' +
                        '  <thead class="thead-dark">\n' +
                        '    <tr>\n' +
                        '      <th scope="col">lp.</th>\n' +
                        '      <th scope="col">nr tel.</th>\n' +
                        '      <th scope="col">godzina</th>\n' +
                        '      <th scope="col">nr rej.</th>\n' +
                        '      <th scope="col">marka</th>\n' +
                        '      <th scope="col">model</th>\n' +
                        '      <th scope="col">usługa</th>\n' +
                        '    </tr>\n' +
                        '  </thead>\n' +
                        '  <tbody>';

                         opt += '    <tr>\n' +
                            '      <th scope="row">1</th>\n' +
                            '      <td>' + data[0].cusPhone + '</td>\n' +
                            '      <td>' + data[0].houre + '</td>\n' +
                            '      <td>' + data[0].carRegNo + '</td>\n' +
                            '      <td>' + data[0].make + '</td>\n' +
                            '      <td>' + data[0].model + '</td>\n' +
                            '      <td>' + data[0].service + '</td>\n' +
                            '    </tr>';


                    opt += '  </tbody>\n' +
                        '</table>\n' +
                        '</div>'+
                        '<div class="actions">'+
                        '<button type="submit" class="btn btn-danger remove_res" data-resid="'+data[0].reservation_id+'">Usuń rezerwacje</button>'+
                        '<button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>'+
                        '</div>';
                }
                else
                {
                    opt += '<div class="no_reservations">Brak wyników</div>';
                }

                // $('#carService').append(opt);
                infoModal(opt);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });

        }


        $("#resModal").on('click', '.remove_res', function () {

            let id = $(this).data('resid');

            if (confirm('Czy napewno anulować rezerwację?')) {
                cancelReservation(id);
            } else {
                return false;
            }

        });

        $("#resTable").on('click', '.remove_res', function () {

            let id = $(this).data('resid');

            if (confirm('Czy napewno anulować rezerwację?')) {
                cancelReservation(id);
            } else {
                return false;
            }

        });

        function cancelReservation(id) {

            let request = $.ajax({
                url: "ajax_adm.php",
                method: "POST",
                data: 'action=cancelReservationAjax&id='+id,
                dataType: "json"
            });

            request.done(function(data){
                window.location.reload();
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });

        }

        function infoModal(text){

            let msg = text;
            $('#checkModal').modal('hide');
            $('#resMsg').empty().append(msg);
            $('#resModal').modal('show');
        }

        $("#resModal").on("hidden.bs.modal", function(){
            $("#resMsg").html("");
        });

        $("#checkModal").on("hidden.bs.modal", function(){
            $("#checkModal form")[0].reset();
        });


        $('[data-toggle="tooltip"]').tooltip();

        $('#resTable').DataTable({
            language: {
                        "processing":     "Przetwarzanie...",
                        "search":         "Szukaj:",
                        "lengthMenu":     "Pokaż _MENU_ pozycji",
                        "info":           "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",
                        "infoEmpty":      "Pozycji 0 z 0 dostępnych",
                        "infoFiltered":   "(filtrowanie spośród _MAX_ dostępnych pozycji)",
                        "infoPostFix":    "",
                        "loadingRecords": "Wczytywanie...",
                        "zeroRecords":    "Nie znaleziono pasujących pozycji",
                        "emptyTable":     "Brak danych",
                        "paginate": {
                            "first":      "Pierwsza",
                            "previous":   "Poprzednia",
                            "next":       "Następna",
                            "last":       "Ostatnia"
                        },
                            "aria": {
                            "sortAscending": ": aktywuj, by posortować kolumnę rosnąco",
                            "sortDescending": ": aktywuj, by posortować kolumnę malejąco"
                        }
                    }
        });

        $('#custPhone').keyup(function(){

            var v = $(this).val().replace(/\D/g, ''); // Remove non-numerics
            v = v.replace(/(\d{3})(?=\d)/g, '$1-'); // Add dashes every 3th digit
            $(this).val(v)
        });



    })

}(jQuery);
