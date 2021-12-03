<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Write extends CI_Controller {

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

		//레이아웃 파일 설정
		$this->layout = 'default';
		$this->yield = true;
		$this->left = 'left3' ;

		$this->param = $this->input->post(NULL, true);
        $this->temps_code_list = $this->config->item( 'temps_code' ); 
		

	}

	public function index()
	{

		$this->load->view('write');
	}

	function save()
	{
		//저장
		$name		= $_POST['name'];
		$title		= $_POST['title'];
		$content	= $_POST['content'];

		$data = array(
					'name' 		=> $name,
					'title' 	=> $title,
					'content' 	=> $content
				);
	
		$result = $this->Board_model->add($data);
		
		if($result == true)
		{
			echo "200";
			exit;
		}
		
		echo "99";
		
	}

	function preedit() 
	{
		$id = $this->input->get('id');
		$data['info'] = $this->Board_model->load($id);
	
		
		$this->load->view('write', $data);
	
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */