<?php
class Board_model extends CI_Model {

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
	function get_view($start, $rowsPage, $searchText) {

        $start            = ($start - 1) * $rowsPage;

        if($searchText)
        {
            $query = 'SELECT * FROM board WHERE title like "%' . $searchText.'%" ORDER BY regdate DESC limit ' . $start . ',' . $rowsPage;

            return $this->db->query($query)->result();
        } else {
            $query = 'SELECT * FROM board WHERE title like "%' . $searchText.'%" ORDER BY regdate DESC limit ' . $start . ',' . $rowsPage;
                        
            return $this->db->query($query)->result();                 
        }

	}

    //공지 리스트 출력
    function get_noticeView() {
        $query = 'SELECT * FROM board WHERE notice != 0 or notice !=null';   

        return $this->db->query($query)->result();
    }
/*
    function getName() {
        //$this->db->get_where('board', array('idx' => '1'));
        $query = "SELECT * FROM board WHERE idx = 1";
        $name  = $this->db->query($query)->row('name');
        
        return $name;
        
    }
*/
    //추가
    function add($data = array()) {
        if($data <= 0)
       {
            return false;
       }

        $data['regdate']    = date("Y-m-d H:i:s");

        $this->db->insert('board', $data);

        if($this->db->affected_rows())
        {
            return true;
        }
        
	}

