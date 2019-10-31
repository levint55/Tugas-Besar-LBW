<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Latihan extends CI_Controller {
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
		// $this->load->database();
		// $query = $this->db->get_where('blog', array('blog_id' => 1));
		// $data = $query->result_array();
		// $this->load->view('latihan', [
		// 	"datas"=> $data
		// ]);
		//$this->getResponseOrg("ifunpar","latihan");
	}

	public function getResponseOrg($org){
		$url = "https://api.github.com/orgs/".$org."/repos";
		return $this->getResponse($url);
	}

	public function getOrgProjects($org){
		$url = "https://api.github.com/orgs/".$org."/projects";
		return $this->getResponse($url);
	}

	public function getOrgMembers($org){
		$url = "https://api.github.com/orgs/".$org."/members";
		return $this->getResponse($url);
	}

	//REFS: https://developer.github.com/v3/projects/#list-repository-projects
	//Di beranda kan ada tulisan repo, projek, sama organisasi
	//Ternyata, url mereka bertiga terpisah (nggak bisa ngambil dari satu url)
	//jadinya struktur function ini gw ubah :)
	public function getResponse($url){
		// header('Content-type: application/json');
		//header('Content-type: text/plain');

		$ch = curl_init();
		
		curl_setopt_array($ch,[
			CURLOPT_URL => $url,
			CURLOPT_HTTPHEADER => [
				"User-Agent: IrvanHardyanto98",
				"Accept: application/vnd.github.inertia-preview+json"
			],
			CURLOPT_RETURNTRANSFER=>true,
		]);

		$response_body = curl_exec($ch);
		curl_close($ch);

		$jsonObj = json_decode($response_body,true);
		//var_dump($jsonObj);
		// $this->load->view($view, [
		// 	"datas"=> $jsonObj
		// ]);
		return $jsonObj;
	}

	//ini buat nampilin view, pake data tertentu
	//show a specific view with some kind of data, represented as php traditional array
	//use empty array if no data need to be shown
	public function showView($viewName,$data){
		$this->load->view($viewName,$data);
	}

	public function test(){
		$this->load->helper('url');
		$this->load->view("beranda",[]);
	}

	public function form_submit(){
		$org_name = $this->input->post('org_name');
		//isi array datas:
		//indeks ke-0 : data repo
		//indeks ke-1 : data proyek
		//indeks ke-2 : data anggota
		$datas = array();
		array_push($datas, $this->getResponseOrg($org_name),$this->getOrgProjects($org_name),$this->getOrgMembers($org_name));
		$this->showView("beranda",["datas"=>$datas]);
	}
}
