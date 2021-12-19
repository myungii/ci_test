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
        
        $this->load->view('boardAjax/write');
    }




	public function save($name, $title, $content, $notice) {
		

		//저장

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
		$result = $this->ajax_model->add($data);
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
			
			$this->ajax_model->fileUpload($fileData);
			
		} 


		if($result == true)
		{
			echo "200";
			exit;
		}
		else {
			echo "99";
		}



	}



	function ajaxPopup() {

		$name		= $_POST['name'];
		$title		= $this->input->post('title');
		$content	= $this->input->post('content');
		$notice		= $this->input->post('notice');

		if($name && $title && $content && $notice) {

			$this->save($name, $title, $content, $notice);
		}

	} //ajaxPopup end


	//수정
	function editPopup() {

		$name		= $_POST['name'];
		$idx		= $_POST['idx'];
		$title		= $this->input->post('title');
		$content	= $this->input->post('content');
		$notice		= $this->input->post('notice');
		$old_file   = $this->input->post('old_file');

		if($name && $title && $content && $notice) {

			$this->editSave($idx, $name, $title, $content, $notice, $old_file);
		}



	} //editPopup end


	function editSave($idx, $name, $title, $content, $notice, $old_file) {

		//수정

		if(!$old_file)
		{
			$old_file = '';
		}

		if($notice == 'Y')
		{
			$notice = 1;
		} else {
			$notice = 0;
		}

		$data = array(
					'idx'		=> $idx,
					'name' 		=> $name,
					'title' 	=> $title,
					'content' 	=> $content,
					'notice' 	=> $notice
			);


		$boardResult = $this->ajax_model->modify($data);



		if($old_file) {

			//기존 파일 삭제
			$oldDel = $this->ajax_model->fileDelete($old_file);

		}

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
								'boardId' 		=> $data['idx'],
								'fileName' 		=> $fileInfo['file_name'],
								'fileSize'		=> intval($fileInfo['file_size']),
								'filePath'		=> $fileInfo['file_path'],
								'fileType'		=> $fileInfo['file_type'],
								'fullFilePath'	=> $fileInfo['full_path']
						);
			
			$result = $this->ajax_model->fileUpload($fileData);
			
			echo "1";
		   
		}


	} //editSave end



}
