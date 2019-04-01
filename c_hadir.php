<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class c_hadir extends CI_Controller 
    {
    	function __construct()
        {
        	parent::__construct();
        	$this->load->model('model');
        }


	//-------------------------------------------- Manajemen Data admin -------------------------------------------//
	public function view_hadir()
	{
        if($this->session->userdata('login') and $this->session->userdata('level')== '1')
        {
            $data['isi']        = 'admin/hadir';
            $data['data']       = $this->model->hadirpns();
            $this->load->view('dashboard',$data);
         }
         else
         {
            $error['error'] = 'Silahkan masuk dulu';
            $this->load->view('login',$error);
        }
    }



    //-------------------------------------------- Perubahan Data admin -------------------------------------------//

	
} 