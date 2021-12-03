<?php
class Reply_model extends CI_Model {

    private $idx;
    private $pid;
    private $name;
    private $content;
    private $regdate;


	function __construct($id = '') {
		parent::__construct();

        $this->idx = $id;

    }

    //리스트 출력
	function get_view() {

        return 0;
	}


    //추가
    function add() {
   

      return 0;
	}

    //삭제
    function delete() {
    
        return 0;
	}

    //한 건 출력
    function load() {

        return 0;
    }


    //수정
    function modify() {

        return 0;
    }

    //등록일 포맷 변경
    static function setRegdate()
    {
        
        return 0;
    }

  
}
