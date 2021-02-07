<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HasilUjian extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->ion_auth->logged_in()){
			redirect('auth');
		}
		
		$this->load->library(['datatables']);// Load Library Ignited-Datatables
		$this->load->model('Master_model', 'master');
		$this->load->model('Ujian_model', 'ujian');
		
		$this->user = $this->ion_auth->user()->row();
	}

	public function output_json($data, $encode = true)
	{
		if($encode) $data = json_encode($data);
		$this->output->set_content_type('application/json')->set_output($data);
	}

	public function data()
	{
		$nip_dosen = null;
		
		if( $this->ion_auth->in_group('dosen') ) {
			$nip_dosen = $this->user->username;
		}

		$this->output_json($this->ujian->getHasilUjian($nip_dosen), false);
	}

	public function NilaiMhs($id)
	{
		$this->output_json($this->ujian->HslUjianById($id, true), false);
	}

	public function index()
	{
		$data = [
			'user' => $this->user,
			'judul'	=> 'Ujian',
			'subjudul'=> 'Hasil Ujian',
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('ujian/hasil');
		$this->load->view('_templates/dashboard/_footer.php');
	}
	
	public function detail($id)
	{
		$ujian = $this->ujian->getUjianById($id);
		$nilai = $this->ujian->bandingNilai($id);

		$data = [
			'user' => $this->user,
			'judul'	=> 'Ujian',
			'subjudul'=> 'Detail Hasil Ujian',
			'ujian'	=> $ujian,
			'nilai'	=> $nilai
		];

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('ujian/detail_hasil');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function cetak($id)
	{
		$this->load->library('Pdf');

		$mhs 	= $this->ujian->getIdMahasiswa($this->user->username);
		$hasil 	= $this->ujian->HslUjian($id, $mhs->id_mahasiswa)->row();
		$ujian 	= $this->ujian->getUjianById($id);
		
		$data = [
			'ujian' => $ujian,
			'hasil' => $hasil,
			'mhs'	=> $mhs
		];
		
		$this->load->view('ujian/cetak', $data);
	}

	public function cetak_detail($id)
	{
		$this->load->library('Pdf');

		$ujian = $this->ujian->getUjianById($id);
		$nilai = $this->ujian->bandingNilai($id);
		$hasil = $this->ujian->HslUjianById($id)->result();

		$data = [
			'ujian'	=> $ujian,
			'nilai'	=> $nilai,
			'hasil'	=> $hasil
		];

		$this->load->view('ujian/cetak_detail', $data);
	}
	public function KirimMail()
    {
						
		if (isset($_POST['submit_email'])) {
            $email = $this->input->post('email');
			$pesan = $this->input->post('pesan');
			$path = 'uploads/berkas/' . $_FILES["resume"]["name"];
			move_uploaded_file($_FILES["resume"]["tmp_name"], $path);
			if (!empty($email)) {

				//configuration to email & process
				$config = Array(
					'protocol' => 'smtp',
					'smtp_host'=> 'ssl://smtp.googlemail.com',
					'smtp_port'=> 465,
					'smtp_user' => 'belltinkerimut@gmail.com',
					'smtp_pass' => 'bekasibarat123',
					'mailtype' => 'html',
					'charset' => 'iso-8859-1'
				);


            $this->load->library('email');
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->from('belltinkerimut@gmail.com', 'Amay');
			$this->email->to($email);
			$this->email->subject('Laporan Nilai');
			
			$this->email->message($pesan);
			$this->email->attach($path);
			
					 	                        
			return $this->email->send();
            
            //configuration to email & process
           
            if ($email->send()){
			   $pesan = '<div class="alert alert-success">
			   	Email, Berhasil dikirim..</div>';
                
            }else{
              $pesan = '<div class="alert alert-danger">Terjadi Sebuah Kesalahan</div>';
            }
            return $this->email->send();
				
	
			};
			
		};
	}
}
