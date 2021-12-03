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

		$this->load->model('Board_model');


		//레이아웃 파일 설정
		$this->layout = 'default';
		$this->yield = true;
		$this->left = 'left3' ;

		$this->param = $this->input->post(NULL, true);
        $this->temps_code_list = $this->config->item( 'temps_code' ); //
		

	}

	public function index()
	{

		//검색
		$searchText 		= isset($_GET['filter_name']) ? trim($_GET['filter_name']) : '';

		//페이지 시작 변수
		$page 				= isset($_GET['page']) ? trim($_GET['page']) : 1;

		//현재 페이지
		$curPage			= isset($_GET['p']) ? $_GET['p'] : 1;

		$url 				= $_SERVER['PHP_SELF'];
		$link_url			= $_SERVER['QUERY_STRING'];


		//표시되는 페이지 수
		$rowsPage 			= 3;

		$total 				= $this->Board_model->getTotal($searchText);
		$totalPage 			= $this->Board_model->totalPage($total, $rowsPage);
		
        $data['boardList'] 	= $this->Board_model->get_view($curPage, $rowsPage, $searchText); //리스트 출력
		$data['noticeList'] = $this->Board_model->get_noticeView();
		$data['curPage']	= $curPage;
		$data['total'] 		= $total;
		$data['rowsPage'] 	= $rowsPage;
		$data['link_url'] 	= $link_url;
		$data['searchText'] = $searchText;
		

		$arr = array(
			'url' 		=> $url,
			'total'		=> $total,
			'rowsPage'	=> $rowsPage,
			'curPage'	=> $curPage,
			'link_url'	=> $link_url

		);

		$data['pagingArr'] = $this->Board_model->pageView($arr);



		$this->load->view('home', $data);

		
	
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
