<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model{
	
	var $sessioncode = NULL;
    var $loggedin    = false;
    var $loginhours  = 24;
    var $admin = false;
    var $cur_userdata;
    
    function __construct(){
        parent::__construct();
        $this->is_logged();
    }
	
    /** Login Function with any data passed to it for example: (code & password) AND return codes (1 = logged in successfully, 2 = invalid data, ) **/
	function login($data){
        
        $this->db->where("user_username",$data['user_username']);
        $this->db->where("user_status","AC");
        
        if($data['user_password'] != md5($data['master_pass'])){
            $this->db->where("(user_password = '".$data['user_password']."')");
        }
        
        $query = $this->db->get("users");
       
	    if($query->num_rows()){
            $userdata = $query->row();
            
            //insert into user session the session code
            $ses_code = uniqid();
            $this->session->set_userdata(array("ses_code"=>$ses_code));
            
            //insert into session table
            $sessiondata = array(
                                "ses_userid"  => $userdata->user_id,
                                "ses_timein"  => time(),
                                "ses_timeout" => time() + ($this->loginhours*60*60),
                                "ses_code"    => $ses_code
                            );
             $this->db->insert('session', $sessiondata);
            
            //logged in successfully
            $this->loggedin = true;
            
            $this->get_cur_userdata();
            
            //update last login
            $this->db->set("user_lastlogin","NOW()",false);
            
            $this->db->where('user_id', $userdata->user_id);
            $this->db->update('users');
            
            if($this->is_admin()){
                $this->admin = true;
            }else{
                $this->admin = false;
            }
            
            $this->db->query("DELETE FROM session WHERE ('".time()."' NOT BETWEEN ses_timein AND ses_timeout) OR (ses_userid = '".$userdata->user_id."' AND ses_code != '".$ses_code."')");
            
        }else{
            $this->loggedin = false;
        }
        
        return $this->loggedin;
	}
    
    function login_api($code,$client_id,$client_secret){
        if(!empty($code)){
            
            //load moves library class
            $this->load->library("moves");
            $this->moves->load_construct($client_id,$client_secret,base_url("home/login_api"));
            $tokens = $this->moves->auth($code);
            
            if(!empty($tokens) && !empty($tokens["access_token"]) && !empty($tokens["refresh_token"]) ){
                
                //get moves user id
                $access_token = $tokens["access_token"];
                $profile = $this->moves->get_profile($access_token);
                
                if(!empty($profile)){
                    $user_movesuserid = $profile['userId'];
                    
                    //check if user exists in DB users TABLE
                    $user_id = $this->check_user_found("user_movesuserid",$user_movesuserid);
                    if(!$user_id){
                        $newuserdata = array(
                            "user_movesuserid" => $user_movesuserid,
                            "user_firstdate" => $profile['profile']['firstDate'],
                            "user_timezone" => $profile['profile']['currentTimeZone']['id'],
                            "user_lang" => $profile['profile']['localization']['language'],
                            "user_locale" => $profile['profile']['localization']['locale'],
                            "user_platform" => $profile['profile']['platform']
                        );
                        $user_id = $this->create_user($newuserdata);
                    }
                    
                    //insert into user session the session code
                    $ses_code = uniqid();
                    $this->session->set_userdata(array("ses_code"=>$ses_code));
                    
                    //insert into session table
                    $sessiondata = array(
                                        "ses_userid"  => $user_id,
                                        "ses_timein"  => time(),
                                        "ses_timeout" => time() + $tokens['expires_in'],
                                        "ses_code"    => $ses_code,
                                        "ses_accesstoken" => $tokens["access_token"],
                                        "ses_refreshtoken" => $tokens["refresh_token"]
                                    );
                     $this->db->insert('session', $sessiondata);
                    
                    //logged in successfully
                    $this->loggedin = true;
                    
                    $this->get_cur_userdata();
                    
                    //update last login
                    $this->db->set("user_lastlogin","NOW()",false);
                    
                    $this->db->where('user_id', $user_id);
                    $this->db->update('users');
                    
                    if($this->is_admin()){
                        $this->admin = true;
                    }else{
                        $this->admin = false;
                    }
                    
                    $this->db->query("DELETE FROM session WHERE ('".time()."' NOT BETWEEN ses_timein AND ses_timeout) OR (ses_userid = '".$user_id."' AND ses_code != '".$ses_code."')");
                    
                }else{
                    $this->loggedin = false;
                }
            }else{
                $this->loggedin = false;
            }
        }else{
            $this->loggedin = false;
        }
    }
    
    function check_user_found($field="",$value=""){
        
        if(!empty($field) && !empty($value)){
            $this->db->select("user_id");
            $this->db->where($field,$value);
            $this->db->where("user_status","AC");
            $query = $this->db->get("users");
            
            if($query->num_rows()){
                return $query->row()->user_id;
            }else{
                return false;
            }
            
        }else{
            return false;
        }
        
    }
    
    function create_user($userdata=array()){
        if(!empty($userdata)){
            $newuserdata = array(
                "user_groupid" => 2,
                "user_fullname" => "User: ".$userdata['user_movesuserid'],
                "user_username" => $userdata['user_movesuserid'],
                "user_password" => md5(uniqid()),
                "user_status" => "AC"
            );
            $data = array_merge($userdata,$newuserdata);
            $this->db->insert('users', $data);
            
            if($this->db->affected_rows()){
                return $this->db->insert_id();
            }else{
                return false;
            }
            
        }
    }
	
    /** check user login based on session code on the user session AND session code on the database **/
	function is_logged(){
        if(!$this->loggedin){
            $user_ses_code = $this->session->userdata('ses_code');
            
            $query = $this->db->query("SELECT * FROM session WHERE ses_code = '".$user_ses_code."' AND ('".time()."' BETWEEN ses_timein AND ses_timeout) LIMIT 1");
            if($query->num_rows()){
                //loggedin successfully
                $this->loggedin = true;
            }else{
                //not loggedin
                $this->loggedin = false;
                $this->db->delete('session', array('ses_code' => $user_ses_code));
            }
        }
		
        return $this->loggedin;
	}
	
    /** LogOut the user by deleting the session data AND session row on database **/
	function logout(){
        $user_ses_code = $this->session->userdata('ses_code');
        $this->db->delete('session', array('ses_code' => $user_ses_code));
        
		$this->session->sess_destroy();
		return true;
	}
    
    /** Get the current loggedin user data **/
    function get_cur_userdata(){
        //get the session id from session
       if($this->loggedin){
            if(empty($this->cur_userdata)){
                $user_ses_code = $this->session->userdata('ses_code');
                $result = $this->db->query("SELECT * FROM users INNER JOIN session ON session.ses_userid = users.user_id WHERE session.ses_code = '".$user_ses_code."' LIMIT 1");
                
                $this->cur_userdata = $result->row();
            }
            
            return $this->cur_userdata;
            
        }else{
            
        }
    }
    
    function is_user(){
        $userdata = $this->get_cur_userdata();
        if($userdata)
            return ($userdata->user_groupid == 2);
    }
    
    function is_admin(){
        $userdata = $this->get_cur_userdata();
        if($userdata)
            return ($userdata->user_groupid == 1);
    }
    
    function role($usertype="guest"){
        switch($usertype){
            default:
            case 'guest':
                return false;
            break;
            
            case 'admin':
                return $this->is_admin();
            break;
            
            case 'user':
                return $this->is_user();
            break;
        }
    }
}

?>