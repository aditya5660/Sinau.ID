<?php

defined('SINAUID') OR exit('No direct script access allowed');

class model_regencie {
    private $db;
    private $table_name = "regencies";

    public function __construct($dbconnect) {
        $this->db = $dbconnect;
    }

    public function get_results($where = array(), $page = 1, $show = 25, $order_val = 'ASC', $order_key = 'regencie_id') {
        $query  = "SELECT regencie_id, province_id, name";
        $query .= " FROM " . $this->table_name . " ";

	    if (count($where) > 0) {
            $queryWhere = $this->where($where);
            if($queryWhere) {
                $query .= $queryWhere;
            }
        }

        $query .= " ORDER BY $order_key $order_val ";
		if ($page != 'all') {
			$offset = ($page - 1) * $show;
            $query .= " LIMIT $show OFFSET $offset";
		}
        
        $this->db->go($query);
        if($this->db->numRows()>0){
            while($row = $this->db->fetchArray()) {
                $results[] = $row;
            }

            return $results;
        }

        return false;
    }

    private function where($where) {
        $arr = array();
        
		if (isset($where['regencie_id'])) {
			$arr['regencie_id'] = $where['regencie_id'];
		}
        
		if (isset($where['province_id'])) {
			$arr['province_id'] = $where['province_id'];
		}

        if (count($arr) > 0) {
            $query = " WHERE ";
            $i = 0;
            foreach($arr as $key => $value) {
                $query .= $key . " = '" . $this->db->q($value) . "'";
                if ($i < count($arr) - 1) {
                    $query.= " AND ";
                }
                $i++;
            }

            return $query;
        }

        return false;
    }
}