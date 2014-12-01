<?php

	$success = $auth->logout();
	if($success){
		$h->redirectFor('admin/login');
	}
