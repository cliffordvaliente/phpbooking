$(document).ready(function () {
   $('#calendar').fullCalendar({
      events: function (start, end, timezone, callback) {
         $.ajax({
            url: './databases/calendar1.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
               var events = [];
               $(response).each(function () {
                  events.push({
                     title: this.thestatus,
                     //start: this.session_start,
                     //  end: this.session_end
                  });
               });
               callback(events);
            },
            error: function (jqXHR, textStatus, errorThrown) {
               console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
         });
      }
   });
});
