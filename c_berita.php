<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class c_berita extends CI_Controller 
    { 
    	function __construct(){
        	parent::__construct();
        	$this->load->model('model');
    }


	//-------------------------------------------- Manajemen Berita -------------------------------------------//
	public function view_berita()
	{
        if($this->session->userdata('login') and $this->session->userdata('level')== '1')
        {
            $data['isi']        = 'admin/berita';
            $data['data']       = $this->model->berita();
            $this->load->view('dashboard',$data); 
         }
         else
         {
            $error['error'] = 'Silahkan masuk dulu';
            $this->load->view('login',$error);
        }
    }

    public function berita()
    {
        $data['isi']  = 'admin/tambahberita';
        $this->load->view('dashboard', $data); 
    }

    public function tambahberita()
    {
        $config=array(
                'upload_path'   =>'./uploads/berita/',
                'allowed_types' =>'jpg|jpeg|png|gif',
                'max_size'      =>'2000',
                'max_width'     =>'1800',
                'max_height'    =>'1800',
                'file_name'     => url_title($this->input->post('userfile')) 
            );
        $this->load->library('upload',$config);
        if(! $this->upload->do_upload())
        {
            $error = $this->upload->display_errors(); 
        }
        else
        {
            //$tanggal = date('Y-m-d');
            $data=array(
                'id'        => $this->input->post('id'),
                'isi'       => $this->input->post('berita') , 
                'judul'     => $this->input->post('judul') , 
                'status'    => $this->input->post('status') , 
                'tanggal'   => $this->input->post('tanggal'),
                'foto'      => 'uploads/berita/'.$this->upload->data('file_name') 
                );
            $this->model->tambah_berita($data);
            $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert">Berita Berhasil Disimpan. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('admin/c_berita/view_berita');
        }
	}

    public function ubah($id)
    {
        $data['isi']        = 'admin/ubahberita';
        $this->db->where('id',$id);
        $data['daftar_berita'] = $this->model->berita();
        $this->load->view('dashboard',$data);
    }

    public function update()
    {
        $config=array(
                'upload_path'   =>'./uploads/berita/',
                'allowed_types' =>'jpg|jpeg|png|gif',
                'max_size'      =>'2000',
                'max_width'     =>'1800',
                'max_height'    =>'1800',
                'file_name'     => url_title($this->input->post('userfile')) 
            );
        $this->load->library('upload',$config);
        if(! $this->upload->do_upload())
        {
            $error = $this->upload->display_errors();
        }
        else
        {
        $tanggal = date('Y-m-d');
        $data    = array(
            'judul'     =>$this->input->post('judul'),
            'isi'       =>$this->input->post('berita'),
            'foto'      =>'uploads/berita/'.$this->upload->data('file_name'),
            'tanggal'   =>$this->input->post('tanggal'),
            'status'    =>$this->input->post('status'),
        );

        $kondisi['id'] = $this->input->post('id');
        $this->model->updateBerita($data,$kondisi);
        
                $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert"> Berita Berhasil diubah <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/c_berita/view_berita');
        }
    }

    public function hapus($id)
    {
        $res = $this->db->delete('tb_berita', array('id' => $id));
            if($res>=1)
            {
                $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert"> Data Berhasil dihapus <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/c_berita/view_berita');
            }
            else
            {
                $this->session->set_flashdata('notif','<div class="alert alert-danger" role="alert"> Data gagal dihapus <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/c_berita/view_berita');
            }   
    }
}