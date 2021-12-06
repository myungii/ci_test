<?php
class Reply_model extends CI_Model {

  

    private static $db;

	function __construct($arr = 0) {
		parent::__construct();
		self::$db = &get_instance()->db;

    }

    //리스트 출력
	function get_view() {

        $query = 'SELECT * FROM reply WHERE title like ORDER BY regdate DESC';

        return $this->db->query($query)->result();                 
 

	}

    //추가
    function add($data) {

        print_r($data);

        $param = array(
                    "pid"       => (int)$data->pid,
                    "name"      => $data->name,
                    "content"   => $data->content,
                    "regdate"   => date("Y-m-d H:i:s")
                );
        
        if($data < 0)
        {
            return false;
        }

        $this->db->insert('reply', $param);
        return true;
	}



    //삭제
    function delete($idx) {
        if($idx)
        {
            $this->db->where('idx', $idx);
            $this->db->delete('reply');

            if($this->db->affected_rows() > 0)
            {
                return true;
            } 
            
        }

        return false;
	}

 
    

    //수정
    function modify() {

 

        return '';
    }

    //등록일 포맷 변경
    static function setRegdate()
    {
        return '';

    }

    //새글 표시
    static function displayNew()
    {
     

        return '';
    }



    //총 게시글 개수
    function getTotal() {
   
        
        return '';
    }


}
