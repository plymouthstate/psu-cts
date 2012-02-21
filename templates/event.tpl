<script>
var currentTime = new Date()
var startTime= new Date();
$(function(){
	$( "#radio" ).buttonset();
});

$(function(){
	$( "#startdate , #enddate" ).datepicker({ minDate: currentTime });
	
	//When the startdate changes enddates dates are blocked out from those dates and the new date is changed to the start date(if it was below the new start date) 
	$( "#startdate" ).change(function (){
		var startTime = ($("#startdate").val());
		$("#enddate").datepicker('option','minDate',startTime);

	});
	
	//$( "#enddate" ).datepicker({ minDate: currentTime });
});

</script>
<form class="label-left" name ="event_request" method="POST">
          <ul>
            <li>
              <h4>Event Information: </h4>
            </li>
            <li>
              <label class="required">Event Title or Course Number and Section:<em>*</em></label>
              <input type="text" name="title" size="25">
            </li>
            <li>
              <label class="required">Location:<em>*</em></label>
              <select name="location" value="Please select a location">
				<option>Please select a location</option>
				<option>Lamson</option>
				<option>Hyde</option>

		    </select>
		  </li>
		  <li>
		    <label class="required">Room Number:<em>*</em></label>
              <input type="text" name="room" size="5">
            </li>
            <li>
             <label>Purpose, Details or Comments:</label>
             <textarea  name="comments" rows="5" cols="40"></textarea>
            </li>
		  <li>
		  	<label class="required">Event Start:<em>*</em></label>
		  	<input id="startdate" type="text" name="start_date" readonly="true"> at <input id="time" readonly="true" type="text" name="start_time">
		  </li>
		  <li>
		  	<label class="required">Event End:<em>*</em></label>
		  	<input id="enddate" type="text" name="end_date" readonly="true">
			$app->tpl->assign('hours',array(1,2,3,4,5,6,7,8,9,10,11,12));
			<select name="endhour">
			{html_options values=$hours output=$hours selected="1"}
			</select>
			<input id="time2" readonly="true" type="text" name="end_time">
		  </li>
		   <div id="radio">
		  	<input type="radio" id="equipment" name="radio" /><label for="equipment">I will pick up and return the equipment to the learning Commons Information Desk in Lamson Library</label>
		 
			<input type="radio" id="sponsored" name="radio" /><label for="sponsored">I will need the Classrom Technology Staff to deliver and retrieve the equipment at the location specified</label>
			</div>
		  <li>
              <input type="Submit" name="submit" value="Next Step">
            </li>
  </ul>
</form>
