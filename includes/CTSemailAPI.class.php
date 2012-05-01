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
				$headers = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html;'."\r\n".'From: Classroom Technology Office <itsmedia@plymouth.edu>'."\r\n";
				PSU::mail( $reserve['email'],'Media Request',$contents,$headers);
					
			}
	function emailCTS($reserve, $insert_id){
				$categories=reserveDatabaseAPI::categories();
				$locations=reserveDatabaseAPI::locations();
				$email=new \PSUSmarty;
				$email->assign('insert_id', $insert_id);
				$email->assign('categories', $categories);
				$email->assign('locations', $locations);
				$email->assign('reserve', $reserve);
				$title="Media Request from " . $reserve['first_name'] . " " . $reserve['last_name'];
				$contents=$email->fetch( $GLOBALS['TEMPLATES'] . '/email.admin.tpl' );
				$headers = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html;'."\r\n".'From: Classroom Technology Office <itsmedia@plymouth.edu>'."\r\n";
				PSU::mail( "drallen1@plymouth.edu",$title,$contents,$headers);
		

			}
			function emailUserCancelled($reservation_idx){
				$reserve=reserveDatabaseAPI::by_id($reservation_idx);
				$reservation=$reserve[$reservation_idx];
				$index=$reserve[$reservation_idx]['building_idx'];
				$categories=reserveDatabaseAPI::categories();
				$locations=reserveDatabaseAPI::locations();
		
				$email=new \PSUSmarty;
				$email->assign('categories', $categories);
				$email->assign('locations', $locations);
				$email->assign('reserve', $reservation);
				$contents=$email->fetch( $GLOBALS['TEMPLATES'] . '/email.user.cancel.tpl' );
				$headers = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html;'."\r\n".'From: Classroom Technology Office <itsmedia@plymouth.edu>'."\r\n";
				PSU::mail( $reserve[$reservation_idx]['email'],'Media Request Cancelled!',$contents,$headers);
			}

			function emailUserApproved($reservation_idx){
				$reserve=reserveDatabaseAPI::by_id($reservation_idx);
				$reservation=$reserve[$reservation_idx];
				$index=$reserve[$reservation_idx]['building_idx'];
				$categories=reserveDatabaseAPI::categories();
				$locations=reserveDatabaseAPI::locations();
		
				$email=new \PSUSmarty;
				$email->assign('categories', $categories);
				$email->assign('locations', $locations);
				$email->assign('reserve', $reservation);
				$contents=$email->fetch( $GLOBALS['TEMPLATES'] . '/email.user.approve.tpl' );
				$headers = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html;'."\r\n".'From: Classroom Technology Office <itsmedia@plymouth.edu>'."\r\n";
				PSU::mail( $reserve[$reservation_idx]['email'],'Media Request Approved!',$contents,$headers);
	}



}


