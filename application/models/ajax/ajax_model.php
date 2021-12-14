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
	function get_view($param, $start, $rowsPage) {

		$start = ($start - 1) * $rowsPage;

		if(is_array($param)) {
			$whereArr =	$this->_whereParam($param);

		}

//		$this->db->select("*");
//		$this->db->from("board");

		$query = 'SELECT * FROM board ';

		if(is_array($param)) {
//			$this->db->where($whereArr); 
			$query .= 'WHERE ' . $whereArr;
		}

		$query .= 'ORDER BY regdate DESC limit ' . $start . ', ' . $rowsPage;

//		$this->db->order_by('regdate', 'DESC');
//		$this->db->limit($start, $rowsPage);

	
//		$result = $this->db->get();


//		return $result->result();


		return $this->db->query($query)->result();
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

		if(is_array($param)){
			$where = $this->_whereParam($param);
			$query = 'SELECT count(*) as cnt FROM board where ' . $where;

		} else {
			$query = 'SELECT count(*) as cnt FROM board ';
		}
        
        return $this->db->query($query)->row('cnt');
    }

    //한 건 출력
    function load($idx) {

        if(!$idx) {
            return false;
        }

        //조회수 추가
        $this->_increaseCnt($idx);

        $query      = "SELECT * FROM board WHERE idx = ". $idx;
        $rowData    = $this->db->query($query)->row();

        return $rowData;
        
    }


	//파일 한 건 출력
    function fileLoad($boardId) {

        if(!$boardId) {
            return "";
        }

        $query      = "SELECT * FROM board_file WHERE boardId = ". $boardId;
        $rowData    = $this->db->query($query)->row();

        return $rowData;
        
    }



    private function _call_json($is_valid) {
        $json               = null;
        $json['is_valid']   = $is_valid;

        echo json_encode($json);
    }

}
