<?php
class Board extends CI_Model {

    private $idx;
    private $title;
    private $name;
    private $content;
    private $regdate;
    private $cnt;
    private $fileid;

  

	function __construct($arr = 0) {
		parent::__construct();

    }

    //리스트 출력
	function get_view($current, $rowsPage, $searchText) {
        
        if($searchText)
        {
            $query = 'SELECT * FROM board WHERE title like "%' . $searchText.'%"';
            //limit 지정 필요

            return $this->db->query($query)->result();
        } else {
            $query = 'SELECT * FROM board WHERE title like "%' . $searchText.'%" limit ' . $current . ',' . $rowsPage;

            return $this->db->query($query)->result();                 
        }

        
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
        if($data > 0)
       {
            $data['regdate']    = date("Y-m-d H:i:s");

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

        //조회수 추가
        $this->_increaseCnt($idx);

        $query      = "SELECT * FROM board WHERE idx = ". $idx;
        $rowData    = $this->db->query($query)->row();

        return $rowData;
        
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

        if($data['idx'] > 0 )
        {
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

        return false;
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

    function displayNew($regdate='')
    {

        return 0;
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


        $Info = $this->_pageList($totalcnt, $rowsPage, $curPage, '');
        
        $result = array();
        if ($Info['current_block'] > 2) {
            array_push($result, "<li><a href='" . $url . $link_url . "'>◀</a></li> ");
        }
        if ($Info['current_block'] > 1) {
            array_push($result, "<li><a href='" . $url . $link_url . "'>◁</a></li> ");
        }
        foreach ($Info['current'] as $w) {
            
            if ($curPage == $w) {
                //$this->curpage = intval($w);
                
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
        $this->blockFirst   = $fstPage;
        

        //현재 블럭의 마지막 페이지
        $endPage            = $fstPage + $block_limit -1;
        if($totalPage < $endPage) {
            $endPage        = $totalPage;
        }
        $this->blockLast    = $endPage;

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

}
