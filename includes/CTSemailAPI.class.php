<?php
require_once $GLOBALS['BASE_DIR'] . '/includes/reserveDatabaseAPI.class.php';
class CTSemailAPI{

			public function Email_User($reserve){
				$categories=reserveDatabaseAPI::categories();
				$locations=reserveDatabaseAPI::locations();

				$email=new \PSUSmarty;
				$email->assign('categories', $categories);
				$email->assign('locations', $locations);
				$email->assign('reserve', $reserve);
				$contents=$email->fetch( $GLOBALS['TEMPLATES'] . '/email.user.tpl' );
				PSU::dbug($contents);

				//PSU::mail( $reserve['email'],'Media Request',$message.$message2.$message3.$message4.$message5.$message6,$headers);
					
			}
	function emailCTS($reserve, $insert_id){
				$categories=reserveDatabaseAPI::categories();
				$locations=reserveDatabaseAPI::locations();
			
				$message='<ul>
					<li>Reservation ID:'. $insert_id .'</li>
					<h2>Submitter Contact Information</h2>
					<li><strong>Name: </strong>'. $reserve['submit_first_name']. ' ' . $reserve['submit_last_name'].'</li>

					<h2>Event Contact Information</h2>
					<li><strong>Name: </strong>'.$reserve['first_name'].' '. $reserve['last_name'].'</li>
					<li><strong>Phone: </strong>'.$reserve['phone'].'</li>

					<h2>Event Information</h2>
					<li><strong>Course Title or Event Name: </strong>'.$reserve['title'].'</li>
					<li><strong>Location: </strong>'.$locations[$reserve['location']]. ' in room '. $reserve['room'] . '</li>
					<li><strong>Start Date and Time: </strong>'.$reserve['start_date'] .' at '. $reserve['start_time'].'</li>
					<li><strong>End Date and Time: </strong>'.$reserve['end_date'] .' at '. $reserve['end_time'].'</li>
					<li><strong>Pickup/Dropoff Method: </strong>';

						if($reserve['reserve_type'] == "equipment"){
							$message2='I will pickup/dropoff at the helpdesk.';
						}else{
							$message2='The CTS department will dropoff the equipment at the location specified.';
						}
						
			$message3='</li>
					<li><strong>Comments/Purpose: </strong>
						<p>'.$reserve['comments'].'</p>
					</li>
					<h2>Equipment Requested</h2>';

						foreach($reserve['equipment'] as $item){
							$message4 .="<li>$categories[$item]</li>";
						}
						$message5='</ul>';
						$headers = 'MIME-Version:Ê1.0'."\r\n".'Content-type: text/html;'."\r\n".'From: Classroom Technology Office <itsmedia@plymouth.edu>'."\r\n";
						mail( 'drallen1@plymouth.edu','Media Request from ' . $reserve['first_name'] . ' ' . $reserve['last_name'],$message.$message2.$message3.$message4.$message5,$headers);


	}//end email user
			function emailUserApproved($reservation_idx){
				$reserve=reserveDatabaseAPI::by_id($reservation_idx);
				$index=$reserve[$reservation_idx]['building_idx'];
				$start_time=date("g:i A",strtotime($reserve[$reservation_idx]['start_time']));
				$end_time=date("g:i A",strtotime($reserve[$reservation_idx]['end_time']));
				$categories=reserveDatabaseAPI::categories();
				$locations=reserveDatabaseAPI::locations();
			
				$message='<ul>
					<h1>Your equipment reservation has been approved!</h1>
					<h2>Below is the information about your reservation.</h2>

					<h2>Contact Information</h2>
					<li><strong>Name: </strong>'.$reserve[$reservation_idx]['fname'].' '. $reserve[$reservation_idx]['lname'].'</li>
					<li><strong>Phone: </strong>'.$reserve[$reservation_idx]['phone'].'</li>

					<h2>Event Information</h2>
					<li><strong>Course Title or Event Name: </strong>'.$reserve[$reservation_idx]['title'].'</li>
					<li><strong>Location: </strong>'.$locations[$index]. ' in room '. $reserve[$reservation_idx]['room'] . '</li>
					<li><strong>Start Date and Time: </strong>'.$reserve[$reservation_idx]['start_date'] .' at '. $start_time.'</li>
					<li><strong>End Date and Time: </strong>'.$reserve[$reservation_idx]['end_date'] .' at '. $end_time.'</li>
					<li><strong>Pickup/Dropoff Method: </strong>';

						if($reserve[$reservation_idx]['reserve_type'] == "equipment"){
							$message2='I will pickup/dropoff the equipment at the helpdesk.';
						}else{
							$message2='The CTS department will dropoff the equipment at the location specified.';
						}
						
			$message3='</li>
					<li><strong>Comments/Purpose: </strong>
						<p>'.$reserve[$reservation_idx]['memo'].'</p>
					</li>
					<h2>Equipment Requested</h2>'.
					$reserve[$reservation_idx]['request_items'].'</ul> ';
						$headers = 'MIME-Version:Ê1.0'."\r\n".'Content-type: text/html;'."\r\n".'From: Classroom Technology Office <itsmedia@plymouth.edu>'."\r\n";
						mail( $reserve[$reservation_idx]['email'],'Media Request Approved!',$message.$message2.$message3.$message4,$headers);


			}
			function emailUserCancelled($reservation_idx){
				$reserve=reserveDatabaseAPI::by_id($reservation_idx);
				$index=$reserve[$reservation_idx]['building_idx'];
				$start_time=date("g:i A",strtotime($reserve[$reservation_idx]['start_time']));
				$end_time=date("g:i A",strtotime($reserve[$reservation_idx]['end_time']));
				$categories=reserveDatabaseAPI::categories();
				$locations=reserveDatabaseAPI::locations();
			
				$message='<ul>
					<h1>Your equipment reservation has been cancelled!</h1>
					<h2>Below is the information about your reservation.</h2>

					<h2>Contact Information</h2>
					<li><strong>Name: </strong>'.$reserve[$reservation_idx]['fname'].' '. $reserve[$reservation_idx]['lname'].'</li>
					<li><strong>Phone: </strong>'.$reserve[$reservation_idx]['phone'].'</li>

					<h2>Event Information</h2>
					<li><strong>Course Title or Event Name: </strong>'.$reserve[$reservation_idx]['title'].'</li>
					<li><strong>Location: </strong>'.$locations[$index]. ' in room '. $reserve[$reservation_idx]['room'] . '</li>
					<li><strong>Start Date and Time: </strong>'.$reserve[$reservation_idx]['start_date'] .' at '. $start_time.'</li>
					<li><strong>End Date and Time: </strong>'.$reserve[$reservation_idx]['end_date'] .' at '. $end_time.'</li>
					<li><strong>Pickup/Dropoff Method: </strong>';

						if($reserve[$reservation_idx]['reserve_type'] == "equipment"){
							$message2='I will pickup/dropoff the equipment at the helpdesk.';
						}else{
							$message2='The CTS department will dropoff the equipment at the location specified.';
						}
						
			$message3='</li>
					<li><strong>Comments/Purpose: </strong>
						<p>'.$reserve[$reservation_idx]['memo'].'</p>
					</li>
					<h2>Equipment Requested</h2>'.
					$reserve[$reservation_idx]['request_items'].'</ul> ';
						$headers = 'MIME-Version:Ê1.0'."\r\n".'Content-type: text/html;'."\r\n".'From: Classroom Technology Office <itsmedia@plymouth.edu>'."\r\n";
						mail( $reserve[$reservation_idx]['email'],'Media Request Cancelled!',$message.$message2.$message3.$message4,$headers);


	}


}


