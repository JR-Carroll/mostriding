<?php

class User extends CI_Model {

	public function __construct()	{
	    parent::__construct();
	    $this->load->database();
	}

	//----- function to check whether the email and password entered by the user are correct----
	public function authenticate($email,$password){
		
		$this->db->where('username', $email);
		$this->db->where('password', $password);
		$query = $this->db->get('users');
		$user = ($query->row());
		
		
		if(count($user) != 0){		    		  
			return $user;
		}else{
			return false;
		}
		
	}

}
?>