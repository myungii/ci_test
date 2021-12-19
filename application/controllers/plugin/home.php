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
		$this->load->model('ajax/ajax_model');
		$this->load->model('/pagination/paging');
		$this->load->model('Reply_model');


		//레이아웃 파일 설정
		$this->layout = 'default';
		$this->yield = true;
		$this->left = 'left3' ;

		$this->param = $this->input->post(NULL, true);
        $this->temps_code_list = $this->config->item( 'temps_code' ); //
		

	}

	public function index()
	{
        
        $this->load->view('plugin/home');
    }


	public function pluginList()
	{
		$rowsPage	= 10;

		//현재 페이지
	    $curPage = ($this->input->post('page')) ? $this->input->post('page'):1;


		$url		= $_SERVER['PHP_SELF'];
		$link_url	= $_SERVER['QUERY_STRING'];


		//검색
		$parse = array();

		if($this->input->post('search'))
		{
			parse_str($this->param['search'], $parse);
			//$query = $this->input->post('search');
		}

		$query = array(
						"title"		=> $parse['title;'],
						"name"      => $parse['name;'],
						"reg_start" => $parse['regstart;'],
						"reg_end"   => $parse['regend'],
						"notice"	=> $parse['notice']
		);


		//리스트 출력
		$data = $this->ajax_model->get_view($query, $curPage, $rowsPage);

		$list = array();

		foreach($data as $key => $li)
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


		$total  = $this->ajax_model->getTotal($query);

		$row = array (
			"idx"			=> $li->idx,
			"title"			=> $li->title,
			"name"			=> $li->name,
			"content"		=> $li->content,
			"cnt"			=> $li->cnt,
			"regdate"		=> ajax_model::setRegdate($li->regdate),
			"fileid"		=> $li->fileid,
			"notice"		=> $li->notice,
			"modidate"		=> $li->modidate,
			"index"  		=> $total - ($curPage-1) * $rowsPage - $key
		);

		$list[] = $row;

	}

		$result = array("list"		=> $list, 
						"page"		=> $curPage, 
						"rowsPage"  => $rowsPage,  
						"total"		=> $total);

		$this->output->set_content_type('application/json');
		$this->display($result);

	}


	public function content($num) 
	{
		$id = intval($num);	

        //$id = $this->input->get('id');
        $data['content'] 	= $this->ajax_model->load($id);

		if($this->ajax_model->fileLoad($id)) {
			$fileInfo = $this->ajax_model->fileLoad($id);
			
			$data['file_name']	= $fileInfo->fileName;
			$data['file_idx']	= $fileInfo->idx;
			
		} else {
			$data['file_name'] = '';
			$data['file_idx']  = '';
		}

		

		$data['pid'] 		= $id;
		$data['reply']		= $this->Reply_model->get_view($id);
		$data['total']		= $this->Reply_model->getTotal($id);

		


		$this->load->view('plugin/content', 	$data);
		


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
