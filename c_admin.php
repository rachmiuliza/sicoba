<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class c_admin extends CI_Controller 
    {
    	function __construct()
        {
        	parent::__construct();
        	$this->load->model('model');
        }


	//-------------------------------------------- Manajemen Data admin -------------------------------------------//
	public function view_admin()
	{
        if($this->session->userdata('login') and $this->session->userdata('level')== '1')
        {
            $data['isi']        = 'admin/admin';
            $data['data']       = $this->model->admin();
            $this->load->view('dashboard',$data);
         }
         else
         {
            $error['error'] = 'Silahkan masuk dulu';
            $this->load->view('login',$error);
        }
    }



    //-------------------------------------------- Perubahan Data admin -------------------------------------------//
    public function ubah()
    {
        $data = array(
                'nip'       => $this->input->post('nip1'),
                'nama'      => $this->input->post('nama1'),
                'password'  => md5($this->input->post('password1')),
                'passwordD' =>($this->input->post('password1')),
        );
        
        $where = array('nip'=>$this->input->post('nip1'));
        $res = $this->db->update('user', $data, $where);
        if($res >= 1)
        {
            $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert"> Data Berhasil diubah <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/c_admin/view_admin');
        }
        else
        {
                $this->session->set_flashdata('notif','<div class="alert alert-danger" role="alert"> Data Gagal diubah <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/c_admin/view_admin');
        }
    }
	
} 