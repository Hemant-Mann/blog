<?php 
$errors = array();	

	function fieldname_as_text($fieldname) {
		$fieldname = str_replace("_", " ", $fieldname);
		$fieldname = ucfirst($fieldname);
		return $fieldname;
	}
	//*presence
	function has_presence($value) {
	return isset($value) && $value !== "";
	}
	function validate_presences($required_fields) {
	 global $errors;
	 foreach($required_fields as $field) {
		$value = trim($_POST[$field]);
		if(!has_presence($value)) { 
			$errors[$field] = fieldname_as_text($field) . " can't be blank";
		}
	 }
	}
	//max length
	function has_max_length ($value, $max) {
	return strlen($value) <= $max;
	}
	function validate_max_lengths ($fields_with_max_lengths) {
		global $errors;
		foreach($fields_with_max_lengths as $field => $max) {
			$value = trim($_POST[$field]);
			if(!has_max_length($value, $max)) {
				$errors[$field] = fieldname_as_text($field) . " is too long";
			}
		}
	}

	function validate_email($email_id) {
	  global $errors;
	  $email = find_user_by_email($email_id);
	  if($email_id === $email["email_id"]) {
		$errors[$email_id] = "Email already exits! Duplicate emails are not allowed";
	  }
	}
	
	function validate_username($username) {
	   global $errors;
	   $user = find_user_by_username($username);
	   if($username === $user["username"]) {
			$errors[$username] = "Username already exits! Please choose a different username";
	   }
	}
?>