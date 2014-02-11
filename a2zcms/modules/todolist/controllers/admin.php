<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Admin extends Administrator_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model("todolist");
	}
	
	function index(){
		$data['view'] = 'dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $todolist = new Todolist();
        $todolist->where(array('deleted_at' => NULL))->where('user_id',$this->session->userdata('user_id'))
			->select('id,title,finished,work_done,created_at')
            ->get_paged($offset, $this->session->userdata('pageitemadmin'), TRUE);

        if ($offset > $todolist->paged->total_rows) {
            $offset = floor($todolist->paged->total_rows / $this->session->userdata('pageitemadmin')) *
                $this->session->userdata('pageitemadmin');
        }
 
        $pagination_config = array(
            'base_url' => site_url('admin/todolist/index/'),
            'first_url' => site_url('admin/todolist/index/0'),
            'total_rows' => $todolist->paged->total_rows,
            'per_page' => $this->session->userdata('pageitemadmin'),
            'uri_segment' => 4,
           	'full_tag_open' => '<ul class="pagination">',
			'first_tag_open' => '<li>',
			'first_link' => '<span class="icon-fast-backward"></span>',
		    'first_tag_close' => '</li>',
			'last_tag_open' => '<li>',
			'last_link' => '<span class="icon-fast-forward"></span>',
			'last_tag_close' => '</li>',
			'next_tag_open' => '<li>',
			'next_link' => '<span class="icon-step-forward"></span>',
			'next_tag_close' => '</li>',
			'prev_tag_open' => '<li>',
			'prev_link' => '<span class="icon-step-backward"></span>',
			'prev_tag_close' => '</li>',
			'cur_tag_open' => '<li class="active"><a>',
			'cur_tag_close' => '</a></li>',
			'num_tag_open' => '<li>',
			'num_tag_close' => '</li>',
			'full_tag_close' => '</ul>',
        );
		
		
        $this->pagination->initialize($pagination_config);
 
        $data['content'] = array(
            'pagination' => $this->pagination,
            'todolist' => $todolist,
            'offset' => $offset
        );
 
        $this->load->view('adminpage', $data);
	}
	
	function create($id=0)
	{
		$data['view'] = 'create_edit';

		$todolist_edit = "";
		
		if($id>0)
		{
			$todolist_edit = new Todolist();
			$todolist_edit->select('id,title,content,finished,work_done,created_at')->where('id',$id)->get();			
		}
		
		$data['content'] = array('todolist_edit' => $todolist_edit);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('title', "Title", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$work_done = ($this->input->post('finished')==100.00)?'1':'0';       	
			$todolist = new Todolist();
			if($id==0){
				$todolist->user_id = $this->session->userdata('user_id');
				$todolist->title = $this->input->post('title');	
				$todolist->content = $this->input->post('content');
				$todolist->finished = $this->input->post('finished');
				$todolist->work_done = $work_done;
				$todolist->updated_at = date("Y-m-d H:i:s");										
				$todolist->created_at = date("Y-m-d H:i:s");
				$todolist->save();
				$id = $todolist->id;
			}
			else {				
				$todolist->where('id', $id)->update(array('title'=>$this->input->post('title'), 
							'content'=>$this->input->post('content'), 
							'finished'=>$this->input->post('finished'), 
							'work_done'=>$work_done, 
							'updated_at'=>date("Y-m-d H:i:s")));
			}
        }
    }
	function delete($id)
	{
		$data['view'] = 'delete';
		$data['content'] = array('todolistid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('todolistid', "Todo-list", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('todolistid');
			
			$todolist = new Todolist();
			$todolist->where('id', $id)->update(array('deleted_at'=>date("Y-m-d H:i:s")));
        }
	}
	function change($id) {				
		$todolist_edit = new Todolist();
		$todolist_edit->select('finished,work_done')->where('id',$id)->get();		
		
		$todolist = new Todolist();			
		$todolist->where('id', $id)->update(array('finished'=>$todolist_edit -> work_done *100.00, 
							'work_done'=>($todolist_edit -> work_done + 1) % 2, 
							'updated_at'=>date("Y-m-d H:i:s")));
		return redirect(base_url('admin/todolist'));

	}
	

}