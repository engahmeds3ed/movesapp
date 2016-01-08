<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{
    
    public $all;
    public $one;
    
    function get_count($wheredata=array()){
        
        if(!empty($wheredata)){
            foreach($wheredata as $field=>$value){
                $this->db->where($field,$value);
            }
        }
        
        $this->db->where("user_groupid",2);
        return $this->db->count_all_results("users");
        
    }
    
    function get_all($wheredata=array(),$limit=0,$start=0,$order="user_id",$dir="DESC"){
        $this->all = NULL;
        
        $this->db->select("users.*");
        
        if(!empty($wheredata)){
            foreach($wheredata as $field=>$value){
                $this->db->where($field,$value);
            }
        }
        
        $this->db->where("user_groupid",2);
        
        if(!empty($limit)){
            $this->db->limit($limit,$start);
        }
        
        $this->db->order_by($order,$dir);
        
        $query = $this->db->get("users");
        
        if($query->num_rows()){
            $this->all = $query->result();
            return true;
        }else{
            return false;
        }
        
    }
    
    function get_one($id){
        $wheredata = array("user_id"=>$id);
        
        $status = $this->get_all($wheredata,1);
        if($status){
            $this->one = $this->all[0];
        }else{
            $this->one = null;
        }
    }
    
    function saveadd($insertdata){
        
        if(!empty($insertdata)){
            if($this->user_found($insertdata['user_username'])){
                $output['errors'][] = "Added Before.";
                $output['success'] = false;
            }else{
                $insertdata['user_groupid'] = 2;
                $this->db->insert("users",$insertdata);
                
                if($this->db->affected_rows()){
                    $output['success'] = true;
                }else{
                    $output['errors'][] = "ERROR on adding.";
                    $output['success'] = false;
                }
            }
        }else{
            $output['success'] = false;
        }
        
        return $output;
        
    }
    
    function saveedit($id,$insertdata){
        
        if(!empty($insertdata) && !empty($id)){
            if($this->user_found($insertdata['user_username'],array($id))){
                $output['errors'][] = "User Added Before.";
                $output['success'] = false;
            }else{
                $insertdata['user_groupid'] = 2;
                $this->db->where("user_id",$id);
                $this->db->update("users",$insertdata);
                
                if($this->db->affected_rows()){
                    $output['success'] = true;
                }else{
                    $output['errors'][] = "ERROR On Saving.";
                    $output['success'] = false;
                }
            }
            
            
        }else{
            $output['success'] = false;
        }
        
        return $output;
        
    }
    
    function delete($id){
        if(!empty($id)){
            $this->db->where("user_id",$id);
            
            $this->db->delete("users");
            
            if($this->db->affected_rows()){
                $output['success'] = true;
            }else{
                $output['errors'][] = "ERROR On Deleting.";
                $output['success'] = false;
            }
            
        }else{
            $output['success'] = false;
        }
        
        return $output;
        
    }
    
    function user_found($username,$except=array()){
        $this->db->where("user_username",$username);
        if(!empty($except)){
            $this->db->where_not_in("user_id",$except);
        }
        
        $count = $this->db->count_all_results("users");
        
        return ($count > 0);
        
    }
    
    function get_all_sessions(){
        $this->db->select("user_id");
        $this->db->join("users","ses_userid = user_id","INNER");
        
        $this->db->where("ses_timeout > '".time()."'",null,false);
        $this->db->where("user_status","AC");
        
        $query = $this->db->get("session");
        if($query->num_rows()){
            return $query->result();
        }else{
            return false;
        }
        
    }
    
}