<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit extends CI_Controller {

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

        $id = $_GET['id'];

        $data['load'] 	= $this->Board_model->load($id);

		$data['file'] 	= $this->Board_model->fileLoad($id);

		$this->load->view('edit', $data);
	}

	function save()
	{
		//저장
		$data['idx'] 		= $this->input->post('id');
		$data['name'] 		= $this->input->post('name');
		$data['title'] 		= $this->input->post('title');
		$data['notice'] 	= $this->input->post('notice');
		$data['content'] 	= $this->input->post('content');
		$upload_file        = $this->input->post('upload_file');


		if($data['notice'] == 'Y')
		{
			$data['notice'] = 1;
		} else {
			$data['notice'] = 0;
		}

		

		$result = $this->Board_model->add($data);



		//파일 업로드 및 저장
		$config['upload_path'] 		= './uploads';
		$config['allowed_types']	= 'gif|jpg|png';
		$config['max_size']			= '0';
		$config['max_width']		= '0';
		$config['max_height']		= '0';

		$this->load->library('upload', $config);

		if($upload_file) {

			//기존 파일 삭제
			$oldFile = $this->Board_model->fileLoad($data['idx']);
			$oldFileId = $oldFile->idx;

			$oldDel = $this->Board_model->fileDelete($oldFileId);



			$fileInfo =  $this->upload->data();
			
			$fileData = array(
								'boardId' 		=> $data['idx'],
								'fileName' 		=> $fileInfo['file_name'],
								'fileSize'		=> intval($fileInfo['file_size']),
								'filePath'		=> $fileInfo['file_path'],
								'fileType'		=> $fileInfo['file_type'],
								'fullFilePath'	=> $fileInfo['full_path']
						);
			

			$this->Board_model->fileUpload($fileData);
			
		}
		
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
