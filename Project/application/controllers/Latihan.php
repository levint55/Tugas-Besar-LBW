<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Latihan extends CI_Controller
{
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
		//echo "Ha! It's ME!";
		$this->load->database();
		// $query = $this->db->get_where('blog', array('blog_id' => 1));
		// $data = $query->result_array();
		// $this->load->view('latihan', [
		// 	"datas"=> $data
		// ]);
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
		$org_name = $this->input->post('org_name');
		//isi array datas:
		//indeks ke-0 : data repo
		//indeks ke-1 : data proyek
		//indeks ke-2 : data anggota
		$datas = array();
		array_push($datas, $this->getResponseOrg($org_name), $this->getOrgProjects($org_name), $this->getOrgMembers($org_name));
		$this->showView("beranda", ["datas" => $datas]);
	}

	public function add_to_db($org)
	{
		$res = $this->db->get_where('organisation', array('name' => $org))->result_array();
		if (count($res) == 0) {
			// Add Organisation
			$this->add_org_to_db($org);
			$last_inserted_id = $this->db->insert_id();
			
			// Add Repository
			$this->add_repo_to_db($org, $last_inserted_id);

		} else {
			echo 'data sudah ada';
		}
	}

	public function add_org_to_db($org)
	{
		$data = $this->getResponseOrg($org);
		$new_record = array(
			'name' => $data['login'],
			'full_name' => $data['name'],
			'follower' => $data['followers'],
			'following' => $data['following']
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
				'fk_org' => $org_id
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
			
			$this->add_repo_user_to_db($repo_id, $user_id);
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

	public function add_repo_user_to_db($fk_repo, $fk_user){
		$new_record = array(
			'fk_repo' => $fk_repo,
			'fk_user' => $fk_user
		);
		$this->db->insert('repo_user', $new_record);
	}
}
