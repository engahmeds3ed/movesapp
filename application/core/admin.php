<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Main {
    
	public function __construct()
	{
		parent::__construct();
        
        if(!$this->login_model->role("admin")){
            $this->session->set_userdata(array("returnto"=>current_url()));
            redirect(base_url("login"));
        }else{
            //get all components for admin sidebar
            $this->data['components'] = array(
                array(
                    "id" => "cp",
                    "title" => "لوحة التحكم",
                    "children" => array(
                        array(
                            "title" => "لوحة التحكم",
                            "link" => $this->data['cp']
                        ),
                        array(
                            "title" => "رئيسية الموقع",
                            "link" => base_url()
                        ),
                        array(
                            "title" => "الاعدادات العامة",
                            "link" => base_url("admin/settings")
                        ),
                        array(
                            "title" => "تسجيل خروج",
                            "link" => base_url("login/logout")
                        ),
                    )
                ),
                
            );
            
            //get current page
            $this->data['cur_page'] = "cp";
            
        }
	}
}