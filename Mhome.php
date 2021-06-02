<?php if (!defined('BASEPATH')) exit ('No direct script acces allowed');

class Mhome extends CI_Model{


        public function get_content_berita($limit, $start)
    {
        $query = $this->db->get_where('tb_berita', ['is_published' => 1] , $limit, $start);
        return $query;
    }
        public function get_content_program($limit, $start)
    {
       
       // $query = $this->('tb_program', ['is_published' => 1] , $limit, $start);
       //  return $query;
     $query = $this->db->query("SELECT b.id_program, a.id, status_code, nama_program, waktu_penggalangan, jumlah_penggalangan, a.gambar, a.date_created, detail, kategori, wilayah, penulis, is_published ,COUNT(b.id_program) AS total_progres,COUNT(b.order_id) AS donatur,(SUM(gross_amount)) AS total FROM tb_program a
      LEFT JOIN transaksi b ON b.id_program = a.id
       WHERE a.is_published=1
      GROUP BY a.id",$limit, $start);
       return $query;
    
    }
    public function getbyid_program($id)
    {
       $query = $this->db->query("SELECT b.id_program, a.id, b.nama, nama_program, detail,a.update,a.gambar,a.jumlah_penggalangan, waktu_penggalangan, a.date_created, kategori, wilayah, penulis, is_published,COUNT(b.id_program) AS total_progres,COUNT(b.order_id) AS donatur,(SUM(gross_amount)) AS total FROM tb_program a 
      LEFT JOIN transaksi b ON b.id_program = a.id
       WHERE b.id_program=$id AND is_published=1 AND status_code=200 ");
      return $query;
    }
        public function get_content_vidio($limit, $start)
    {
        $query = $this->db->get_where('tb_vidio', ['is_published' => 1], $limit, $start);
        return $query;
    }
        public function get_sum()
    {
       $this->db->select_sum('gross_amount');
       $this->db->from('transaksi');
       $this->db->where('id_program');
       $query = $this->db->get();
       return $query->result();
    }
    public function program_wakaf()
    {
       $this->db->select('*');
       $this->db->select_sum('gross_amount');
       $this->db->from('transaksi');
       $this->db->where('transaksi.id_program = tb_program.id');
       $this->db->from('tb_program');
        $this->db->where('is_published=1');
       $query =$this->db->get();
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }

    }
 
 	
}