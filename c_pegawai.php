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
        if($this->session->userdata('login') and $this->session->userdata('level')== '1')
        {
            $data['isi']        = 'admin/pegawai';
            $data['data']       = $this->model->datapns();
            $this->load->view('dashboard',$data);
         }
         else
         {
            $error['error'] = 'Silahkan masuk dulu';
            $this->load->view('login',$error);
        }
    }



    //-------------------------------------------- Perubahan Data admin -------------------------------------------//

	//-------------------------------------------- Penambahan Data Dosen -------------------------------------------//
    public function tambah()
    {
        $NIP     = $this->input->post('nip');
        $filter2 = $this->model->NIP($NIP);
        if(count($filter2) >=1 )
        {
            $this->session->set_flashdata('notif','<div class="alert alert-danger" role="alert"> NIP sudah ada. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('admin/c_pegawai/view_pegawai');
        }
        else
        {
                $data = array(
                'nip'       => $this->input->post('nip'),
                'nama'      => $this->input->post('nama'),
                'level'     => $this->input->post('level'),
                'jenkel'    => $this->input->post('jenkel'),
                'password'  => md5($this->input->post('password')),
            );

            $this->model->tambah_user($data);
            $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert">Data Berhasil Disimpan. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('admin/c_pegawai/view_pegawai');
        }
    }




    //-------------------------------------------- Penghapusan Data Dosen -------------------------------------------//
    public function hapus($id)
    {
        $res = $this->db->delete('tbuser', array('nip' => $id));
        if($res>=1)
        {
            $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert"> Data Berhasil dihapus <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/c_pegawai/view_pegawai');
        }
        else
        {
            $this->session->set_flashdata('notif','<div class="alert alert-danger" role="alert"> Data gagal dihapus <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/c_pegawai/view_pegawai');
        }
         
    }

} 