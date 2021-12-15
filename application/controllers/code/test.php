<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

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


		$a = '0000000246NICEIF 02101F003N503P000RENTHANA 2021120905022352324238 20211209140223CF00000000000001112433576503713N00주자전 GCl9o2EcQjI2001016400RK0600_000000000000000311831153214205021080000076100000.38% 000000737 S15';
		$b = '0000000246NICEIF 02101F003N503P000RENTHANA 2021120905371352326367 20211209143713CF00000000000001115833122827448N00삼사영 GC49obJCRjI2001016400RK0600_000000000000000321432152050210800000000079100000.29% 000000655 S15';
		$c = '0000000246NICEIF 02101F003N503P000RENTHANA 2021120905372352326382 20211209143723CF00000000000001118833532967858N00테스트 GCT9obZCRjI2001016400RK0600_000000000000000351631183115205021080000070300000.60% 000000927 S15';

		echo "1 길이 : " . strlen($a) . "<br>";
		echo "2 길이 : " . strlen($b) . "<br>";
		echo "3 길이 : " . strlen($c) . "<br>";

		echo $a;
		echo "<br>";



//문자열 검사
		$chk1 = substr($a, 145, 10);
		$chk2 = substr($a, 66, 14);
		$chk3 = substr($c, 82, 12);


		echo "chk1 결과 : " . $chk1 . "<br>";
		echo "chk2 결과 : " . $chk2 . "<br>";
		echo "chk3 결과 : " . $chk3 . "<br>";

//문자열 찾기
		$findout1 = strpos($a, 'RK0600');
		echo "문자열 찾기 결과 : " . $findout1 . "<br>";

		
		
		//찾아낸 결과
		$str = '';
		$str .= substr($a, 0, 10); //Transaction code
		$str .= substr($a, 10, 7); //전문 그룹 코드
		$str .= substr($a, 17, 4); //전문 종별 코드
		$str .= substr($a, 21, 5); //거래 구분 코드
		$str .= substr($a, 26, 1); //송수신 Flag
		$str .= substr($a, 27, 3); //단말기 구분
		$str .= substr($a, 30, 4); //응답 코드
		$str .= substr($a, 34, 9); //user ID
		$str .= substr($a, 45, 14); //기관전문 전송시간
		$str .= substr($a, 59, 7); //기관전문 관리번호
		$str .= substr($a, 66, 14); // NICE전문 전송시간
		$str .= substr($a, 80, 16); //primary bitmap
		$str .= substr($a, 82, 12); //보고서 인증번호
		$str .= substr($a, 145, 10);//평점표 ID





	//	$this->load->view('home', $data);
	
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
