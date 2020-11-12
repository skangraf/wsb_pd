+function ($) {

    $(document).ready(function () {

        allowAjaxSend = true;

        $(window).on("scroll", function () {
            // to top arrow animation
            if ($(this).scrollTop() > 200) {
                $(".to-top-arrow").addClass("show");
            } else {
                $(".to-top-arrow").removeClass("show");
            }
        });


        $(".nav-item").click(function () {
            //close hamburger menu on click
            $("#navbarCollapse").removeClass("show");

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
                    url: "/ajax_req.php",
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

        $('#cusPhone').keyup(function(){

            var v = $(this).val().replace(/\D/g, ''); // Remove non-numerics
            v = v.replace(/(\d{3})(?=\d)/g, '$1-'); // Add dashes every 3th digit
            $(this).val(v)
        });



        $("#checkForm").submit(function(event){
            event.preventDefault();
            getUserCode();
        });


        $("#checkFormCode").submit(function(event){

            event.preventDefault();
            checkReservation();
        });

        function getUserCode() {

            let request = $.ajax({
                url: "/ajax_req.php",
                method: "POST",
                data: 'action=getUserSMSCodeAjax&'+$('form.checkForm').serialize(),
                dataType: "json"
            });

            request.done(function(data){

                $('#checkModal').modal('hide');


                if(data['code']==0){
                    let opt="";
                    opt += '<div class="no_reservations">Brak wyników</div>';
                    infoModal(opt);
                }

                if(data['code']==1){
                    $('input[name=phoneToCheck]').val(data['phone']);
                    $('#checkModalPhone').modal('show');
                }

                console.log(data);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });


        }






        function checkReservation() {

            let request = $.ajax({
                url: "/ajax_req.php",
                method: "POST",
                data: 'action=checkReservationUserAjax&'+$('form.checkFormCode').serialize(),
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
                }
                else
                {
                    opt += '<div class="no_reservations">Brak wyników</div>';
                }

                // $('#carService').append(opt);
                $('#checkModalPhone').modal('hide');
                infoModal(opt);
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

        $("#checkModalPhone").on("hidden.bs.modal", function(){
            $("#checkModalPhone form")[0].reset();
        });

        $("#checkModal").on("hidden.bs.modal", function(){
            $("#checkModal form")[0].reset();
        });


        $('#custPhone').keyup(function(){

            var v = $(this).val().replace(/\D/g, ''); // Remove non-numerics
            v = v.replace(/(\d{3})(?=\d)/g, '$1-'); // Add dashes every 3th digit
            $(this).val(v)
        });



    })

}(jQuery);
