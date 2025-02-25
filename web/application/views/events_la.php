<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.3.0/bootstrap.min.css"></link>
        <style type="text/css">
      /* Override some defaults */
      html, body {
        background-color: #eee;
      }
      body {
        padding-top: 40px; /* 40px to make the container go all the way to the bottom of the topbar */
      }
      .container > footer p {
        text-align: center; /* center align it with the container */
      }
      .container {
        width: 820px; /* downsize our container to make the content feel a bit tighter and more cohesive. NOTE: this removes two full columns from the grid, meaning you only go to 14 columns and not 16. */
      }

      /* The white background content wrapper */
      .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px; /* negative indent the amount of the padding to maintain the grid system */
        -webkit-border-radius: 0 0 6px 6px;
           -moz-border-radius: 0 0 6px 6px;
                border-radius: 0 0 6px 6px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
      }

      /* Page header tweaks */
      .page-header {
        background-color: #f5f5f5;
        padding: 20px 20px 10px;
        margin: -20px -20px 20px;
      }

      /* Styles you shouldn't keep as they are for displaying this base example only */
      .content .span10,
      .content .span4 {
        min-height: 500px;
      }
      /* Give a quick and non-cross-browser friendly divider */
      .content .span4 {
        margin-left: 0;
        padding-left: 19px;
        border-left: 1px solid #eee;
      }

      .topbar .btn {
        border: 0;
      }

    </style>

    <!--CSS For Event Calendar-->
   <link rel="stylesheet" href="http://localhost/CS130-Mashup/web/css/jquery.calendarPicker.css" />
   <link rel="stylesheet" href="http://localhost/CS130-Mashup/web/css/calendar.css" />
   <link rel="stylesheet" href="http://localhost/CS130-Mashup/web/css/fullcalendar.css" />
   <link rel="stylesheet" href="http://localhost/CS130-Mashup/web/css/fullcalendar.print.css" media="print"/>
   <!-- End -->

	<meta charset="utf-8">
        <?php $display_city = isset($city) ? $city : "Los Angeles"?>
	<title>Events from <?php echo $display_city ?> presentation</title>
	<link rel="stylesheet" href="../development-bundle/themes/base/jquery.ui.all.css">
	<script  type="text/javascript" src="../js/jquery-1.6.2.min.js"></script>
	<script  type="text/javascript" src="../development-bundle/ui/jquery.ui.core.js"></script>
	<script  type="text/javascript" src="../development-bundle/ui/jquery.ui.widget.js"></script>
	<script  type="text/javascript" src="../development-bundle/ui/jquery.ui.accordion.js"></script>

  <script  type="text/javascript" src="http://localhost/CS130-Mashup/web/js/jquery-1.6.2.min.js"></script>
  <script  type="text/javascript" src="http://localhost/CS130-Mashup/web/development-bundle/ui/jquery.ui.core.js"></script>
  <script  type="text/javascript" src="http://localhost/CS130-Mashup/web/development-bundle/ui/jquery.ui.widget.js"></script>
  <script  type="text/javascript" src="http://localhost/CS130-Mashup/web/development-bundle/ui/jquery.ui.accordion.js"></script>
  <script>
	$(function() {
		$( "#accordion" ).accordion({
			fillSpace: true,
      autoHeight: false,
			navigation: true,
      collapsible: true
		});
	});
	</script>
