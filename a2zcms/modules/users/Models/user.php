<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class User extends DataMapper {
	
    public $validation = array(
		'name' => array(
			'rules' => array('required', 'trim', 'max_length' => 100)
		),
		'surname' => array(
			'rules' => array('required', 'trim', 'max_length' => 100)
		),
		'email' => array(
			'rules' => array('required', 'trim', 'unique', 'valid_email')
		),
		'username' => array(
			'rules' => array('required', 'trim', 'unique', 'alpha_dash', 'min_length' => 3, 'max_length' => 100)
		),
		'password' => array(
			'rules' => array('required', 'trim', 'min_length' => 3, 'max_length' => 100, 'encrypt'),
			'type' => 'password'
		),
		'confirm_password' => array(
			'rules' => array('required', 'encrypt', 'matches' => 'password', 'min_length' => 3, 'max_length' => 100),
			'type' => 'password'
		)
	);
	// Default to ordering by name
	public $default_order_by = array('name');
	
	function login()
    {
        $u = new User();
        $u->where('username', $this->username)->or_where('email', $this->username)->get();
        $this->salt = $u->salt;
        $this->validate()->get();
        if (empty($this->id))
        {
            $this->error_message('login', 'Username or password invalid');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
  	function _encrypt($field)
    {
        if (!empty($this->{$field}))
        {
        	$ci = get_instance();
			$ci->load->library('hash');

            $this->{$field} = $ci->hash->make($this->{$field});
        }
    }
	
}

?>