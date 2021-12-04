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


		$this->load->view('reply');
	
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