</head>
<body>

    <div class="topbar">
      <div class="fill">
        <div class="container">
          <a class="brand" href="#">Entertainment+</a>

          <ul class="nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">Unit Test</a></li>
            <li><a href="#contact">??</a></li>
          </ul>
          <form class="pull-right" action="http://www.studiolino.com/ibm/index.php/events_la/search" method="post">
            <input name="city" placeholder="Search" type="text">
            <?php echo form_submit('','Submit'); ?>
          </form>
        </div>
      </div>
    </div>

    <div class="container">

      <div class="content">
        <div class="page-header">
            <?php
            if(!empty($msg) && $msg != 'search') {
                echo "<div class='alert-message info'>I was able to detect your city: $A</div>";
            } else if($msg != 'search') {
                echo "<div class='alert-message error'>Doh! I couldn't get your city.  I think you'll like LA, or you can try searching</div>";
            }
            ?>
          <h1>E+ <small>Here is what's happening in <?php echo $display_city ?></small></h1>
        </div>
        <div class="row">
          <div class="span10">
            <h2>Events:</h2>
            <div id="accordion">
            <?php
                foreach($la_events as $e) {
                    $event = (object)$e;
                    $title = $event->title;
					echo "<h3><a href='#'>";
					echo $title;
					echo "</a></h3>";
					echo "<div>";
                    echo "<table><tbody>";

                    // start time
                    echo "<tr><th>Starts</th><th>";
                    $start = $event->start_time;
                    echo date("F j, Y, g:i a", strtotime($start));
                    echo "</th></tr>";

                    // end time
                    echo "<tr><th>Ends</th><th>";
                    $stop = $event->stop_time;
                    echo date("F j, Y, g:i a", strtotime($stop));
                    echo "</th></tr>";
                    
                    // venue
                    echo "<tr><th>Venue</th><th>";
                    $venue = $event->venue_name;
                    echo $venue;
                    echo "</th></tr>";
                    
                    // Description
					echo "<tr><th>Description</th><th>";
                    $desc = $event->description;
					echo nl2br($desc);
                    echo "</th></tr>";
                    echo "</tbody></table>";
					echo "</div>";
                }
            
            ?>

            </div>
          </div>
          <div class="span4">
            <h3>Secondary content</h3>
            nothing here yet...
          </div>
          <div class="span6" id="eventCalendar" style="margin-top: 10px;">
            <div id="dest" style="width:340px"></div>
            <div id="calendar"></div>
          </div>
        </div>


      </div>



      <footer>
        <p>&copy; E+ 2011</p>

      </footer>

    </div> <!-- /container -->

<!-- Javascript for event calendar -->
<script type="text/javascript" src="http://localhost/CS130-Mashup/web/js/fullcalendar.min.js"></script>
<script type="text/javascript" src="http://localhost/CS130-Mashup/web/js/jquery.calendarPicker.js"></script>
<script type="text/javascript" src="http://localhost/CS130-Mashup/web/js/calendar.js"></script>

<script>
$(document).ready(function() {
  var e = <?php echo $events_cal; ?>;

    var event_cal = {'events':null, 'eventList':new Array(), 'eventDateList':new Array()};
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    // Initialize the event objects the  event_cal object, which is used lateron
    event_cal.initEvents = function(e) {
      event_cal.events = e;
    }

    event_cal.parse_date = function(string) {
      var parts = String(string).split(/[- :]/);
      var date = new Date(parts[0], (parts[1] - 1), parts[2], parts[3], parts[4], parts[5]);

      return date;
    }

    // Get the eventList and eventDateList populated with the data
    event_cal.constructEventsList = function() {
      $.each(event_cal.events, function(i, v){
        var tmp = {title: v.title,
              start: v.start_time,
              end: v.stop_time,
              allDay: false};
        event_cal.eventList.push(tmp);
        // console.log(v.start_time);
        var date = event_cal.parse_date(v.start_time);
        // console.log(date.getMonth());
        event_cal.eventDateList.push(date.toDateString());
      })
    };

    event_cal.initEvents(e);
    event_cal.constructEventsList();
    // console.log(event_cal.eventDateList);

    var fullCal = $('#calendar').fullCalendar({
      header: false,
        height: 300,
        contentHeight: 200,
        editable: false,
        defaultView: 'agendaDay',
        slotMinutes: 60,
        allDaySlot: false,
        firstHour: 0,
        events: event_cal.eventList
    });

   var calendarPickr = $("#dest").calendarPicker({
      monthNames:["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
       dayNames: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
       //useWheel:true,
       //callbackDelay:500,
       enableYears: false,
       //months:3,
       //days:4,
       //showDayArrows:false,
       eventDates: event_cal.eventDateList,
       callback:function(cal) {
        fullCal.fullCalendar('gotoDate', cal.currentDate);
       }
     });

     //Added color for odd lines of the calendar
     $("table.fc-agenda-slots tr:even").addClass('tr_odd');
});
</script>

</body>
</html>
