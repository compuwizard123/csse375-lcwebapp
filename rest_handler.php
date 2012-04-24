<?php
	include_once('db_con.php');
	include_once('tutor_controller.php');
	
	$args = json_decode(file_get_contents('php://input'), true);
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	
	switch($_SERVER['REQUEST_URI'])
	{			
		case "get_tutor_by_id":
			$tutor_obj = get_tutor_by_id($args['LCTutorID']);
			echo(encode_json($tutor_obj));
			break;
			
		case "get_tutors_by_name":
			$tutors = get_tutors_by_name($args["LCTutorName"]);
			echo(json_encode($tutors));
			break;
			
		case "/rest/get_tutors_by_course":
			$tutors = get_tutors_by_course($args["LCCourse"]);
			echo(json_encode($tutors));
			break; 
			
		case "/rest/get_tutor_schedule":
			$timeslots = get_tutor_schedule($args['LCTutorID'], $args['LCTimestamp']);
			echo(json_encode($timeslots));
			break;
			
		case "/rest/get_tutor_booked":
			$timeslots = get_tutor_booked($args['LCTutorID'], $args['LCTimestamp']);
			echo(json_encode($timeslots));
			break;
			
		case "/rest/get_tutor_courses_tutored":
			$courses = get_tutor_courses_tutored($args['LCTutorID']);
			echo(json_encode($courses));
			break;
			
		case "/rest/authenticate":
			require_once('Sanitize.php');
			$sanitize = new Sanitize;

			$ldaphost = "ldap://dc-1.rose-hulman.edu";
			$ldapport = 636;
			$domain = "rose-hulman.edu";
			$user = $sanitize->paranoid($args['username']);
			$password = $args['password'];

			$ldapconn = ldap_connect($ldaphost, $ldapport);
			if(!$ldapconn) {
				echo(json_encode(false));
				break;
			}
			ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
			if($user == "" || $password == "") {
				echo(json_encode(false));
				break;
			}
			$bind = @ldap_bind($ldapconn, "{$user}@{$domain}", $password);

			if ($bind) {
				echo(json_encode(true));
				ldap_unbind($ldapconn);
			} else {
				echo(json_encode(false));
			}
			break;
	}
?>