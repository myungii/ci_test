<?php
class Ajax_model extends CI_Model {

    private $idx;
    private $title;
    private $name;
    private $content;
    private $regdate;
    private $cnt;
    private $fileid;

    private static $db;

	function __construct($arr = 0) {
		parent::__construct();
		self::$db = &get_instance()->db;

    }

    //리스트 출력
	function get_view($param) {

		if(is_array($param)) {
			$whereArr =	$this->_whereParam($param);

		}

		$this->db->select("*");
		$this->db->from("board");

		if(is_array($param)) {
			$this->db->where($whereArr); 
		}

		$this->db->order_by('regdate', 'DESC');

		//return $this->db->get();
	
		$result = $this->db->get();

		return $result->result();

	}

	//where 절
	private function _whereParam($param) {


			$whereArr	= '';
			$where		= array();

			if($param['notice'] == 'Y') {

				$where[] .= 'notice = 1 ';	

			} else if($param['notice'] == 'N') {

				$where[] .= 'notice = 0 ';

			} 

			if($param['name'])
			{
				$where[] .= 'name like "%' . $param['name'] . '%" ';
			} 
			if($param['title'])
			{
				$where[] .= 'title like "%' . $param['title'] . '%" ';
			} 
			if($param['reg_start'] && $param['reg_end'])
			{
				$where[] .= '(substr(regdate, 1, 10) >= "' . $param["reg_start"] .'"
							AND substr(regdate, 1, 10) <= "' . $param["reg_end"] .'") ';
			} else if($param['reg_start'] && !$param['reg_end'])
			{
				$where[] .=  substr(regdate, 1, 10) . '>= "' .  $param["reg_start"] .'"' ; 
			} else if($param['reg_end'] && !$param['reg_start'])
			{
				$where[] .=   'substr(regdate, 1, 10) <= "' . $param["reg_end"] . '"'  ;
			} 

			$whereArr = implode(' AND ', $where);

			return $whereArr;
	}



    //총 게시글 개수
    function getTotal($param) {
        //$query = "SELECT count(*) as cnt FROM board";

		if(is_array($param)){
			$where = $this->_whereParam($param);
			$query = 'SELECT count(*) as cnt FROM board where ' . $where;

		} else {
			$query = 'SELECT count(*) as cnt FROM board ';
		}
        
        return $this->db->query($query)->row('cnt');
    }



    private function _call_json($is_valid) {
        $json               = null;
        $json['is_valid']   = $is_valid;

        echo json_encode($json);
    }

}
