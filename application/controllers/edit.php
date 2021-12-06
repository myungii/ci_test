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
        $data['load'] = $this->Board_model->load($id);

		$this->load->view('edit', $data);
	}

	function save()
	{
		//저장
		$data['idx'] 		= $this->input->post('id');
		$data['name'] 		= $this->input->post('name');
		$data['title'] 		= $this->input->post('title');
		$data['content'] 	= $this->input->post('editordata');

		$result = $this->Board_model->modify($data);
		$getId  = $data['idx'];


		//파일 업로드 및 저장
		$config['upload_path'] 		= './uploads';
		$config['allowed_types']	= 'gif|jpg|png';
		$config['max_size']			= '0';
		$config['max_width']		= '0';
		$config['max_height']		= '0';

		$this->load->library('upload', $config);

		if(!$this->upload->do_upload('upload_file'))
		{
			$error = array('error' => $this->upload->display_errors());
			
			var_dump($error);
			exit;
		}
		else{
			$fileInfo =  $this->upload->data();
			

			$fileData = array(
								'idx'			=> $data['idx'],
								'boardId' 		=> $getId,
								'fileName' 		=> $fileInfo['file_name'],
								'fileSize'		=> intval($fileInfo['file_size']),
								'filePath'		=> $fileInfo['file_path'],
								'fileType'		=> $fileInfo['file_type'],
								'regdate'		=> date("Y-m-d H:i:s"),
								'fullFilePath'	=> $fileInfo['full_path']
						);
			
			$this->Board_model->fileModify($fileData);
			
		}

		if($result == '1')
		{
			echo "200";
			exit;
		}
		else {
			echo "99";
		}
		
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */