<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class model extends CI_Model{
    function __construct(){
        parent::__construct();
    }


//--------------------------------------------------    Login      ------------------------------------------------//

    
    public function login($nip, $password) 
    {
        $this->db->select('*');
        $this->db->from('tbuser');
        $this->db->where('nip', $nip);
        $this->db->where('password', MD5($password));       //merubah password menjadi bentuk enkripsi dengan md5
        $this->db->limit(1);
 
        //get query and processing
        $query = $this->db->get();
        if($query->num_rows() == 1) {
            return $query->result(); //if data is true
        } else {
            return false; //if data is wrong
        }
    }
    

    //--------------------------------------------------  Manajemen Pengguna -----------------------------------------------//
    public function user()
    {
        $this->db->order_by('tbuser.nama', 'ASC');
        $data = $this->db->get('tbuser'); 
        return $data->result_array();
    }

    public function admin()
    {
        $query = $this->db->query('SELECT * FROM tbuser WHERE level="1"');
        return $query->result_array();
    }

    public function pns()
    {
        $query = $this->db->query('SELECT * FROM tbuser WHERE level="2"');
        return $query->result_array();
    }


    public function datapns()
    {
        $query = $this->db->query('SELECT * FROM tbuser WHERE level="2"');
        return $query->result_array();
    }


    public function hadirpns()
    {
        $query = $this->db->query('SELECT * FROM `tbcoba`');
        return $query->result_array();
    }

    public function hadir()
    {
        $query = $this->db->query('SELECT * FROM `tbcoba`');
        return $query->result_array();
    }



    public function tambah_user($data)
    {
        $this->db->insert('tbuser', $data); 
        return TRUE;
    }

    public function tambah_hadir($data)
    {
        $this->db->insert('tbcoba', $data); 
        return TRUE;
    }

    public function NIP($nip)   
    {
        $query = $this->db->query('SELECT * FROM tbuser WHERE nip = "'.$nip.'"');
        return $query->result_array();
    }


    public function pgw($nip)
    {
        $this->db->select('*')->from('tbuser')->where($data=array('tbuser.nip'=>$nip));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function pgwhadir($nip){
        $this->db->select('*')->from('tbcoba')->where($data=array('tbcoba.nip'=>$nip));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function tes($nip)
    {
        return $this->db->get_where('tbuser',$data=array('nip'=>$nip))->result();
    }

   









}