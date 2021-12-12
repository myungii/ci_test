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
				"idx"			=> $li->idx,
				"title"			=> $li->title,
				"name"			=> $li->name,
				"content"		=> $li->content,
				"cnt"			=> $li->cnt,
				"regdate"		=> $li->regdate,
				"fileid"		=> $li->fileid,
				"notice"		=> $li->notice,
				"modidate"		=> $li->modidate
			);

			$list[] = $row;


		}

		$total = $this->ajax_model->getTotal();


		$paging = array(
					"a" => 1,
					"b" => "abc",
					"c" => 123

		);



			$result = array( "list" => $list, "total" => $total, "paging" => $paging );


		$this->output->set_content_type('application/json');
		$this->display($result);

  //      $data['boardList'] = urldecode(json_encode($boardArr));


	}


	public function save() {/*{{{*/
		

		//저장
		$name		= $this->input->post('name');
		$title		= $this->input->post('title');
		$content	= $this->input->post('content');
		$notice		= $this->input->post('notice');

		if($notice == 'Y')
		{
			$notice = 1;
		} else {
			$notice = 0;
		}

		$data = array(
					'name' 		=> $name,
					'title' 	=> $title,
					'content' 	=> $content,
					'notice' 	=> $notice
			);
		$result = $this->Board_model->add($data);
		$lastId = (int)$this->db->insert_id();


		//파일 업로드 및 저장
		$config['upload_path'] 		= './uploads';
		$config['allowed_types']	= 'gif|jpg|png';
		$config['max_size']			= '0';
		$config['max_width']		= '0';
		$config['max_height']		= '0';


		$this->load->library('upload', $config);


		if($this->upload->do_upload('upload_file') == true) {
			$fileInfo =  $this->upload->data();

			$fileData = array(
								'boardId' 		=> $lastId,
								'fileName' 		=> $fileInfo['file_name'],
								'fileSize'		=> intval($fileInfo['file_size']),
								'filePath'		=> $fileInfo['file_path'],
								'fileType'		=> $fileInfo['file_type'],
								'regdate'		=> date("Y-m-d H:i:s"),
								'fullFilePath'	=> $fileInfo['full_path']
						);
			
			$this->Board_model->fileUpload($fileData);
			
		} 


		if($result == true)
		{
			echo "200";
			exit;
		}
		else {
			echo "99";
		}



	}/*}}}*/

	/*********************
	* @title 공용 출력
	* @param $data json
	* @return json
	**********************/
	public function display($data)/*{{{*/
	{
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		exit;
	}/*}}}*/



}
