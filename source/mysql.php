<?php

$_GET['username'] = '';
$_GET['db'] = 'datenbankname_hier_einfuegen';

function adminer_object() {
  class AdminerSoftware extends Adminer {
		function credentials() {
			return array('localhost', 'localhost', 'localhost');
		}
		function login($login, $password) {
			return true;
		}
	}
	return new AdminerSoftware;
}

require_once('adminer.php');