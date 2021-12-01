<?php
class Board extends CI_Model {

    private $idx;
    private $title;
    private $name;
    private $content;
    private $regdate;
    private $cnt;
    private $fileid;

	function __construct() {
		parent::__construct();
        
    }

    //리스트 출력
	function get_view() {
        $query = $this->db->get('board');


        
        return $query->result();
	}


    function getName() {
        //$this->db->get_where('board', array('idx' => '1'));
        $query = "SELECT * FROM board WHERE idx = 1";
        $name  = $this->db->query($query)->row('name');
        
        return $name;
        
    }

    //추가
    function add($data = array()) {
        if($data)
        {
            if(!$data['regdate'])
            {
                $data['regdate']    = date("Y-m-d H:i:s");
            }

            $this->db->insert('board', $data);
            return true;
        } 

      return false;
	}

    //삭제
    function delete($idx) {
        if($idx)
        {
            $this->db->where('idx', $idx);
            $this->db->delete('board');

            if($this->db->affected_rows() > 0)
            {
                return true;
            } 
            
        }

        return false;
	}

    //한 건 출력
    function load($idx) {

        if(!$idx) {
            return false;
        }
    
        $query      = "SELECT * FROM board WHERE idx = ". $idx;
        $rowData    = $this->db->query($query)->row();

        return $rowData;
        
    }

    //등록일 포맷 변경
    static function setRegdate($date)
    {
        if(!$date)
        {
            return false;
        }

        return date("Y-m-d", strtotime($date));

    }

}