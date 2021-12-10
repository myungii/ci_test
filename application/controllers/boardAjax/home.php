<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

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

		$this->load->model('board_model');
		$this->load->model('/ajax/ajax_model');
		$this->load->model('/pagination/paging');


		//레이아웃 파일 설정
		$this->layout = 'default';
		$this->yield = true;
		$this->left = 'left3' ;

		$this->param = $this->input->post(NULL, true);
        $this->temps_code_list = $this->config->item( 'temps_code' ); //
		

	}

	public function index()
	{
        
        $this->load->view('boardAjax/home');
    }


	public function ajaxList()
	{
		
		$output = '';
		$query = '';

		if($this->input->post('query'))
		{
			$query = $this->input->post('query');

		}


		$data = $this->ajax_model->get_view($query);

		$result = array();
		foreach($data as $li)
		{

				if($li->fileid == null)
				{
				$li->filed = "";

				}


				if($li->notice == null)
				{	
				$li->notice = "";

				}


				if($li->modidate == null)
				{
				$li->modidate = "";

				}


			$row = array (

				$row["idx"]			= $li->idx,
				$row["title"]		= $li->title,
				$row["name"]		= $li->name,
				$row["content"]		= $li->content,
				$row["cnt"]			= $li->cnt,
				$row["regdate"]		= $li->regdate,
				$row["fileid"]		= $li->fileid,
				$row["notice"]		= $li->notice,
				$row["modidate"]	= $li->modidate

			);

		$result[] = $row;

		}

var_dump(json_encode($result, JSON_UNESCAPED_UNICODE));exit;
		
		$this->output->set_content_type('application/json/');
		echo json_encode($result, JSON_UNESCAPED_UNICODE);

    

  //      $data['boardList'] = urldecode(json_encode($boardArr));


	}

}
