<?php
/*
Author: Stojan Kukrika
Date: 01/21/14
Version: 1.0
*/

class User extends DataMapper {
	
    public $validation = array(
		'name' => array(
			'rules' => array('required', 'trim', 'unique', 'max_length' => 100)
		),
		'email' => array(
			'rules' => array('required', 'trim', 'unique', 'valid_email')
		),
		'username' => array(
			'rules' => array('required', 'trim', 'unique', 'alpha_dash', 'min_length' => 3, 'max_length' => 20)
		),
		'password' => array(
			'rules' => array('required', 'trim', 'min_length' => 3, 'max_length' => 40, 'encrypt'),
			'type' => 'password'
		),
		'confirm_password' => array(
			'rules' => array('required', 'encrypt', 'matches' => 'password', 'min_length' => 3, 'max_length' => 40),
			'type' => 'password'
		)
	);
	// Default to ordering by name
	public $default_order_by = array('name');
	
	function login()
    {
        // Create a temporary user object
        $u = new User();

        // Get this users stored record via their username
        $u->where('username', $this->username)->get();

        // Give this user their stored salt
        $this->salt = $u->salt;

        // Validate and get this user by their property values,
        // this will see the 'encrypt' validation run, encrypting the password with the salt
        $this->validate()->get();

        // If the username and encrypted password matched a record in the database,
        // this user object would be fully populated, complete with their ID.

        // If there was no matching record, this user would be completely cleared so their id would be empty.
        if (empty($this->id))
        {
            // Login failed, so set a custom error message
            $this->error_message('login', 'Username or password invalid');

            return FALSE;
        }
        else
        {
            // Login succeeded
            return TRUE;
        }
    }
	 // Validation prepping function to encrypt passwords
    // If you look at the $validation array, you will see the password field will use this function
    function _encrypt($field)
    {
        // Don't encrypt an empty string
        if (!empty($this->{$field}))
        {
        	$ci = get_instance();
			$ci->load->library('hash');

            $this->{$field} = $ci->hash->make($this->{$field});
        }
    }
}

?>