    //파일 업로드
    function fileUpload($data) {
        
        if($data <= 0)
        {
            $is_valid = '0';
        } else {

			$this->db->insert('board_file', $data);
			$is_valid = '1';
		}

		$this->_call_json($is_valid);
        
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

    //파일 삭제
    function fileDelete($idx) {
        if($idx)
        {
            $this->db->where('idx', $idx);
            $this->db->delete('board_file');

            if($this->db->affected_rows() > 0)
            {
                return true;
            } 
            
        }

        return false;
	}



    //파일수정
    function fileModify($data = array()) {


        $dataArr    = array();
        $where      = array (
                        "idx"       => $data['idx']
                    );

print_r($data);
        if(!$data['idx'])
        {
			$id_valid = '0';
        } else {

            $dataArr['fileName']            = $data['fileName'];
            $dataArr['fileSize']            = $data['fileSize'];
            $dataArr['filePath']            = $data['filePath'];
            $dataArr['fileType']            = $data['fileType'];
            $dataArr['regdate']             = date("Y-m-d H:i:s");
            $dataArr['fullFilePath']        = $data['fullFilePath'];

            $result = $this->db->update('board_file', $dataArr, $where);
			$is_valid = '1';

        }
		$this->_call_jason($is_valid);

    }
    


    private function _increaseCnt($idx) {

        if(!$idx)
        {
            return false;
        }

        $this->db   ->set('cnt', 'cnt+1', FALSE)
                    ->where('idx', $idx)
                    ->update('board');
        
        if($this->db->affected_rows() > 0)
        {
            return true;
        } 

        return false;
    }

    //수정
    function modify($data = array()) {

        $dataArr    = array();
        $where      = array (
                        "idx" => $data['idx']
                    );

        if(!$data['idx'])
        {
            return false;
        }
            $dataArr['name']         = $data['name'];
            $dataArr['title']        = $data['name'];
            $dataArr['content']      = $data['content'];
            $dataArr['regdate']      = date("Y-m-d H:i:s");

            $this->db->update('board', $dataArr, $where);

            if($this->db->affected_rows() > 0)
            {
                return true;
            } 
    
    }

    //등록일 포맷 변경
    static function setRegdate($date)
    {
        if(!$date)
        {
            return "";
        }

        return date("Y-m-d", strtotime($date));

    }

    //새글 표시
    static function displayNew($regdate='')
    {
        //하루 단위
        //$time		= strtotime($regdate);
		//$today		= time();
		//$result = (($today - $time)/60/60/24)*10;

		$time = substr($regdate,0, 10);
		$today = date("Y-m-d");

        //if($result <= 1)
        if($time == $today)
        {
            return " <span id='new'>new</span>";
        }

        return '';
    }

    //lnb 목록 새글 갯수 표시
    static function newCnt() 
    {
        $query = 'SELECT count(idx) AS cnt FROM board WHERE substr(regdate, 1, 10) = substr(now(), 1, 10)';

        return self::$db->query($query)->row('cnt');
    }


    //총 게시글 개수
    function getTotal($searchText) {
        //$query = "SELECT count(*) as cnt FROM board";
        $query = 'SELECT count(*) as cnt FROM board WHERE title like "%' . $searchText.'%" ';
        
        return $this->db->query($query)->row('cnt');
    }

    //총 페이지 개수
    function totalPage($num, $rowPage){
        return intval(($num-1)/$rowPage)+1;
    }

    //페이징
    function pageView($arr = array())
    {
        $url        = $arr['url'];
        $totalcnt   = $arr['total'];
        $rowsPage   = $arr['rowsPage'];
        $curPage    = $arr['curPage'];
        $link_url   = $arr['link_url'];
        //$qryChk     = $arr['qry'];

        
        //페이지 파라미터 중복제거
        if($link_url != '')
        {
            $link_url = preg_replace('/[\&]?p=[0-9]+[\&]?/', '', $link_url);
            
        }


        $Info = $this->_pageList($totalcnt, $rowsPage, $curPage, 10);
        
        $result = array();
        if ($Info['current_block'] > 2) {
            array_push($result, "<li><a href='" . $url . "?p=1&" .  $link_url . "'>◀</a></li> ");
        }
        if ($Info['current_block'] > 1) {
            array_push($result, "<li><a href='" . $url . "?p=" . $Info['prev'] . "&" . $link_url . "'>◁</a></li> ");
        }
        foreach ($Info['current'] as $w) {
            
            if ($curPage == $w) {
                
                array_push($result, "<li class='act'><a href='" . $url . "?p=" . $w . "&" . $link_url  . "'><span style='color:red;'>" . $w . "</span></a></li> ");
                
            } else {
                array_push($result, "<li><a href='" . $url . "?p=" . $w . "&" . $link_url . "'>" . $w . "</a></li> ");
            }
        }
        if ($Info['current_block'] < ($Info['total_block'])) {
            array_push($result, "<li><a href='" . $url . "?p=" . $Info['next'] . "&" . $link_url . "'>▷</a></li> ");
        }
        if ($Info['current_block'] < ($Info['total_block'] - 1)) {
            array_push($result, "<li><a href='" . $url . "?p=" . $Info['totalPage'] . "&" . $link_url . "'>▶</a></li> ");
        }

        return $result;
     
    }

    private function _pageList($totalcnt,$rowsPage,$curPage,$block_limit) {


        //현재 페이지
        $curPage = $curPage ? $curPage : 1;

        //페이지 당 게시글 개수
        $block_limit = $block_limit ? $block_limit : 10;

        //현재 블럭
        $current_block=ceil($curPage/$block_limit);

        //총 페이지
        $totalPage = ceil($totalcnt/$rowsPage);
        if($totalPage == 0) {
            ++$totalPage;
        }

        //전체 블록 개수
        $total_block = ceil($totalPage / $block_limit);

        //현재 블럭의 시작 페이지
        $fstPage            = (((ceil($curPage/$block_limit)-1)*$block_limit)+1);

        //현재 블럭의 마지막 페이지
        $endPage            = $fstPage + $block_limit -1;

        if($totalPage < $endPage) {
            $endPage        = $totalPage;
        }
        
        // 시작 바로 전 페이지
        $prev_page = $fstPage - 1;

        // 마지막 다음 페이지
        $next_page = $endPage + 1;

        

        foreach(range($fstPage, $endPage) as $val) {
            $row[] = $val;
        }

        return array(
            'total_block'   => $total_block,
            'current_block' => $current_block,
            'totalPage'     => $totalPage,
            'fstPage'       => $fstPage,
            'endPage'       => $endPage,
            'prev'          => $prev_page,
            'next'          => $next_page,
            'current'       => $row
        );

    } 


    private function _call_json($is_valid) {
        $json               = null;
        $json['is_valid']   = $is_valid;

print_r("jason model : " . $json);

        echo json_encode($json);
    }

}
