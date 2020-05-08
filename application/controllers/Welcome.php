<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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


	/*public function index() {
		$this->load->view('welcome_message');
	}*/

	public function privacy_policy(){
         $this->load->view('privacy');
    }

    public function terms_condition(){
         $this->load->view('terms_condition');
    }

    public function about_app(){
         $this->load->view('aboutapp');
    }

    public function virtual_terms(){
         $this->load->view('virtual_terms_condition');
    }


     public function test(){
 		$staticTemp =  $this->Common_model->getDataFromTabel('static_template', '*');
        $data['staticTemp'] = !empty($staticTemp) ? $staticTemp : "";
        $this->load->view('test', $data);
    }
       public function faq($language=''){
        $data['language']=($language== 'sw') ? 'sw' : 'en'; //change by harish
        //$where = array('slug' =>'about-us');
        //$data['static_data'] = $this->dynamic_model->getdatafromtable('static_page',$where);
        $this->load->view('faq',$data);
    }
}
