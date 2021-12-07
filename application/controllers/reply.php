<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reply extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct() {
		parent::__construct();

		$this->load->model('Reply_model');
		$this->load->model('Board_model');


		//레이아웃 파일 설정
		//$this->layout = 'default';
		$this->layout = '';
		//$this->yield = true;
		$this->yield = false;
		//$this->left = 'left3' ;
		$this->left = '' ;

		$this->param = $this->input->post(NULL, true);
        $this->temps_code_list = $this->config->item( 'temps_code' ); //
		

	}

	public function index()
	{

		$data['pid'] 		= $this->input->get('pid');
		$data['name'] 		= $this->input->get('name');
		$data['content'] 	= $this->input->get('content');

		$data['reply']		= $this->Reply_model->get_view($data['pid']);

print_r($data);

		$this->load->view('reply');
	
	}

	public function save()
	{
		/*
		$data['pid'] 		= $this->input->post('pid');
		$data['name'] 		= $this->input->post('name');
		$data['content'] 	= $this->input->post('content');
		$data['regdate']	= date("Y-m-d H:i:s");
		*/

		$dataList = json_decode( $_POST['dataObj']);

		$result = $this->Reply_model->add($dataList);

		if($result == true)
		{
			echo "200";
			exit;
		}
		else {
			echo "99";
		}

	}

	public function delete()
	{
		$idx = $this->input->get('replyId');

		$result = $this->Reply_model->delete($idx);
		
	}

	public function modify()
	{
		$data['idx'] 		= $this->input->get('replyId');
		$data['name'] 		= $this->input->get('name');
		$data['content'] 	= $this->input->get('content');
		$data['date'] 		= date("Y-m-d H:i:s");


		$result = $this->Reply_model->modify($data);
		

	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
