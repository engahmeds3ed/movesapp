<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
    var $foldername = "site";
    var $cur_userdata;
    var $assets = "";
    var $data = array();
    
	public function __construct()
	{
		parent::__construct();
        $this->assets = base_url().'assets/'.$this->foldername."/";
        $this->data['cp'] = "";
        
        //config
        $this->load->model("config_model");
        $this->config_model->set_timezone();
        $this->config_model->get_config();
        $this->data['config'] = $this->config_model->config;
        
        //login
        $this->load->model("login_model");
        $this->login_model->get_cur_userdata();
        if($this->login_model->loggedin){
            $this->cur_userdata = $this->login_model->cur_userdata;
            $this->data['cur_userdata'] = $this->login_model->cur_userdata;
            $this->data['loggedin'] = 1;
            
            //cp link
            if($this->login_model->is_user()){
                $folder = "user";
            }elseif($this->login_model->is_admin()){
                $folder = "admin";
            }
            if(!empty($folder)){
                $this->data['cp'] = base_url($folder."/cp");
            }
            
        }else{
            $this->data['loggedin'] = 0;
        }
        
        $this->data['title'] = $this->config_model->config->cfg_sitename;
	}
}