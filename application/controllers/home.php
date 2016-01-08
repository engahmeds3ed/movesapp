<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Main {
	public function index(){
        $client_id = $this->config_model->config->cfg_clientid;
        $client_secret = $this->config_model->config->cfg_clientsecret;
        
        $this->load->library("moves");
        $this->moves->load_construct($client_id,$client_secret,base_url("home/login_api"));
        $this->data['request_url'] = $this->moves->requestURL();
        
        $this->data['title'] = $this->config_model->config->cfg_sitename;
        $this->load->view($this->foldername .'/home',$this->data);
	}
    
    public function login_API(){
        $code = $this->input->get('code');
        $client_id = $this->config_model->config->cfg_clientid;
        $client_secret = $this->config_model->config->cfg_clientsecret;
        
        $this->login_model->login_api($code,$client_id,$client_secret);
        if($this->login_model->loggedin){
            $this->data['msg'] = "LoggedIn Successfully.";
            $this->data['title'] = $this->data['msg'];
            $this->data['url'] = base_url("user/cp");
        }else{
            $this->data['msg'] = "ERROR while logging in!";
            $this->data['title'] = $this->data['msg'];
            $this->data['url'] = base_url("");
        }
        
        $this->load->view($this->foldername . '/message',$this->data);
    }
}