<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends Main {

    public function index(){
        
    }
    
    /*
        1- ?from=#&to=#
        2- 2016-01 (MONTH)
        3- 2016-W01 (WEEK)
    */
    public function activities($datestamp=""){
        $this->load->model("activity_model");
        $getdata = $this->input->get();
        
        if(isset($getdata['from']) && isset($getdata['to'])){
            //FROM-TO
            $allactivites = $this->activity_model->get_range($getdata['from'],$getdata['to']);
        }elseif(!empty($datestamp) && strstr($datestamp,"W")){
            //WEEK
            $date_array = explode("-",str_replace("W","",$datestamp));
            $year = $date_array[0];
            $week = $date_array[1];
            $allactivites = $this->activity_model->get_week($year,$week);
            
        }else{
            if(strstr($datestamp,"-")){
                //MONTH
                $date_array = explode("-",$datestamp);
                $year = $date_array[0];
                $month = $date_array[1];
                $allactivites = $this->activity_model->get_month($year,$month);
            }else{
                $allactivites = $this->activity_model->get_all();
            }
            
        }
        
        if(!empty($allactivites)){
            echo json_encode($allactivites);
        }else{
            echo json_encode(array("error"=>"No Activities Found!"));
        }
        
        
    }

}