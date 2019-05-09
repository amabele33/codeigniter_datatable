<?php
/**
 *
 */
class All_Model extends CI_Model
{

  function getRows($param, $return = 'array')
  {

    $this->db->select('*');
    $this->db->from('contacts');

    if(!empty($param['or_like'])){
      $this->db->group_start();
      foreach ($param['or_like'] as $key => $value) {
        $this->db->or_like($key, $value);
      }
      $this->db->group_end();
    }

    if(!empty($param['where'])){
      $this->db->group_start();
      foreach ($param['where'] as $key => $value) {
        $this->db->where($key, $value);
      }
      $this->db->group_end();
    }

    $temp = clone $this->db;

    if(!empty($param['limit'])){
      $this->db->limit($param['limit'], $param['offset']);
    }

    switch ($return) {
      case 'array':
        $data['results'] = $this->db->get()->result_array();
        break;
      default:
        $data['results'] = $this->db->get()->result();
        break;
    }
    $data['last_query'] = $this->db->last_query();
    $data['count'] = $this->db->count_all_results();
    $data['count_all_rows'] = $temp->count_all_results();

    return $data;

  }

  function delete($param){
    return $this->db->delete($param['table'], $param['where']);
  }

  function insert($param){
    return $this->db->insert($param['table'],$param['data']);
  }

  function update($param){
    return $this->db->update($param['table'],$param['data'],$param['where']);
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

}


 ?>
