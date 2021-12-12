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
	function get_view($query) {

		$this->db->select("*");
		$this->db->from("board");

		if($query != '')
		{
			$this->db->like('name', $query);
			$this->db->or_like('title', $query);
			$this->db->or_like('content', $query);
			$this->db->or_like('regdate', $query);

		}

		$this->db->order_by('regdate', 'DESC');

		//return $this->db->get();
	
		$result = $this->db->get();

		return $result->result();

	}



    //총 게시글 개수
    function getTotal() {
        //$query = "SELECT count(*) as cnt FROM board";
        $query = 'SELECT count(*) as cnt FROM board ';
        
        return $this->db->query($query)->row('cnt');
    }



    private function _call_json($is_valid) {
        $json               = null;
        $json['is_valid']   = $is_valid;

        echo json_encode($json);
    }

}
