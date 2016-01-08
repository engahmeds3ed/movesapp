<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activity_model extends CI_Model{
    public $all;
    public $one;
    
    function get_all($wheredata=array(),$limit=0,$start=0,$order="act_id",$dir="DESC"){
        $this->all = NULL;
        
        $this->db->select("act_id,user_movesuserid,act_date,act_type,act_duration,act_distance,act_steps,act_created");
        
        $this->db->join("users","act_userid = user_id","INNER");
        
        if(!empty($wheredata)){
            foreach($wheredata as $field=>$value){
                $this->db->where($field,$value);
            }
        }
        
        $this->db->where("user_groupid",2);
        $this->db->where("user_status","AC");
        
        if(!empty($limit)){
            $this->db->limit($limit,$start);
        }
        
        $this->db->order_by($order,$dir);
        
        $query = $this->db->get("activities");
        
        if($query->num_rows()){
            $this->all = $query->result();
            return $this->all;
        }else{
            return false;
        }
        
    }
    
    function get_range($from="",$to=""){
        if(!empty($from) && !empty($to)){
            $this->db->select("act_id,act_date,act_type,act_duration,act_distance,act_steps,act_created");
            
            $this->db->where("UNIX_TIMESTAMP(act_date) BETWEEN UNIX_TIMESTAMP(".$from.") AND UNIX_TIMESTAMP(".$to.")",null,false);
            $this->db->order_by("act_date","ASC");
            
            $query = $this->db->get("activities");
            if($query->num_rows()){
                return $query->result();
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    function get_week($year="",$week=""){
        if(!empty($year) && !empty($week)){
            $this->db->select("act_id,act_date,act_type,act_duration,act_distance,act_steps,act_created");
            
            $this->db->order_by("act_date","ASC");
            
            $this->db->where("WEEK(act_date) = '".$week."'",null,false);
            $this->db->where("YEAR(act_date) = '".$year."'",null,false);
            $query = $this->db->get("activities");
            if($query->num_rows()){
                return $query->result();
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    function get_month($year="",$month=""){
        if(!empty($year) && !empty($month)){
            $this->db->select("act_id,act_date,act_type,act_duration,act_distance,act_steps,act_created");
            
            $this->db->order_by("act_date","ASC");
            
            $this->db->where("MONTH(act_date) = '".$month."'",null,false);
            $this->db->where("YEAR(act_date) = '".$year."'",null,false);
            $query = $this->db->get("activities");
            if($query->num_rows()){
                return $query->result();
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    function get_one($id){
        $wheredata = array("act_id"=>$id);
        
        $status = $this->get_all($wheredata,1);
        if($status){
            $this->one = $this->all[0];
        }else{
            $this->one = null;
        }
    }
    
    function saveadd($insertdata){
        
        if(!empty($insertdata)){
            $this->db->insert("activities",$insertdata);
            
            if($this->db->affected_rows()){
                $output['success'] = true;
            }else{
                $output['errors'][] = "حدث خطأ عند الإضافة لقاعدة البيانات.";
                $output['success'] = false;
            }
        }else{
            $output['success'] = false;
        }
        
        return $output;
        
    }
    
    function saveedit($id,$insertdata){
        
        if(!empty($insertdata) && !empty($id)){
            $this->db->where("act_id",$id);
            $this->db->update("activities",$insertdata);
            
            if($this->db->affected_rows()){
                $output['success'] = true;
            }else{
                $output['errors'][] = "حدث خطأ عند الإضافة لقاعدة البيانات.";
                $output['success'] = false;
            }
        }else{
            $output['success'] = false;
        }
        
        return $output;
        
    }
    
    function delete($id){
        if(!empty($id)){
            $this->db->where("act_id",$id);
            
            $this->db->delete("activities");
            
            if($this->db->affected_rows()){
                $output['success'] = true;
            }else{
                $output['errors'][] = "ERROR while deleting.";
                $output['success'] = false;
            }
            
        }else{
            $output['success'] = false;
        }
        
        return $output;
        
    }
    
    function delete_by_userday($user_id,$day){
        $this->db->where("act_userid",$user_id);
        $this->db->where("act_date",$day);
        
        $this->db->delete("activities");
    }
    
    function sync_user($user_id,$client_id,$client_secret){
        if(!empty($user_id)){
            $this->load->library("moves");
            $this->moves->load_construct($client_id,$client_secret,base_url("home/login_api"));
            $userdata = $this->get_userdata($user_id);
            $access_token = $userdata['ses_accesstoken'];
            $user_lastrefresh = $userdata['user_lastrefresh'];
            
            $params = array(
                "pastDays" => 31,
                "updatedSince" => date("Ymd\THis\Z",$user_lastrefresh)
            );
            
            $activities = $this->moves->get_range($access_token,'/user/summary/daily',$params);
            
            foreach($activities as $activity){
                if(strtotime($activity['lastUpdate']) > $user_lastrefresh){
                    
                    if(!empty($activity['summary'])){
                        //delete all previously added activities for this day
                        $this->delete_by_userday($user_id,$activity['date']);
                        
                        //add all summaries based on activity = walking
                        foreach($activity['summary'] as $summary){
                            if($summary['activity'] == 'walking'){
                                $addactivity = array(
                                    "act_date" => $activity['date'],
                                    "act_type" => $summary['activity'],
                                    "act_duration" => $summary['duration'],
                                    "act_distance" => $summary['distance'],
                                    "act_steps" => $summary['steps'],
                                    "act_userid" => $user_id
                                );
                                
                                $this->saveadd($addactivity);
                                
                            }
                        }
                    }
                    
                    //update user_lastrefresh for this user
                    $this->update_lastrefresh($user_id);
                }else{
                    //DO Nothing as it added before
                }
            }
        }
    }
    
    function get_userdata($user_id){
        if(!empty($user_id)){
            $this->db->select("ses_accesstoken,user_lastrefresh");
            $this->db->join("users","ses_userid = user_id","INNER");
            $this->db->where("user_id",$user_id);
            $query = $this->db->get("session");
            if($query->num_rows()){
                $output['ses_accesstoken'] = $query->row()->ses_accesstoken;
                $output['user_lastrefresh'] = $query->row()->user_lastrefresh;
                return $output;
            }else{
                return false;
            }
        }
    }
    
    function update_lastrefresh($user_id){
        $this->db->where("user_id",$user_id);
        $update = array(
            "user_lastrefresh" => time()
        );
        
        $this->db->update("users",$update);
    }
    
}