<?php defined('__NAJZMI_PUDINTEA__') OR exit('No direct script access allowed'); 

class Pegawai extends CI_Controller {
	function __construct(){
		$this->data = [];
		parent::__construct();
			$this->admin_bo->pdn_is_login();
			date_default_timezone_set ('Asia/Jakarta');
	}
	public function nameApp()		{ return 'Stok Obat'; }
	public function title()       	{ return 'Pegawai'; }
    public function author()      	{ return 'Pudin S I'; }
	public function MainModel()   	{ return 'PegawaiModel'; }
    public function contact()     	{ return 'najzmitea@gmail.com'; }
	public function ClassNama()   	{ return 'pegawai'; }
	
	public function index()
	{
		$this->data[$this->ClassNama()] = 'active';
		$this->data['pdn_title'] 		= $this->nameApp().' | '.$this->title();
		$this->data['pdn_info'] 		= $this->title();
		$this->data['pdn_url'] 			= $this->ClassNama();
		$this->template->pdn_load('template/admin','konten','konten_kode',$this->data);
	}
	
	function add()
	{
		$register_data['nama_depan'] 		= htmlspecialchars($this->input->post('nama_depan', true));
		$register_data['nama_belakang'] 	= htmlspecialchars($this->input->post('nama_belakang', true));
		$register_data['email'] 			= htmlspecialchars($this->input->post('email', true));
		$register_data['telpon'] 			= htmlspecialchars($this->input->post('telpon', true));
		$register_data['nip'] 				= 1;
		
		//var_dump($register_data);
		//die();
		$this->load->model($this->MainModel(), 'M_najzmi');
		$input = $this->M_najzmi->save($register_data);
		
		$message = array(
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash(),
		);
		$message['csrfToken'] = $this->security->get_csrf_hash();
		
		if ($input){
			//Berhasil
			$message['status'] = 'success';
		}else{
			$message['status'] = 'failed';
		}
		//$this->output->set_content_type('application/json')->set_output(json_encode($message));
		header('Content-type: application/json');
		echo json_encode($message);
	}

	function byid()
	{
		$_id = base64_decode($this->uri->segment(3));
		
		$this->load->model($this->MainModel(), 'M_najzmi');
		$edit = $this->M_najzmi->edit($_id);
		$datanya['id'] 				= base64_encode($edit->id);
		$datanya['nama_depan'] 		= $edit->nama_depan;
		$datanya['nama_belakang'] 	= $edit->nama_belakang;
		$datanya['email'] 			= $edit->email;
		$datanya['telpon'] 			= $edit->telpon;
		$this->output->set_content_type('application/json')->set_output(json_encode($datanya));
	}
	
	function update(){
		$_id								= base64_decode($this->input->post('id', true));
		$register_data['nama_depan'] 		= htmlspecialchars($this->input->post('nama_depan', true));
		$register_data['nama_belakang'] 	= htmlspecialchars($this->input->post('nama_belakang', true));
		$register_data['email'] 			= htmlspecialchars($this->input->post('email', true));
		$register_data['telpon'] 			= htmlspecialchars($this->input->post('telpon', true));
		
		$this->load->model($this->MainModel(), 'M_najzmi');
		$input = $this->M_najzmi->update($register_data,$_id);
		
		$message['csrfToken'] = $this->security->get_csrf_hash();
		
		if ($input){
			//Berhasil
			$message['status'] = 'success';
		}else{
			$message['status'] = 'faild';
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($message));
	}
	
	function hapus()
	{
		//Hanya Untuk Administrator
		$_id = base64_decode($this->uri->segment(3));
		
		$this->load->model($this->MainModel(), 'M_najzmi');
		
		$input = $this->M_najzmi->delete($_id);
		
		if ($input){
			//Berhasil
			$message['status'] = 'success';
		}else{
			$message['status'] = 'faild';
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($message));
	}
	
	function data_json()
	{
		//Hanya Untuk Administrator
		if($this->input->method(TRUE)=='POST'): // Hanya lewat metode post saja yang di izinkan melihat dan mengambil data
		
			$csrf_name = $this->security->get_csrf_token_name();
			$csrf_hash = $this->security->get_csrf_hash();
				
			$tabel = 'pegawai';
			$column_order = array('', 'nama_depan','nama_belakang','email','telpon');
			$column_search = array('nama_depan','nama_belakang','email','telpon');
			$order = array('id' => 'DESC');
			//$where = array('admin_level' => 'Operator');
				
				$this->load->model('DatatablesModel' ,'M_najzmi');
				$list = $this->M_najzmi->get_datatables($tabel,$column_order,$column_search,$order);
				$data = array();
				$no = isset($_POST['start']) 	? $_POST['start'] 	: 1;
				
				foreach ($list as $pDn) {
					$no++;
					$row = array();
					$row[] = $no;
					$row[] = $pDn->nama_depan;
					$row[] = $pDn->nama_belakang;
					$row[] = $pDn->email;
					$row[] = $pDn->telpon;
					$row[] = '<div class="btn-group">
								  <a href="#"  class="btn btn-success btn-sm" onclick="byid('."'".base64_encode($pDn->id)."','edit'".')">Edit</a>
								  <a href="#"  class="btn btn-danger btn-sm" onclick="byid('."'".base64_encode($pDn->id)."','hapus'".')">Hapus</a>
								</div>';
					
					$data[] = $row;
				}
				
				
				$output = array(
								"draw" => isset($_POST['draw']) 	? $_POST['draw'] 	: 'null',
								"recordsTotal" => $this->M_najzmi->count_all($tabel,$column_order,$column_search,$order),
								"recordsFiltered" => $this->M_najzmi->count_filtered($tabel,$column_order,$column_search,$order),
								"data" => $data,
						);
				$output[$csrf_name] = $csrf_hash;
				//output to json format
				header('Content-type: application/json');
				echo json_encode($output);
			// End Json
		endif;
	}
}
