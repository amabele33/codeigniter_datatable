<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 */
class My_Controller extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  function template($view, $data=[]){
    $this->load->view('includes/head',$data);
    $this->load->view($view,$data);
    $this->load->view('includes/footer',$data);
  }


}
