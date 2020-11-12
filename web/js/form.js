+function ($) {

    $(document).ready(function () {

        varallowAjaxSend = true;

        //Get cars models on car mark change
        $('#carMark').change(function(){
            getModel();
        });

        //Get cars gernerations on car model change
        $('#carModel').change(function(){
            getGeneration();
        });

        //Get cars series on car gernerations change
        $('#carGeneration').change(function(){
            getSerie();
        });

        //Get cars engines on car serie change
        $('#carSerie').change(function(){
            getModification();
        });


        //open reservation modal & get car mark
        $("#rezerwacje").on('click','.res_avail',function(){

            //get data for reservation
            let valHVAL = $(this).data('hval');
            let valHID = $(this).data('hid');
            let valY = $(this).data('year');
            let valM = $(this).data('month');
            let valD = $(this).data('day');
            let valDate = $(this).data('date');

            //vars for fillup modal data
            let sLabelTxt = valHVAL+', '+valDate ;


            $('#reservationModalLabel').empty().append(sLabelTxt);

            getMark();

            //Get services on car engines change
            getServices();

            $('#f_hid').val(valHID);
            $('#f_year').val(valY);
            $('#f_month').val(valM);
            $('#f_day').val(valD);


            $('#reservationModal').modal('show');

            //alert("w przygotowaniu :)"+ valHID +' '+valY+' '+valM+' '+valD);
        });


        function getMark(){
            $('#carMark option').not(':first').remove();
            $('#carModel option').not(':first').remove();
            $('#carGeneration option').not(':first').remove();
            $('#carSerie option').not(':first').remove();
            $('#carModification option').not(':first').remove();

            let request = $.ajax({
                url: "/ajax_req.php",
                method: "POST",
                data: 'action=getMarkAjax&get_mark=1',
                dataType: "json"
            });

            request.done(function(data){
                let opt = '';

                for(let i = 0, max = data.length; i < max; i++){
                    opt += '<option date_create="'+data[i].date_create+'" date_update="'+data[i].date_update+'" value="'+data[i].id+'">'+data[i].name+'</option>';
                }

                $('#carMark').append(opt);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });
        }


        function getModel(){
            $('#carModel option').not(':first').remove();
            $('#carGeneration option').not(':first').remove();
            $('#carSerie option').not(':first').remove();
            $('#carModification option').not(':first').remove();


            let model = $('#carMark').val();

            if(model == '')
                return false;

            let request = $.ajax({
                url: "/ajax_req.php",
                method: "POST",
                data: 'action=getModelAjax&get_model='+model,
                dataType: "json"
            });

            request.done(function(data){
                let opt = '';

                for(let i = 0, max = data.length; i < max; i++){
                    opt += '<option date_create="'+data[i].date_create+'" date_update="'+data[i].date_update+'" value="'+data[i].id+'">'+data[i].name+'</option>';
                }

                $('#carModel').append(opt);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });
        }

        function getGeneration(){
            $('#carGeneration option').not(':first').remove();
            $('#carSerie option').not(':first').remove();
            $('#carModification option').not(':first').remove();

            let generation = $('#carModel').val();

            if(generation == '')
                return false;

            let request = $.ajax({
                url: "/ajax_req.php",
                method: "POST",
                data: 'action=getGenerationAjax&get_generation='+generation,
                dataType: "json"
            });

            request.done(function(data){
                let opt = '';

                for(let i = 0, max = data.length; i < max; i++){
                    opt += '<option year_begin="'+data[i].year_begin+'" year_end="'+data[i].year_end+'" date_create="'+data[i].date_create+'" date_update="'+data[i].date_update+'" value="'+data[i].id+'">'+data[i].year_begin+'-'+data[i].year_end+'</option>';
                }

                $('#carGeneration').append(opt);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });
        }

        function getSerie(){
            $('#carSerie option').not(':first').remove();
            $('#carModification option').not(':first').remove();

            let serie = $('#carGeneration').val();

            if(serie == '')
                return false;

            let request = $.ajax({
                url: "/ajax_req.php",
                method: "POST",
                data: 'action=getSerieAjax&get_serie='+serie,
                dataType: "json"
            });

            request.done(function(data){
                let opt = '';

                for(let i = 0, max = data.length; i < max; i++){
                    opt += '<option date_create="'+data[i].date_create+'" date_update="'+data[i].date_update+'" value="'+data[i].id+'">'+data[i].name+'</option>';
                }

                $('#carSerie').append(opt);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });
        }

        function getModification(){
            $('#carModification option').not(':first').remove();

            let modification = $('#carSerie').val();

            if(modification == '')
                return false;

            let request = $.ajax({
                url: "/ajax_req.php",
                method: "POST",
                data: 'action=getModificationAjax&get_modification='+modification,
                dataType: "json"
            });

            request.done(function(data){
                let opt = '';

                for(let i = 0, max = data.length; i < max; i++){
                    opt += '<option date_create="'+data[i].date_create+'" date_update="'+data[i].date_update+'" value="'+data[i].id+'">'+data[i].name+'</option>';
                }

                $('#carModification').append(opt);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });
        }

        function getServices(){
            $('#carService option').not(':first').remove();

            let request = $.ajax({
                url: "/ajax_req.php",
                method: "POST",
                data: 'action=getServicesAjax&get_shr=1',
                dataType: "json"
            });

            console.log(request);
            try {
                JSON.parse(request);
            } catch (e) {
                console.log(e);
            }
         //   return true;


            request.done(function(data){
                let opt = '';


                for(let i = 0, max = data.length; i < max; i++){
                    opt += '<option date_create="'+data[i].date_create+'" date_update="'+data[i].date_update+'" value="'+data[i].id+'">'+data[i].name+'</option>';
                }

                $('#carService').append(opt);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });
        }

        $("#reservationForm").submit(function(event){

            event.preventDefault();
            sendReservationForm();
        });

        function sendReservationForm(){

            if (allowAjaxSend)
            {
                $.ajax({
                    url: "/ajax_req.php",
                    type: 'POST',
                    data: 'action=sendReservationFormAjax&'+$('form.reservationForm').serialize(),
                    beforeSend: function(){
                        allowAjaxSend = true;//false;
                    },
                    complete: function(){
                        allowAjaxSend = true;
                    },
                    success: function(msg){
                        if(msg.length){
                            let ret = JSON.parse(msg);

                            if(ret['code'] === 0){
                                $('#'+ret['date_id']).removeClass('res_avail');
                                $('#'+ret['date_id']+' .reservation-desc').css('background-color','#95999c');
                                $('#'+ret['date_id']+' .reservation-title').empty().append('zarezerwowane');
                                $('#reservationModal').modal('hide');
                                infoModal("Twoje zgłoszenie zostało zarejestrowane");
                            }
                            else{
                                infoModal('Przepraszamy wystąpił błąd: <br><br>'+ret['error']+' <br><br> Prosimy przeładować stronę i spróbować ponownie ');
                                $('#reservationModal').modal('hide');
                                $("form")[0].reset();
                            }
                        }
                    }
                });
            }
        }



        $("#reservationModal").on("hidden.bs.modal", function(){
            $("#reservationModal form")[0].reset();
        });

        function infoModal(text){

            let msg = text;
            $('#infoMsg').empty().append(msg);
            $('#infoModal').modal('show');
        }

    })

}(jQuery);