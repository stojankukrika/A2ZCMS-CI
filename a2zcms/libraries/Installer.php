<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Installer
{
    public $CI;
    public $hostname;
    public $username;
    public $password;
    public $database;
    public $port;
    public $prefix;
    public $driver = null;
    public $encryption_key = null;
    private $_conn = null;

    public function __construct($config)
    {
        $this->CI =& get_instance();
        $this->hostname = $config['db']['hostname'];
        $this->username = $config['db']['username'];
        $this->password = $config['db']['password'];
        $this->database = $config['db']['database'];
        $this->port = $config['db']['port'];
        $this->prefix = $config['db']['prefix'];
    }

    public function test_db_connection()
    {
        if (function_exists('mysqli_connect'))
        {
            $mysqli = @new mysqli($this->hostname, $this->username, $this->password, $this->database, $this->port);

            if ($mysqli->connect_errno) 
            {
                throw new Exception("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
            }

            $mysqli->close();

            $this->driver = 'mysqli';
        }
        else if (function_exists('mysql_connect'))
        {
            $link = @mysql_connect($this->hostname . ':' . $this->port, $this->username, $this->password);

            if ( ! $link) 
            {
                throw new Exception('Failed to connect to MySQL: ' . mysql_error());
            }

            $db_selected = mysql_select_db($this->database, $link);

            if ( ! $db_selected)
            {
                throw new Exception('Failed to connect to MySQL: ' . mysql_error());
            }

            mysql_close($link);

            $this->driver = 'mysql';
        }
        else
        {
            throw new Exception('Unable to find MySQL on server.');
        }
    }

    public function write_db_config()
    {
        // Get database config template
        $template = file_get_contents(CMS_ROOT . 'config/database_temp.php');

        $replace = array(
            '__HOSTNAME__'  => $this->hostname,
            '__USERNAME__'  => $this->username,
            '__PASSWORD__'  => $this->password,
            '__DATABASE__'  => $this->database,
            '__PORT__'      => $this->port,
            '__DRIVER__'    => $this->driver,
            '__PREFIX__'    => $this->prefix,
        );

        $template = str_replace(array_keys($replace), $replace, $template);

        $handle = @fopen(CMS_ROOT . 'config/database.php', 'w+');

        if ($handle !== FALSE)
        {
            $response = @fwrite($handle, $template);
            fclose($handle);

            if ($response)
            {
                return TRUE;
            }
        }

        throw new Exception('Failed to write to ' . CMS_ROOT . 'config/database.php');
    }

    public function write_ci_config()
    {
        $this->encryption_key = md5(uniqid('', true));

        $enable_mod_rewrite = TRUE;
		$index_page = '';

        // Get database config template
        $template = file_get_contents(CMS_ROOT . 'config/config_temp.php');

        $replace = array(
            '__INDEX_PAGE__'      => $index_page,
            '__ENCRYPTION_KEY__'  => $this->encryption_key,
        );

        $template = str_replace(array_keys($replace), $replace, $template);

        $handle = @fopen(CMS_ROOT . 'config/config.php', 'w+');

        if ($handle !== FALSE)
        {
            $response = @fwrite($handle, $template);
            fclose($handle);

            if ($response)
            {
                return TRUE;
            }
        }

        throw new Exception('Failed to write to ' . CMS_ROOT . 'config/config.php');
    }
	
	public function write_a2z_config($theme)
    {
        // Get database config template
        $template = file_get_contents(CMS_ROOT . 'config/a2zcms_temp.php');

        $replace = array(
            '__THEME__'      => $theme,
            '__INSTALLED__'  => 'true',
        );

        $template = str_replace(array_keys($replace), $replace, $template);

        $handle = @fopen(CMS_ROOT . 'config/a2zcms.php', 'w+');

        if ($handle !== FALSE)
        {
            $response = @fwrite($handle, $template);
            fclose($handle);

            if ($response)
            {
                return TRUE;
            }
        }

        throw new Exception('Failed to write to ' . CMS_ROOT . 'config/a2zcms.php');
    }

    public function import_schema()
    {
        $file = CMS_ROOT .'../data/dbschema/a2zcms.sql';

        if ($sql = file($file)) 
        {
            $query = '';

            foreach($sql as $line) 
            {
                $tsl = trim($line);

                if (($sql != '') && (substr($tsl, 0, 2) != "--") && (substr($tsl, 0, 1) != '#')) 
                {
                    $query .= $line;
  
                    if (preg_match('/;\s*$/', $line)) 
                    {
                        $query = str_replace("DROP TABLE IF EXISTS `", "DROP TABLE IF EXISTS `" . $this->prefix, $query);
                        $query = str_replace("CREATE TABLE IF NOT EXISTS `", "CREATE TABLE IF NOT EXISTS `" . $this->prefix, $query);
                        $query = str_replace("CREATE TABLE `", "CREATE TABLE `" . $this->prefix, $query);
                        $query = str_replace("INSERT INTO `", "INSERT INTO `" . $this->prefix, $query);
                        $query = str_replace("ALTER TABLE `", "ALTER TABLE `" . $this->prefix, $query);
						$query = str_replace("ADD CONSTRAINT `", "ADD CONSTRAINT `" . $this->prefix, $query);
						$query = str_replace("REFERENCES `", "REFERENCES `" . $this->prefix, $query);
						
                        $this->db_query($query);
                        $query = '';
                    }
                }
            }
	        $query = "CREATE TRIGGER ".$this->prefix."user_login_historys_after_inserts 
	        				AFTER INSERT ON ".$this->prefix."user_login_historys
								 FOR EACH ROW UPDATE ".$this->prefix."users set ".$this->prefix."users.last_login = 
								(select ".$this->prefix."user_login_historys.created_at 
								 from ".$this->prefix."user_login_historys
								 where ".$this->prefix."user_login_historys.id = NEW.id) 
								WHERE id = (select ".$this->prefix."user_login_historys.user_id 
								 from ".$this->prefix."user_login_historys
								 where ".$this->prefix."user_login_historys.id = NEW.id) 
							";
                
            $this->db_query($query);
            $query = '';
        }
		else {
			throw new Exception('Failed to read ' . CMS_ROOT .'../data/dbschema/a2zcms.sql');
		}
    }
    
    public function import_seeddatabase()
    {
        $file = CMS_ROOT .'../data/dbschema/a2zcms_seed.sql';

        if ($sql = file($file)) 
        {
            $query = '';

            foreach($sql as $line) 
            {
                $tsl = trim($line);

                if (($sql != '') && (substr($tsl, 0, 2) != "--") && (substr($tsl, 0, 1) != '#')) 
                {
                    $query .= $line;
  
                    if (preg_match('/;\s*$/', $line)) 
                    {
                        $query = str_replace("INSERT INTO `", "INSERT INTO `" . $this->prefix, $query);
                        
                        $this->db_query($query);
                        $query = '';
                    }
                }
            }
        }
		else {
			throw new Exception('Failed to read ' . CMS_ROOT .'../data/dbschema/a2zcms_seed.sql');
		}
    }
	
	public function import_admin($data)
	{
		$this->db_query("INSERT INTO `" . $this->prefix . "users` 
						(name,surname,email,username,avatar,password,confirmation_code,confirmed,active,last_login,created_at)
						VALUES ('" . $data['name'] . "','" . $data['surname'] . "','" . $data['email'] . "','" . $data['username'] . "',
						'" . $data['avatar'] . "','" . $data['password'] . "','" . $data['confirmation_code'] . "','" . $data['confirmed'] . "'
						,'" . $data['active'] . "','" . $data['last_login'] . "','" . $data['created_at'] . "')");
	}
    public function update_site_name($site_name)
    {
        $this->db_query("UPDATE `" . $this->prefix . "settings` SET `value` = '" . $this->db_escape($site_name) . "' WHERE `varname` = 'title'");
    }
	
	public function update_site_theme($sitetheme)
    {
        $this->db_query("UPDATE `" . $this->prefix . "settings` SET `value` = '" . $this->db_escape($sitetheme) . "' WHERE `varname` = 'sitetheme'");
    }

    public function update_pageitem($pageitem)
    {
        $this->db_query("UPDATE `" . $this->prefix . "settings` SET `value` = '" . $this->db_escape($pageitem) . "' WHERE `varname` = 'pageitem'");
    }
    
    public function db_connect()
    {
        if (empty($this->driver))
        {
            throw new Exception('Unable to determine which MySQL driver to use.');
        }

        if ($this->driver == 'mysqli')
        {
            $this->_conn = new mysqli($this->hostname, $this->username, $this->password, $this->database, $this->port);
        }
        else if ($this->driver == 'mysql')
        {
            $this->_conn = mysql_connect($this->hostname . ':' . $this->port, $this->username, $this->password);
            mysql_select_db($this->database, $this->_conn);
        }
    }

    public function db_query($query)
    {
        if ($this->driver == 'mysqli')
        {
            $result = $this->_conn->query($query);

            if ( ! $result)
            {
                throw new Exception('Invalid Query: ' . $this->_conn->error);  
            }
        }
        else if ($this->driver == 'mysql')
        {
            $result = mysql_query($query, $this->_conn);

            if ( ! $result)
            {
                throw new Exception('Invalid Query: ' . mysql_error($this->_conn)); 
            }
        }
    }

    public function db_escape($string)
    {
        if ($this->driver == 'mysqli')
        {
            return $this->_conn->real_escape_string($string);
        }
        else if ($this->driver == 'mysql')
        {
            return mysql_real_escape_string($string, $this->_conn);
        }
    }

}