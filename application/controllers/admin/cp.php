<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cp extends Admin{
    
    function index(){
        $getdata = $this->input->get();
        
        //get all users
        $this->data['allusers'] = array();
        $this->data['allusers'][0] = "Choose User";
        $this->data['cur_userid'] = 0;
        $this->load->model("user_model");
        $this->user_model->get_all();
        $allusers = $this->user_model->all;
        if(!empty($allusers)){
            foreach($allusers as $user){
                $this->data['allusers'][$user->user_id] = $user->user_fullname;
            }
        }
        
        //get my own activities
        $this->load->model("activity_model");
        $where = array();
        
        if(isset($getdata['user_id'])){
            $where['user_id'] = $getdata['user_id'];
            $this->data['cur_userid'] = $getdata['user_id'];
        }
        
        $this->activity_model->get_all($where,0,0,"act_date","DESC");
        $this->data['activities'] = $this->activity_model->all;
        
        $this->data['title'] = $this->config_model->config->cfg_sitename." - User Control Panel";
        $this->load->view($this->foldername .'/admin/cp',$this->data);
    }
    
}