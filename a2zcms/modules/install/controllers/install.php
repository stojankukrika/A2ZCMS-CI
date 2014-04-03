<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Install extends MX_Controller {
	
	public $errors = array();
    public $writable_dirs = array(
        'data/avatar' => FALSE,
        'data/page' => FALSE,
    );
	function __construct()
    {
        parent::__construct();
		$this->load->helper('url');
    	$this->load->config('a2zcms');
    	$installed = $this->config->item('installed');
		if($installed!='false')
		{
			redirect('/');
		}
	}
	public function index()
	{
        $data = array();

        $this->form_validation->set_rules('accept', trans('AgreeToLicense',DEF_LANG), 'trim|required');
        $this->form_validation->set_message('required', trans('AgreeToLicenceDesc',DEF_LANG));

        if ($this->form_validation->run())
        {
            redirect('install/step2');
        }

        $data['content'] = $this->load->view('install/step1', $data, TRUE);
		$data['title'] = trans("Installer",DEF_LANG).' | '.trans("Step",DEF_LANG).' 1 '.trans("Of",DEF_LANG).' 5';
        $this->load->view('install/global', $data);
	}
	private function validate()
    {
        if ( ! is_writable(CMS_ROOT . 'config/config.php'))
        {
            $this->errors[] =  CMS_ROOT . 'config/config.php '.trans('is not writable.',DEF_LANG);
        }

        if ( ! is_writable(CMS_ROOT . 'config/database.php'))
        {
            $this->errors[] =  CMS_ROOT . 'config/database.php '.trans('is not writable.',DEF_LANG);
        }

        $writable_dirs = $this->writable_dirs;
        foreach ($writable_dirs as $path => $is_writable)
        {
            if ( ! $is_writable)
            {
                $this->errors[] = CMS_ROOT .'../'. $path .trans('is not writable.',DEF_LANG);
            }
        }

        if (phpversion() < '5.1.6')
        {
            $this->errors[] = trans('YouNeedToUse',DEF_LANG).' PHP 5.1.6 '.trans('OrGreater',DEF_LANG);
        }

        if ( ! ini_get('file_uploads'))
        {
            $this->errors[] = trans('FileUploadsInfo',DEF_LANG);
        }

        if ( ! extension_loaded('mysql'))
        {
            $this->errors[] = trans('MysqlExtension',DEF_LANG);
        }

        if ( ! extension_loaded('gd'))
        {
            $this->errors[] = trans('GDExtension',DEF_LANG);
        }

        if ( ! extension_loaded('curl'))
        {
            $this->errors[] = trans('CurlExtension',DEF_LANG);
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
        if ($this->input->post())
        {
            if ($this->validate())
            {
                redirect('install/step3');
            }
        }

        $data['writable_dirs'] = $this->writable_dirs;
        $data['errors'] = $this->errors;
        $data['content'] = $this->load->view('install/step2', $data, TRUE);
        $data['title'] = trans("Installer",DEF_LANG).' | '.trans("Step",DEF_LANG).' 2 '.trans("Of",DEF_LANG).' 5';
        $this->load->view('install/global', $data);
	}
	

	function step3()
    {
        $data = array();

        $this->form_validation->set_rules('hostname', trans('DatabaseHost',DEF_LANG), 'trim|required');
        $this->form_validation->set_rules('username', trans('DatabaseUsername',DEF_LANG), 'trim|required');
        $this->form_validation->set_rules('password', trans('DatabasePassword',DEF_LANG), 'trim');
        $this->form_validation->set_rules('database', trans('DatabaseName',DEF_LANG), 'trim|required');
        $this->form_validation->set_rules('port', trans('DatabasePort',DEF_LANG), 'trim|required');
        $this->form_validation->set_rules('prefix', trans('DatabasePrefix',DEF_LANG), 'trim');
        
        if ($this->form_validation->run())
        {
            $config['db']['hostname'] = $this->input->post('hostname');
            $config['db']['username'] = $this->input->post('username');
            $config['db']['password'] = $this->input->post('password');
            $config['db']['database'] = $this->input->post('database');
            $config['db']['prefix'] = $this->input->post('prefix');
            $config['db']['port'] = $this->input->post('port');
            $this->load->library('Installer', $config);

            try 
            {
            	$config['db']['hostname'] = $this->input->post('hostname');
		        $config['db']['username'] = $this->input->post('username');
		        $config['db']['password'] = $this->input->post('password');
		        $config['db']['database'] = $this->input->post('database');
		        $config['db']['prefix'] = $this->input->post('prefix');
		        $config['db']['port'] = $this->input->post('port');
				
            	$install = new Installer($config);
                $install->test_db_connection();
                $install->write_ci_config();
                $install->write_db_config();
                $install->db_connect();
                $install->import_schema();
				
				redirect('install/step4');
            }
            catch (Exception $e)
            {
                $this->errors[] = $e->getMessage();
            }
        }

        $data['errors'] = $this->errors;
        $data['content'] = $this->load->view('install/step3', $data, TRUE);
		$data['title'] = trans("Installer",DEF_LANG).' | '.trans("Step",DEF_LANG).' 3 '.trans("Of",DEF_LANG).' 5';
        $this->load->view('install/global', $data);
    }

	
	public function step4()
	{
		$data = array();

        $this->form_validation->set_rules('first_name',  trans('FirstName',DEF_LANG), 'trim|required');
        $this->form_validation->set_rules('last_name',  trans('LastName',DEF_LANG), 'trim|required');
        $this->form_validation->set_rules('username',  trans('Username',DEF_LANG), 'trim|required');
        $this->form_validation->set_rules('email',  trans('Email',DEF_LANG), 'trim|required|valid_email');
		$this->form_validation->set_rules('admin_password',  trans('Password',DEF_LANG), 'trim|required|min_length[5]');
        $this->form_validation->set_rules('confirm_admin_password',  trans('ConfirmPassword',DEF_LANG), 'trim|required|matches[admin_password]');
      	
		
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
								
		        $this->load->library('Installer',$config);	
				$this->load->library('Hash');    
				        	
            	$install = new Installer($config);
				$install->test_db_connection();                
				$install->db_connect();
				
				$hash = new Hash();
				$admin_password = $hash->make($this->input->post('admin_password'));
				$date_time = date('Y-m-d H:i:s');
				$data = array(
					   'name' => $this->input->post('first_name') ,
					   'surname' => $this->input->post('last_name') ,
					   'email' => $this->input->post('email'),
					   'username' => $this->input->post('username') ,
					   'avatar' => NULL ,
					   'password' => $admin_password,					   
					   'confirmation_code' => md5(microtime() . $this->input->post('admin_password')) ,
					   'confirmed' => '1' ,
					   'active' => '1',
					   'last_login' => $date_time,
					   'created_at' => $date_time,
					   'updated_at' => $date_time,
					   'deleted_at' => NULL,
					);
										
				$install->import_admin($data);
                $install->import_seeddatabase();
				
                redirect('install/step5');
            }
            catch (Exception $e)
            {
                $this->errors[] = $e->getMessage();
            }
        }
        $data['errors'] = $this->errors;
        $data['content'] = $this->load->view('install/step4', $data, TRUE);
		$data['title'] = trans("Installer",DEF_LANG).' | '.trans("Step",DEF_LANG).' 4 '.trans("Of",DEF_LANG).' 5';
        $this->load->view('install/global', $data);
	}
	public function step5()
	{
		$data = array();

        $this->form_validation->set_rules('title', trans('SiteName',DEF_LANG), 'trim|required');
        $this->form_validation->set_rules('theme', trans('SiteTheme',DEF_LANG), 'trim|required');
		$this->form_validation->set_rules('per_page', trans('PostsPerPage',DEF_LANG), 'trim|required');
      	$this->form_validation->set_rules('pageitemadmin', trans('PostsPerPageAdmin',DEF_LANG), 'trim|required');
		
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
								
		        $this->load->library('Installer',$config);	
				$this->load->library('Hash');    
				        	
            	$install = new Installer($config);
				$install->test_db_connection();                
				$install->db_connect();
		   		
				$install->write_a2z_config($this->input->post('theme'));
				$install->update_site_name($this->input->post('title'));
				$install->update_pageitem($this->input->post('per_page'));
				$install->update_site_theme($this->input->post('theme'));
				$install->update_pageitemadmin($this->input->post('pageitemadmin'));
								
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
		$data['title'] = trans("Installer",DEF_LANG).' | '.trans("Complite",DEF_LANG);
        $this->load->view('install/global', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */