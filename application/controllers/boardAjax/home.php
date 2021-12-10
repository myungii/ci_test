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


		
		$this->output->set_content_type('application/json/');
		//echo  json_encode($data, JSON_UNESCAPED_UNICODE); 
		echo jason_encode(array("abc"=>"abcde"));
		exit;

/*

		if($data->num_rows() > 0)
		{

			foreach($data->result() as $row)
			{

				$output .= '
					         <tr>
						         <td id="noticeList">' . $row->idx  .' </td>
							     <td>
								     <a href="#">' . $row->title .'</a></td>
								<td>' . $row->name . '</td>
				    		     <td>' . $row->regdate . '</td>
							     <td>' . $row->cnt . '</td>
							 </tr>
							';

			}

		} else {
			$output .= '<tr> 
							<td colspan="5"> 테이터가 없습니다 </td>
					    </td>';

		}

		echo $output;
*/


	


 //       echo urldecode(json_encode($noticedArr));
    

  //      $data['boardList'] = urldecode(json_encode($boardArr));
 //       $data['noticeList'] = urldecode(json_encode($noticeArr));


	}

}
