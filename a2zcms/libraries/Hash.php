<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hash {

    /**
     * Hash a password using the Bcrypt hashing scheme.
     *
     * <code>
     *      // Create a Bcrypt hash of a value
     *      $hash = Hash::make('secret');
     *
     *      // Use a specified number of iterations when creating the hash
     *      $hash = Hash::make('secret', 12);
     * </code>
     *
     * @param  string  $value
     * @param  int     $rounds
     * @return string
     */
    public static function make($value, $rounds = 8)
    {
    	$work = str_pad($rounds, 2, '0', STR_PAD_LEFT);
		
        $CI =& get_instance();
        $CI->load->config();
        $salt = substr(strtr(base64_encode($CI->config->item("encryption_key")), '+', '.'), 0 , 22);

        return crypt($value, '$2a$'.$work.'$'.$salt);
    }

    /**
     * Determine if an unhashed value matches a Bcrypt hash.
     *
     * @param  string  $value
     * @param  string  $hash
     * @return bool
     */
    public static function check($value, $hash)
    {
        return crypt($value, $hash) === $hash;
    }

}