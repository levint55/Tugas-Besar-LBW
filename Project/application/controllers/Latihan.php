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
		$this->getResponseOrg("ifunpar","latihan");
	}

	public function getResponseOrg($org,$view){
		$url = "https://api.github.com/orgs/".$org."/repos";
		$this->getResponse($url,$view);
	}

	public function getResponse($url,$view){
		// header('Content-type: application/json');
		//header('Content-type: text/plain');

		$ch = curl_init();
		
		curl_setopt_array($ch,[
			CURLOPT_URL => $url,
			CURLOPT_HTTPHEADER => [
				"User-Agent: IrvanHardyanto98"
			],
			CURLOPT_RETURNTRANSFER=>true,
		]);

		$response_body = curl_exec($ch);
		curl_close($ch);

		$jsonObj = json_decode($response_body,true);
		//var_dump($jsonObj);
		$this->load->view($view, [
			"datas"=> $jsonObj
		]);
	}

	public function test(){
		$this->load->helper('url');
		$this->load->view("beranda",[]);
	}
}
