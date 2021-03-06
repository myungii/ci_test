<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends CI_Controller {

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

		$this->load->model('Board_model');
		$this->load->model('Reply_model');
		//$this->load->model(array('Adjehyuclass', 'Usersclass'));

		//레이아웃 파일 설정
		$this->layout = 'default';
		$this->yield = true;
		$this->left = 'left3' ;

		$this->param = $this->input->post(NULL, true);
        $this->temps_code_list = $this->config->item( 'temps_code' ); 
		

	}

	public function index()
	{

        $id = $this->input->get('id');
        $data['content'] 	= $this->Board_model->load($id);

		if($this->Board_model->fileLoad($id)) {
			$fileInfo = $this->Board_model->fileLoad($id);
			
			$data['file_name']	= $fileInfo->fileName;
			$data['file_idx']	= $fileInfo->idx;
			
		} else {
			$data['file_name'] = '';
			$data['file_idx']  = '';
		}

		

		$data['pid'] 		= $id;
		$data['reply']		= $this->Reply_model->get_view($id);
		$data['total']		= $this->Reply_model->getTotal($id);


		$this->load->view('content', 	$data);
		
		
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
