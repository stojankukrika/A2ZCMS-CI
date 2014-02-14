<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Install extends CI_Controller {
	
	public $errors = array();
    public $writable_dirs = array(
        'data/avatar' => FALSE,
        'data/blog' => FALSE,
        'data/customform' => FALSE,
        'data/gallery' => FALSE,
        'data/page' => FALSE,
    );
    public $writable_subdirs = array(
        'data/blog/thumbs' => FALSE,
        'data/page/thumbs' => FALSE,
    );
	
	public function index()
	{
        $data = array();

        $this->form_validation->set_rules('accept', 'Agree to License', 'trim|required');
        $this->form_validation->set_message('required', 'You must agree to the license before you can install A2Z CMS!');

        if ($this->form_validation->run())
        {
            redirect('install/step2');
        }

        $data['content'] = $this->load->view('install/step1', $data, TRUE);
		$data['title'] = "Installer | Step 1 of 5";
        $this->load->view('install/global', $data);
	}
	private function validate()
    {
        if ( ! is_writable(CMS_ROOT . 'config/config.php'))
        {
            $this->errors[] =  CMS_ROOT . 'config/config.php is not writable.';
        }

        if ( ! is_writable(CMS_ROOT . 'config/database.php'))
        {
            $this->errors[] =  CMS_ROOT . 'config/database.php is not writable.';
        }

        $writable_dirs = array_merge($this->writable_dirs, $this->writable_subdirs);
        foreach ($writable_dirs as $path => $is_writable)
        {
            if ( ! $is_writable)
            {
                $this->errors[] = CMS_ROOT .'../'. $path . ' is not writable.';
            }
        }

        if (phpversion() < '5.1.6')
        {
            $this->errors[] = 'You need to use PHP 5.1.6 or greater.';
        }

        if ( ! ini_get('file_uploads'))
        {
            $this->errors[] = 'File uploads need to be enabled in your PHP configuration.';
        }

        if ( ! extension_loaded('mysql'))
        {
            $this->errors[] = 'The PHP MySQL extension is required.';
        }

        if ( ! extension_loaded('gd'))
        {
            $this->errors[] = 'The PHP GD extension is required.';
        }

        if ( ! extension_loaded('curl'))
        {
            $this->errors[] = 'The PHP cURL extension is required.';
        }

        if (empty($this->errors))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
	private function test_mod_rewrite() 
    {
        if (function_exists('apache_get_modules') && is_array(apache_get_modules()) && in_array('mod_rewrite', apache_get_modules())) 
        {
            return true;
        } 
        else if (getenv('HTTP_MOD_REWRITE') !== false)
        {
            return (getenv('HTTP_MOD_REWRITE') == 'On') ? true : false ;
        }
        else
        {
            return false;
        }
    }
	public function step2()
	{
		 $data = array();
        clearstatcache();
        foreach ($this->writable_dirs as $path => $is_writable)
        {
            $this->writable_dirs[$path] = is_writable(CMS_ROOT .'../'. $path);
        }

        foreach ($this->writable_subdirs as $path => $is_writable)
        {
            if ( ! file_exists(CMS_ROOT .'../'. $path) || (file_exists(CMS_ROOT .'../'.$path) && is_writable(CMS_ROOT .'../'. $path)))
            {
                unset($this->writable_subdirs[$path]);
            }
        }

        if ($this->input->post())
        {
            if ($this->validate())
            {
                redirect('install/step3');
            }
        }

        $data['writable_dirs'] = array_merge($this->writable_dirs, $this->writable_subdirs);
        $data['errors'] = $this->errors;
        $data['content'] = $this->load->view('install/step2', $data, TRUE);
        $data['title'] = "Installer | Step 2 of 5";
        $this->load->view('install/global', $data);
	}
	

	function step3()
    {
        $data = array();

        $this->form_validation->set_rules('hostname', 'Database Host', 'trim|required');
        $this->form_validation->set_rules('username', 'Database Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Database Password', 'trim');
        $this->form_validation->set_rules('database', 'Database Name', 'trim|required');
        $this->form_validation->set_rules('port', 'Database Port', 'trim|required');
        $this->form_validation->set_rules('prefix', 'Database Prefix', 'trim');
        
        if ($this->form_validation->run())
        {
            $config['db']['hostname'] = $this->input->post('hostname');
            $config['db']['username'] = $this->input->post('username');
            $config['db']['password'] = $this->input->post('password');
            $config['db']['database'] = $this->input->post('database');
            $config['db']['prefix'] = $this->input->post('prefix');
            $config['db']['port'] = $this->input->post('port');
            $this->load->library('installer', $config);

            try 
            {
                $this->installer->test_db_connection();
                $this->installer->write_ci_config();
                $this->installer->write_db_config();
                $this->installer->db_connect();
                $this->installer->import_schema();
                redirect('install/step4');
            }
            catch (Exception $e)
            {
                $this->errors[] = $e->getMessage();
            }
        }

        $data['rewrite_support'] = $this->test_mod_rewrite();
        $data['errors'] = $this->errors;
        $data['content'] = $this->load->view('install/step3', $data, TRUE);
		$data['title'] = "Installer | Step 3 of 5";
        $this->load->view('install/global', $data);
    }

	
	public function step4()
	{
		$data = array();

        $this->form_validation->set_rules('first_name', 'First name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('admin_password', 'Password', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('confirm_admin_password', 'Confirm Password', 'trim|required|matches[admin_password]');
      
        if ($this->form_validation->run())
        {
            $this->load->library('hash');
            try 
            {
            	$database = $this->load->database('default', TRUE);				
				$config['db']['hostname'] = $database->hostname;
	            $config['db']['username'] = $database->username;
	            $config['db']['password'] = $database->password;
	            $config['db']['database'] = $database->database;
	            $config['db']['prefix'] = $database->dbprefix;
	            $config['db']['port'] = $database->port;
				
	            $this->load->library('installer', $config);	
				
				$this->installer->test_db_connection();                
				$this->installer->db_connect();		   
				
				$admin_password = $this->hash->make($this->input->post('admin_password'));
				$date_time = date('Y-m-d H:i:s');
				$data = array(
					   'name' => $this->input->post('first_name') ,
					   'surname' => $this->input->post('last_name') ,
					   'email' => $this->input->post('email'),
					   'username' => $this->input->post('username') ,
					   'avatar' => 'My Name' ,
					   'password' => $admin_password,					   
					   'confirmation_code' => md5(microtime() . $this->input->post('admin_password')) ,
					   'confirmed' => '1' ,
					   'active' => '1',
					   'last_login' => $date_time,
					   'created_at' => $date_time,
					   'updated_at' => NULL,
					   'deleted_at' => NULL,
					);
										
				$this->installer->import_admin($data);
                $this->installer->import_seeddatabase();
				
                redirect('install/step5');
            }
            catch (Exception $e)
            {
                $this->errors[] = $e->getMessage();
            }
        }
        $data['errors'] = $this->errors;
        $data['content'] = $this->load->view('install/step4', $data, TRUE);
		$data['title'] = "Installer | Step 4 of 5";
        $this->load->view('install/global', $data);
	}
	public function step5()
	{
		$data = array();

        $this->form_validation->set_rules('title', 'Site Name', 'trim|required');
        $this->form_validation->set_rules('theme', 'Site theme', 'trim|required');
		$this->form_validation->set_rules('per_page', 'Posts per page', 'trim|required');
      	$this->form_validation->set_rules('pageitemadmin', 'Posts per page-Admin', 'trim|required');
		
        if ($this->form_validation->run())
        {
           
            try 
            {
            	$database = $this->load->database('default', TRUE);	
							
				$config['db']['hostname'] = $database->hostname;
	            $config['db']['username'] = $database->username;
	            $config['db']['password'] = $database->password;
	            $config['db']['database'] = $database->database;
	            $config['db']['prefix'] = $database->dbprefix;
	            $config['db']['port'] = $database->port;
				
				$this->load->library('installer', $config);
		   
                $this->installer->test_db_connection();
				$this->installer->write_a2z_config($this->input->post('theme'));   
				$this->installer->db_connect();		                
                $this->installer->update_site_name($this->input->post('title'));
                $this->installer->update_pageitem($this->input->post('per_page'));
				$this->installer->update_site_theme($this->input->post('theme'));
				$this->installer->update_pageitemadmin($this->input->post('pageitemadmin'));
								
                redirect('install/complite');
            }
            catch (Exception $e)
            {
                $this->errors[] = $e->getMessage();
            }
        }
		$data['errors'] = $this->errors;
        $data['content'] = $this->load->view('install/step5', $data, TRUE);
		$data['title'] = "Installer | Step 5 of 5";
        $this->load->view('install/global', $data);
	}
	public function complite(){
		
		$data = array();
		$data['errors'] = $this->errors;
		$data['content'] = $this->load->view('install/complite', $data, TRUE);
		$data['title'] = "Installer | Complite";
        $this->load->view('install/global', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */