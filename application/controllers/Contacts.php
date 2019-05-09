<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 */
class Contacts extends My_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  function index(){
    $seg_total = $this->uri->total_segments();
    $config['per_page'] = $param['limit'] = 2;
    $param['offset'] = $seg_total <= 2 ?'0':$this->uri->segment($seg_total);
    $search = '';
    if($seg_total > 2){
      $search = $this->uri->segment($seg_total-1); //search segment
      $param['or_like'] = array(
        'name' => $search,
        'phone' => $search
      );
      $search = '/'.$search;
    }

    $param['table'] = 'contacts';
    $result = $this->All_Model->getRows($param , 'obj');
    // print_r($result);

    //pagination
    $config['base_url'] = base_url('view_contacts');
    // if($seg_total > 2){
    //   //has search value
    $temp_srch = !empty($search) ? '/'.$search : '';
      $config['base_url'] = base_url('view_contacts'.$temp_srch);
    // }
    $config['total_rows'] = $result['count_all_rows'];
    $config['uri_segment'] = $seg_total;
    // $config['uri_segment'] = 4;
    $this->pagination->initialize($config);
    $data['pagination'] = $this->pagination->create_links();
    $data['results'] = $result['results'];
    $data['search'] = $search;
    $this->template('pages/contacts', $data);
  }

  function delete(){
    $this->session->set_flashdata('msg', 'Successfully deleted!', 10);
    $param['table'] = 'contacts';
    $param['where'] = array('id' => $this->input->post('id'));
    $data['result'] = $this->All_Model->delete($param);
    echo json_encode($data);
  }

  function add_contact_page(){
    $this->template('pages/add_contact');
  }

  function add(){
    $data['restype'] = 'error';
    $data['resmsg'] = '';
    $config = array(
            array(
                    'field' => 'name',
                    'label' => 'Name',
                    'rules' => 'required'
            ),
            array(
                    'field' => 'phone',
                    'label' => 'Phone Number',
                    'rules' => 'required|is_unique[contacts.phone]',
                    'errors' => array(
                            'required' => 'You must provide a %s.',
                    ),
            ),
    );
    $this->form_validation->set_rules($config);
    if ($this->form_validation->run() == FALSE) {
      $data['resmsg'] = validation_errors();
    }
    else {
      $data['restype'] = 'success';
      $param['data'] = $this->input->post();
      $param['table'] = 'contacts';
      $data['result'] = $this->All_Model->insert($param);
    }
    echo json_encode($data);
  }

  function update_contact_page(){
    $param['table'] = 'contacts';
    $param['where'] = array('id' => $this->uri->segment(2));
    $result = $this->All_Model->getRows($param);
    $data['data'] = $result['results'];
    $this->template('pages/update_contact',$data);
  }

  function update(){
    $data['restype'] = 'error';
    $data['msg'] = '';
    $config = array(
      array(
        'field' => 'name',
        'label' => 'Name',
        'rules' => 'required'
      ),
      array(
        'field' => 'phone',
        'label' => 'Phone',
        'rules' => 'required'
      ),
    );
    $this->form_validation->set_rules($config);
    if($this->form_validation->run() == FALSE){
      $data['msg'] = validation_errors();
    }else{
      $this->session->set_flashdata('msg', 'Successfully updated!', 10);
      $data['restype'] = 'success';
      $param['data'] =  $this->input->post();
      $param['table'] = 'contacts';
      $param['where'] = array('id' => $this->input->post('id'));
      $data['result'] = $this->All_Model->update($param);
    }

    echo json_encode($data);

  }

  public function contacts_datatable(){
    $this->template('pages/contacts_datatable');
  }

  public function getContactsDatatable(){
		$res 					= array();
		$limit 				= $this->input->post('length');
		$offset 			= $this->input->post('start');
		$search 			= $this->input->post('search');
		$order 				= $this->input->post('order');
		$draw 				= $this->input->post('draw');
		$column_order = array(
												'name',
												'phone'
											);
		$select 			= 'name, phone';
		$join 		 = array();
		$where 		 = array();
		$group 		 = array();
		$list 		 = $this->All_Model->get_datatables('contacts',$column_order, $select, $where, $join, $limit, $offset ,$search, $order, $group);
		$output 	 = array(
				"draw" 				 		=> $draw,
				"recordsTotal" 		=> $list['count_all'],
				"recordsFiltered" => $list['count'],
				"data" 						=> $list['data']
		);
		echo json_encode($output);
	}

}


?>
