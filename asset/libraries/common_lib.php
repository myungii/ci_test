<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_lib {
	private $ci;

	function __construct() {
		$this->ci =& get_instance();
	}


	/**
	 * [set_where description]
	 * @param [type] $where [description]
	 */
	function set_where($where, $DB=NULL, $escape='TRUE') {

		if(is_array($where)) {
			foreach ($where as $field=>$value) {
				if(empty($field)) continue;
				if(is_array($value)) {

					if(isset($value['type'])) {
						switch($value['type']) {
							case 'escape':
							    if(is_null($DB)){
                                    $this->ci->db->where($field, $value['value'], FALSE);
                                } else {
                                    $DB->where($field, $value['value'], FALSE);
                                }
							break;
							case 'or':
                                if(is_null($DB)){
                                    $this->ci->db->or_where($field, $value['value']);
                                } else {
                                    $DB->or_where($field, $value['value']);
                                }
							break;
						}
					}
					else {
                        if(is_null($DB)){
                            $this->ci->db->where_in($field, $value);
                        } else {
                            $DB->where_in($field, $value);
                        }
					}
				}
				else {
					if(is_null($value)) {
                        if(is_null($DB)){
                            $this->ci->db->where($field, NULL, FALSE);
                        } else {
                            $DB->where($field, NULL, FALSE);
                        }
					}
					else {
                        if(is_null($DB)){
                            $this->ci->db->where($field, $value , $escape);
                        } else {
                            $DB->where($field, $value , $escape);
                        }
					}
				} 
			}
		}
	}

    function total_adjehyu_logo_total() {
        if (in_array($_SERVER['HTTP_HOST'], array('direct-sks.co.kr', 'direct-sks.co.test'))){
            $this->ci->db->select('COUNT(idx) as total');
            $this->ci->db->where('substr(regdate,1,10)', date("Y-m-d"));
            $query = $this->ci->db->get("iiop_adjehyu_cokr");
            $row = $query->row();
            $this->total = $row->total;
            return $row->total;
        } else {
            $this->ci->db->select('COUNT(idx) as total');
            $this->ci->db->where('substr(regdate,1,10)', date("Y-m-d"));
            $query = $this->ci->db->get("iiop_adjehyu");
            $row = $query->row();
            $this->total = $row->total;
            return $row->total;
        }
    }

    function total_adjehyu_expo_logo_total(){
        $this->ci->db->select('COUNT(idx) as total');
        $this->ci->db->where('substr(regdate,1,10)', date("Y-m-d"));
        $query = $this->ci->db->get("iiop_expo");
        $row = $query->row();
        $this->total = $row->total;
        return $row->total;
    }

    function total_adjehyu_logo_total2(){
        $this->ci->db->select('COUNT(idx) as total');
        $this->ci->db->where('substr(regdate,1,10)', date("Y-m-d"));
        $query = $this->ci->db->get("iiop_adjehyu_cokr2");
        $row = $query->row();
        $this->total = $row->total;
        return $row->total;
    }

}
?>