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

		$this->load->model('Board');
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
        $data['load'] = $this->Board->load($id);

		$this->load->view('edit', $data);
	}

	function save()
	{
		//저장
        $data['idx'] 		= $this->input->post('id');
		$data['name'] 		= $this->input->post('name');
		$data['title'] 		= $this->input->post('title');
		$data['content'] 	= $this->input->post('editordata');
	

		if($data['title'])
		{
			$response = $this->Board->modify($data);

			if($response == true)
			{
				echo '<script>
						alert("수정되었습니다.");
						location.replace("/");
					</script>';
			} else {
				echo '<script>
						alert("잠시 후 다시 시도해주세요.");
					</script>';
			}
		} 
				echo '<script>
						alert("제목을 입력해주세요.");
						window.history.back();		
					</script>';
		
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */