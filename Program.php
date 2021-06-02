<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Program extends CI_Controller {
	function __construct(){
		parent::__construct();
        //load libary pagination
		$this->load->library('pagination');

	}

	public function index($start = NULL)
	{
		 $data['judul']= "Program Muyassar";
		  //konfigurasi pagination
		   $limit = 3;
		 $config['base_url'] = base_url('program/index'); //site url
		 $config['total_rows'] = $this->db->count_all('tb_program','transaksi'); //total row
		 $config['per_page'] = $limit;  //show record per halaman
		 $config["uri_segment"] = 3;  // uri parameter
		 $choice = $config["total_rows"] / $config["per_page"];
		 $config["num_links"] = floor($choice);
  
		 // Membuat Style pagination untuk BootStrap v4
		 $config['first_link']       = 'First';
		 $config['last_link']        = 'Last';
		 $config['next_link']        = '<i class="text-dark fas fa-angle-double-right"></i>';
		 $config['prev_link']        = '<i class="text-dark fas fa-angle-double-left"></i>';
		 $config['full_tag_open']    = '<div class="pagging text-center"><ul class="pagination justify-content-center">';
		 $config['full_tag_close']   = '</ul></div>';
		 $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		 $config['num_tag_close']    = '</span></li>';
		 $config['cur_tag_open']     = '<li class="page-item "><span class="page-link active">';
		 $config['cur_tag_close']    = '<span class=""></span></span></li>';
		 $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		 $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		 $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		 $config['prev_tagl_close']  = '</span>Next</li>';
		 $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		 $config['first_tagl_close'] = '</span></li>';
		 $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		 $config['last_tagl_close']  = '</span></li>';
  		 $data['info'] = $this->db->query("SELECT * FROM m_info")->result();
		 $this->pagination->initialize($config);
		 $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		 $data['perpage'] = $this->Mhome->get_content_program($config["per_page"], $data['page']);    
		 $data['pagination'] = $this->pagination->create_links();     
		 $this->template->public_render('home/migration/program',$data);
	
	}
	public function detail($id)
	{
		$data['info'] = $this->db->query("SELECT * FROM m_info")->result();
		$data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();
		$data['a'] =$this->Mhome->getbyid_program($id)->result();
		$data['donatur'] =$this->db->get_where('transaksi', ['id_program' => $id])->result();
		$data['berita'] = $this->db->query("SELECT * FROM tb_berita WHERE is_published=1 ORDER BY date_created limit 3")->result();
		$data['news'] = $this->db->query("SELECT * FROM tb_berita WHERE is_published=1 ORDER BY date_created desc limit 6")->result();
		$data['judul'] = "Detail Program";
		 $this->template->public_render('home/migration/detail_program',$data);
	}
}
