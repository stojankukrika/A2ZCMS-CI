<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Model_page_plugin_function extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	public function total_rows() {
        return $this->db->where(array('deleted_at' => NULL))->count_all("page_plugin_functions");
    }
	
    public function fetch_paging($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->get("page_plugin_functions");
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	public function delete($page_id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('page_id', $page_id);
			$this->db->update('page_plugin_functions', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->get('page_plugin_functions')->first_row();
    }
	
	public function insert($data) {		
		$this->db->insert('page_plugin_functions', $data);
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('page_plugin_functions', $data);
    }
	
	public function contentpluginfunction()
	{
		return	 $this->db->from('plugin_functions pf')
													->join('plugins p', 'p.id = pf.plugin_id')
													->where('type','content')
													->where('pf.deleted_at', NULL)
													->select('pf.title, p.name, p.function_id, pf.id, pf.function, pf.params, p.function_grid')
													->get()->result();
	}
	
	public function contentpluginfunctionpage($id)
	{
		return $this->db->from('page_plugin_functions ppf')
												->join('plugin_functions pf','pf.id = ppf.plugin_function_id' ,'left')
												->join('plugins p','p.id = pf.plugin_id' ,'left')
												->where('ppf.deleted_at', NULL)
												->where('page_id', $id)
												->where('pf.type','content')
												->order_by('ppf.order','ASC')
												->group_by('pf.id')
												->select('pf.id, ppf.plugin_function_id, p.name,pf.title, ppf.order, p.function_id, pf.function, pf.params, p.function_grid')
												->get()->result();
	}
	
	public function sidepluginfunction()
	{
		return $this->db->from('plugin_functions pf')
					->where('type','sidebar')
					->where('pf.deleted_at', NULL)
					->get()->result();
	}
	
	public function sidepluginfunctionpage($id)
	{
		return $this->db->from('page_plugin_functions ppf')
												->join('plugin_functions pf','pf.id = ppf.plugin_function_id' ,'left')
												->where('page_id', $id)
												->where('pf.type','sidebar')
												->where('ppf.deleted_at', NULL)
												->order_by('ppf.order','ASC')
												->group_by('pf.id')
												->select('pf.id, pf.title, ppf.order')
												->get()->result();
	}
	
	public function contentparamitem($param,$id,$plugin_function_id)
	{
		return $this->db->from('page_plugin_functions ppf')
													->where('param',$param)
													->where('page_id',$id)
													->where('ppf.deleted_at', NULL)
													->where('plugin_function_id',$plugin_function_id)
													->select('value')					
													->get()->first_row();
	}
}