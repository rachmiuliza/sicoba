<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class c_pegawai extends CI_Controller 
    {
    	function __construct()
        {
        	parent::__construct();
        	$this->load->model('model');
        }


	//-------------------------------------------- Manajemen Data admin -------------------------------------------//
	public function view_pegawai()
    {
        if($this->session->userdata('login') and $this->session->userdata('level')== '2'){
            $data['isi']        = 'user/pegawai';
            $data['data']       = $this->model->pgw($this->session->userdata('nip'));
            
            $this->load->view('dashboardP',$data);
            }else{
            $error['error'] = 'Silahkan masuk dulu'; 
            $this->load->view('login',$error);
        }
    }




} 