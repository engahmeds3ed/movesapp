<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cp extends User{
    
    function index(){
        $this->sync();
        
        //get my own activities
        $this->load->model("activity_model");
        $where = array(
            "act_userid" => $this->cur_userdata->user_id
        );
        $this->activity_model->get_all($where,0,0,"act_date","DESC");
        $this->data['activities'] = $this->activity_model->all;
        
        $this->data['title'] = $this->config_model->config->cfg_sitename." - User Control Panel";
        $this->load->view($this->foldername .'/user/cp',$this->data);
    }
    
    function sync(){
        $client_id = $this->config_model->config->cfg_clientid;
        $client_secret = $this->config_model->config->cfg_clientsecret;
        
        $this->load->model("activity_model");
        $this->activity_model->sync_user($this->cur_userdata->user_id,$client_id,$client_secret);
    }
    
}