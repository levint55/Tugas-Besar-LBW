<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		// $this->load->view('alert');
		$this->load->database();

		$query = $this->db->query('SELECT id,name,full_name,follower,following FROM organisation');
		$rows = $query->result_array();
		$this->load->view('beranda',[
			"rows" => $rows
		]);

		// Contoh penerapan method get
		// $org = $this->get_org_from_db('ifunpar');
		// $repos = $this->get_repo_from_db($org[0]['id']);
		// $languages = $this->get_repo_lang_from_db($repos[0]['id']);
		// $contributors = $this->get_user_from_db($repos[0]['id']);

		//fungsi ini untuk menambahkan organisasi ifunpar ke dalam list (tabel) organisasi
		// $this->add_to_db('ifunpar');
	}

	public function getResponseOrg($org)
	{
		$url = "https://api.github.com/orgs/" . $org;
		return $this->getResponse($url);
	}

	public function getOrgRepos($org)
	{
		$url = "https://api.github.com/orgs/" . $org . "/repos";
		return $this->getResponse($url);
	}

	public function getOrgProjects($org)
	{
		$url = "https://api.github.com/orgs/" . $org . "/projects";
		return $this->getResponse($url);
	}

	public function getOrgMembers($org)
	{
		$url = "https://api.github.com/orgs/" . $org . "/members";
		return $this->getResponse($url);
	}

	//function khusus untuk menghandle request via javascript
	public function getOrgFromDB($org){
		echo $this->get_org_from_db($org);
	}

	//function khusus untuk menghandle request via javascript
	public function getRepoFromDB($fk_org){
		$this->load->database();
		echo json_encode($this->get_repo_from_db($fk_org));
	}

	//function khusus untuk menghandle request via javascript
	public function getUserFromDB($fk_repo){
		$this->load->database();
		echo json_encode($this->get_user_from_db($fk_repo));
	}

	//function khusus untuk menghandle request via javascript
	public function getRepoLangFromDB($fk_repo){
		$this->load->database();
		echo json_encode($this->get_repo_lang_from_db($fk_repo));
	}

	//REFS: https://developer.github.com/v3/projects/#list-repository-projects
	//Di beranda kan ada tulisan repo, projek, sama organisasi
	//Ternyata, url mereka bertiga terpisah (nggak bisa ngambil dari satu url)
	//jadinya struktur function ini gw ubah :)
	public function getResponse($url)
	{
		// header('Content-type: application/json');
		//header('Content-type: text/plain');

		$ch = curl_init();

		curl_setopt_array($ch, [
			CURLOPT_URL => $url,
			CURLOPT_HTTPHEADER => [
				"User-Agent: IrvanHardyanto98",
				"Accept: application/vnd.github.inertia-preview+json"
			],
			CURLOPT_RETURNTRANSFER => true,
		]);

		$response_body = curl_exec($ch);
		curl_close($ch);

		$jsonObj = json_decode($response_body, true);
		//var_dump($jsonObj);
		// $this->load->view($view, [
		// 	"datas"=> $jsonObj
		// ]);
		return $jsonObj;
	}

	//ini buat nampilin view, pake data tertentu
	//show a specific view with some kind of data, represented as php traditional array
	//use empty array if no data need to be shown
	public function showView($viewName, $data)
	{
		$this->load->view($viewName, $data);
	}

	public function test()
	{
		$this->load->helper('url');
		$this->load->view("beranda", []);
	}

	public function form_submit()
	{
		header("Location: /");
		$org_name = $this->input->post('org_name');
		echo $org_name;
		$this->load->database();
		$this->add_to_db($org_name);
	}

	public function add_to_db($org)
	{
		$res = $this->db->get_where('organisation', array('name' => $org))->result_array();
		if (count($res) == 0) {
			// Add Organisation
			$data = $this->getResponseOrg($org);
			if (array_key_exists('message', $data)){
				$this->session->set_flashdata('error', 'Organisasi tidak ditemukan.');
			} else {
				$this->add_org_to_db($data);
				$last_inserted_id = $this->db->insert_id();
				
				// Add Repository
				$this->add_repo_to_db($org, $last_inserted_id);
				$this->session->set_flashdata('success', 'Data berhasil dimasukkan');
			}

		} else {
			$this->session->set_flashdata('warning', 'Data sudah ada.');
		}
	}

	public function add_org_to_db($data)
	{
		$new_record = array(
			'name' => $data['login'],
			'full_name' => $data['name'],
			'follower' => $data['followers'],
			'following' => $data['following'],
		);
		$this->db->insert('organisation', $new_record);
	}

	public function add_repo_to_db($org, $org_id)
	{
		// Add Repository
		$datas = $this->getOrgRepos($org);
		foreach ($datas as $data) {
			$new_record = array(
				'name' => $data['name'],
				'full_name' => $data['full_name'],
				'contributors_url' => $data['contributors_url'],
				'languages_url' => $data['languages_url'],
				'size' => $data['size'],
				'fk_org' => $org_id,
				'description' => $data['description'],
			);
			$this->db->insert('repository', $new_record);
			$last_inserted_id = $this->db->insert_id();
			// Add User in Repository
			$this->add_user_to_db($data['contributors_url'], $last_inserted_id);
			$this->add_language_to_db($data['languages_url'], $last_inserted_id);
		}
	}

	public function add_user_to_db($url, $repo_id)
	{
		// Add User per Repository
		// Harus ditambah constrain agar user yg di-insert tidak duplikat
		$datas = $this->getResponse($url);
		foreach ($datas as $data) {
			$new_record = array(
				'name' => $data['login'],
				'avatar_url' => $data['avatar_url'],
			);
			
			// Constraint biar tidak ada yang duplikat
			$res = $this->db->get_where('user', array('name' => $data['login']))->result_array();
			if (count($res) == 0){
				$this->db->insert('user', $new_record);
			}

			// Get User ID masih belum bisa
			$this->db->select('id');
			$this->db->from('user');
			$this->db->where('name =', $data['login']);
			$user_id = $this->db->get()->result_array()[0]['id'];
			$contribution = $data['contributions'];
			
			$this->add_repo_user_to_db($repo_id, $user_id, $contribution);
		}
	}

	public function add_language_to_db($url, $repo_id){
		$datas = $this->getResponse($url);
		foreach ($datas as $key => $value) {
			$new_record = array(
				'name' => $key,
			);

			// Constraint biar tidak ada yang duplikat
			$res = $this->db->get_where('language', array('name' => $key))->result_array();
			if (count($res) == 0){
				$this->db->insert('language', $new_record);
			}

			// Get Language ID masih belum bisa
			$this->db->select('id');
			$this->db->from('language');
			$this->db->where('name =', $key);
			$lang_id = $this->db->get()->result_array()[0]['id'];
			
			$this->add_repo_lang_to_db($repo_id, $lang_id, $value);
		}
	}

	public function add_repo_lang_to_db($fk_repo, $fk_lang, $value){
		$new_record = array(
			'fk_repo' => $fk_repo,
			'fk_lang' => $fk_lang,
			'value' => $value
		);
		$this->db->insert('repo_lang', $new_record);
	}

	public function add_repo_user_to_db($fk_repo, $fk_user, $contribution){
		$new_record = array(
			'fk_repo' => $fk_repo,
			'fk_user' => $fk_user,
			'value' => $contribution
		);
		$this->db->insert('repo_user', $new_record);
	}

	public function get_org_from_db($org){
		$this->db->select();
		$this->db->from('organisation');
		$this->db->where('name =', $org);
		
		$result = $this->db->get()->result_array();
		
		if (count($result) == 0){
			echo "Organisasi tidak ditemukan";
		} else {
			return $result;
		}
	}

	public function get_repo_from_db($fk_org){
		$this->db->select();
		$this->db->from('repository');
		$this->db->where('fk_org =', $fk_org);
		
		$result = $this->db->get()->result_array();
		
		if (count($result) == 0){
			echo "Repository tidak ditemukan";
		} else {
			return $result;
		}
	}

	public function get_user_from_db($fk_repo){
		$this->db->select();
		$this->db->from('repo_user');
		$this->db->join('user', 'repo_user.fk_user = user.id');
		$this->db->where('repo_user.fk_repo =', $fk_repo);

		$result = $this->db->get()->result_array();

		if (count($result) == 0){
			echo "Repository tidak memiliki contributor";
		} else {
			return $result;
		}
	}

	public function get_repo_lang_from_db($fk_repo){
		$this->db->select();
		$this->db->from('repo_lang');
		$this->db->join('language', 'repo_lang.fk_lang = language.id');
		$this->db->where('repo_lang.fk_repo =', $fk_repo);

		$result = $this->db->get()->result_array();

		if (count($result) == 0){
			echo "Repository tidak memiliki language";
		} else {
			return $result;
		}
	}
}
