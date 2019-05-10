<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

     public function __construct(){
          parent::__construct();
     }

     public function getRows($table,$select = "*",$where = array(),$join = array(),$group = '',$limit = array(),$order = '',$result = 'array'){
          $this->db->select($select);

          if(!empty($where)){
            $this->db->where($where);
          }

          if(!empty($join)){
               foreach($join as $key => $value){
                    if(strpos($value,':') !== false){
                         $_join = explode(":",$value);
                         $this->db->join($key,$_join[0],$_join[1]);
                    } else {
                         $this->db->join($key,$value);
                    }
               }
          }

          if(!empty($group)){
               $this->db->group_by($group);
          }

          if(!empty($limit)){
               $this->db->limit($limit[0],$limit[1]);
          }

          if(!empty($order)){
               $this->db->order_by($order);
          }

          $query = $this->db->get($table);

          switch ($result) {
               case 'array':
               return $query->result_array();
                    break;
               case 'obj':
               return $query->result();
                    break;
               case 'row':
               return $query->row();
                    break;
               case 'count':
               return $query->num_rows();
                    break;
               default:
               return $query->result_array();
                    break;
          }
     }

     public function get_datatables($table, $column_order, $select = "*", $where = "", $join = array(), $limit, $offset, $search, $order,$group = '',$or_like = array()){
    	  	$this->db->from($table);
    	  	$columns = $this->db->list_fields($table);
    	  	if($select){
    	  		$this->db->select($select);
    	  	}
    	  	if($where){
    	  		$this->db->where($where);
    	  	}



    	  	if($join){
    	  		foreach ($join as $key => $value) {
    				$this->db->join($key,$value);
    	  		}
    	  	}
    	  	if($search){
    	  		$this->db->group_start();
    	  		foreach ($column_order as $item)
    	  		{
    	  			$this->db->or_like($item, $search['value']);
    	  		}
    	  		$this->db->group_end();
    	  	}

          if(!empty($or_like)){
            $this->db->group_start();
            foreach ($or_like as $key => $value){
              $this->db->or_like($key, $value);
            }
            $this->db->group_end();
          }

    	  	if($group)
    	  		$this->db->group_by($group);

    	  	if($order)
    	  		$this->db->order_by($column_order[$order['0']['column']], $order['0']['dir']);

    	    	$temp = clone $this->db;
    	    	$data['count'] = $temp->count_all_results();

    	  	if($limit != -1)
    	  		$this->db->limit($limit, $offset);

    	  	$query = $this->db->get();
    	  	$data['data'] = $query->result();
          $data['last_query'] = $this->db->last_query();
    	  	$this->db->from($table);
    	  	$data['count_all'] = $this->db->count_all_results();
    	  	return $data;
    	}

     public function insert($table,$data){
          $this->db->insert($table,$data);
          return $this->db->insert_id();
     }

     public function update($table, $data, $where){
       $this->db->where($where);
       return $this->db->update($table, $data);
     }

     public function delete($table, $where){
       return $this->db->delete($table, $where);
     }
}
