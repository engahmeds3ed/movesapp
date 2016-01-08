<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Main {
    
	public function __construct()
	{
		parent::__construct();
        
        if(!$this->login_model->role("user")){
            redirect(base_url("login"));
        }else{
            
        }
	}
}