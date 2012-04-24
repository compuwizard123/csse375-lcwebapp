<?php

function authenticate($user, $password) {
	$ldaphost = "ldap://dc-1.rose-hulman.edu";
	$ldapport = 636;
	$domain = "rose-hulman.edu";

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
	return $result;
}

?>