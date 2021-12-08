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
		$aa = $this->input->post('data');
		
		echo $aa;
	
		$boardList 	= $this->board_model->get_view(1, 5, ""); //리스트 출력
		$noticeList = $this->board_model->get_noticeView();

        $boardArr  = array();
        $noticeArr = array();

		$datatest = array('boardList' => $boardList);

		//echo  json_encode($datatest); 

		

/*
        foreach($noticeList as $notice)
        {
            array_push($noticeArr, $notice->idx);
            array_push($noticeArr, urlencode($notice->name));
            array_push($noticeArr, urlencode($notice->title));
            array_push($noticeArr, urlencode($notice->content));
            array_push($noticeArr, $notice->regdate);
        } 
*/
 //       echo urldecode(json_encode($boardArr));
    

  //      $data['boardList'] = urldecode(json_encode($boardArr));
 //       $data['noticeList'] = urldecode(json_encode($noticeArr));


	}

}
