<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends Admin{
    
    function index(){
        
        $postdata = $this->input->post();
        
        if(!empty($postdata)){
            
            unset($postdata['submit']);
            
            if(!isset($postdata['cfg_sitestatus'])) $postdata['cfg_sitestatus'] = 0;
            
            $updated = $this->config_model->save_config($postdata);
            
            $this->data['config'] = $this->config_model->config;
            
            if($updated){
                $this->data['msg'] = "تم الحفظ بنجاح.";
            }else{
                $this->data['msg'] = "لم يتم تغيير البيانات.";
            }
        }
        
        $this->load->library("editor");
        $this->editor->loadeditor("ckeditor");
        $this->data['scripts'] = $this->editor->data['scripts'];
        
        $this->data['title'] = "الإعدادات العامة" . " | " . $this->config_model->config->cfg_sitename;
        $this->load->view($this->foldername . '/admin/settings',$this->data);
        
    }
    
}