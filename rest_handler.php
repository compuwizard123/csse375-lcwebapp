<?php
	include_once('db_con.php');
	include_once('tutor_controller.php');
	
	$args = json_decode(file_get_contents('php://input'), true);
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	
	switch($_SERVER['REQUEST_URI'])
	{			
		case "/rest/get_tutor_by_id":
			$result = get_tutor_by_id($args['LCTutorID']);
			break;
			
		case "/rest/get_tutors_by_name":
			$result = get_tutors_by_name($args["LCTutorName"]);
			break;
			
		case "/rest/get_tutors_by_course":
			$result = get_tutors_by_course($args["LCCourse"]);
			break; 
			
		case "/rest/get_tutor_schedule":
			$result = get_tutor_schedule($args['LCTutorID'], $args['LCTimestamp']);
			break;
			
		case "/rest/get_tutor_booked":
			$result = get_tutor_booked($args['LCTutorID'], $args['LCTimestamp']);
			break;
			
		case "/rest/get_tutor_courses_tutored":
			$result = get_tutor_courses_tutored($args['LCTutorID']);
			break;
			
		case "/rest/authenticate":
			$ldaphost = "ldap://dc-1.rose-hulman.edu";
			$ldapport = 636;
			$domain = "rose-hulman.edu";
			$user = $args['username'];
			$password = $args['password'];

			$result = false;
			
			$ldapconn = ldap_connect($ldaphost, $ldapport);
			if(!$ldapconn) break;
			
			ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
			
			if($user == "" || $password == "") break;
			
			$bind = @ldap_bind($ldapconn, "{$user}@{$domain}", $password);

			if ($bind) {
				$result = true;
				ldap_unbind($ldapconn);
			}
			break;
	}
	echo(json_encode($result));
?>