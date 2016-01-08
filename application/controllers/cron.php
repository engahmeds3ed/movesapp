<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends Main {

    public function index(){
        $this->load->model("user_model");
        $this->load->model("activity_model");
        
        $client_id = $this->config_model->config->cfg_clientid;
        $client_secret = $this->config_model->config->cfg_clientsecret;
        
        //get all users
        $allsessions = $this->user_model->get_all_sessions();
        if(!empty($allsessions)){
            foreach($allsessions as $session){
                $this->activity_model->sync_user($session->user_id,$client_id,$client_secret);
            }
        }
        
    }

}