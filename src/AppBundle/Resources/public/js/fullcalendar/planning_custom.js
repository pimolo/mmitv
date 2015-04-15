    $(document).ready(function() {


        /* initialize the external events
        -----------------------------------------------------------------*/

        $('#external-events .fc-event').each(function() {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });

        });


        /* initialize the calendar
        -----------------------------------------------------------------*/

        $('#calendar').fullCalendar({
            header: {
                left:'',//left: 'prev,next today',
                center: 'title',
                right: ''//'month,agendaWeek,agendaDay'
            },
            defaultView: 'agendaWeek', // affichage par semaine
            timeFormat: 'H:mm', //
            minTime: "08:00:00", // Debut de la journée a 8h
            maxTime: "18:30:00", // fin de la journée 18h
            allDaySlot: false, // Retirer la colonne allDay
            dayNamesShort: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'], // Nom des date en fr et complete
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function() {
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            eventClick: function (calEvent, jsEvent, view) {
                $('#calendar').fullCalendar('removeEvents', calEvent._id);
            },

            eventReceive: function(event, jsEvent, ui, view){

               // $.ajax({
                   // type: 'POST'
                   // url: //JE SAIS PAS QUOI METTRE ICI!
                   // dataType: 'json'
                   // success: function(){
                  //      alert(event.title + " was dropped on " + event.start.format());
                   // }
                //});

            //}

               // }
                alert(event.title + " was dropped on " + event.start.format());

               if (!confirm("Are you sure about this change?")) {
                revertFunc();
                }
            },

            eventDragStop: function(event, jsEvent, ui, view) {

                alert(event.title + " was dropped on " + event.start.format());

                if (!confirm("Are you sure about this change?")) {
                revertFunc();
                }

            },




        });

    });
