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
        if($this->session->userdata('login') and $this->session->userdata('level')== '2')
        {
            $data['isi']        = 'user/hadir';
            $data['data']       = $this->model->pgwhadir($this->session->userdata('username'));
            $this->load->view('dashboardP',$data);
         }
         else
         {
            $error['error'] = 'Silahkan masuk dulu';
            $this->load->view('login',$error);
        }
    }



    //-------------------------------------------- Perubahan Data admin -------------------------------------------//
    public function tambah()
    {
            $data = array(
            'id'               => $this->input->post('id'),
            'nip'              => $this->input->post('nip'),
            'nama'             => $this->input->post('nama'),
            'tglmulai'         => $this->input->post('tglmulai'),
            'tglakhir'         => $this->input->post('tglakhir'),
            'jenis'            => $this->input->post('jenis'),
            'subjenis'         => $this->input->post('subjenis'),
            'surat'            => $this->input->post('surat'),
            'ket'              => $this->input->post('ket'),
            'tgl'            => $this->input->post('tgl'),
            );
            $this->model->tambah_hadir($data);
        
            $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert">Data Berhasil Disimpan. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('admin/c_hadir/view_hadir');
    }

    public function hapus($id)
    {
            $res = $this->db->delete('tbcoba', array('id' => $id));
            if($res>=1)
            {
                $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert"> Data Berhasil dihapus <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('user/c_hadir/view_hadir');
            }
            else
            {
                $this->session->set_flashdata('notif','<div class="alert alert-danger" role="alert"> Data gagal dihapus <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('user/c_hadir/view_hadir');
            }
        
    }
     public function ubah()
     {
            $data = array(
                'id'            => $this->input->post('id1'),
                'nip'           => $this->input->post('nip1'),
                'nama'          => $this->input->post('nama1'),
                'tglmulai'      => $this->input->post('tglmulai1'),
                'tglakhir'      => $this->input->post('tglakhir1'),
                'jenis'         => $this->input->post('jenis1'),
                'subjenis'      => $this->input->post('subjenis1'),
                'surat'         => $this->input->post('surat1'),
                'kegiatan'      => $this->input->post('kegiatan1'),
                'ket'           => $this->input->post('ket1'),
                'tgl'           => $this->input->post('tgl1'),
            );
            $where = array('id'=>$this->input->post('id1'));
            $res = $this->db->update('tbcoba', $data, $where);
            if($res >= 1){
                $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert"> Data Berhasil diubah <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('user/c_hadir/view_hadir');
            }
            else
            {
                $this->session->set_flashdata('notif','<div class="alert alert-danger" role="alert"> Data Gagal diubah <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('user/c_hadir/view_hadir');
            }
    }


    public function get_kodeket()
    {
          $result=$this->db->where('jenis',$_POST['id'])
                            ->from('tbcoba')
                            ->join('ket', 'tbcoba.jenis = ket.ket', 'right')
                            ->get()
                            ->result();
        $data=array();
        foreach($result as $r)
        {
            $data['value']=$r->ket;
            $data['label']=$r->subket;
            $json[]=$data;
        }
        echo json_encode($json);
    }


    public function getAjax()
    {
        $nip = $_POST['nip'];
        $data = $this->model->tes($nip);
        foreach($data as $data)
        { 
            $data1['namapgw']= $data->nama;
        }
        echo json_encode($data1);
    }

} 

