<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hijri {
	var $format;
    var $time;
            function get_hjri ($format,$time) {
                    $datelang[1] = "الموافق";
                    $datelang[2] = "ميلادي";
                    $datelang[3] = "هجرية";
                    $datevars=explode ("-",$format);
                             if ( $datevars[0] == "M1" ) {

                                     $Christian=1; }  else {  $Christian=0; }


                            if ( $datevars[1] == "HD1" ) {


                                    $hjri_daye_type=1;  } else { $hjri_daye_type = 0; }

                            if ( $datevars[2]  == "HM1" ) {

                                    $hjri_month_type=1; } else {  $hjri_month_type =0; }

                            if ( $datevars[3] =="CM1" ) {

                                    $Christian_month_type=1; } else { $Christian_month_type =0;} 

                            if ( $datevars[4] =="T1" ) {

                                    $hjri_time= 1; } else { $hjri_time=0; }
    $TDays=round($time/(60*60*24)); 
    $HYear=round($TDays/354.37419); 
    $Remain=$TDays-($HYear*354.37419); 
    $HMonths=round($Remain/29.531182); 
    $HDays=$Remain-($HMonths*29.531182); 
    $HYear=$HYear+1389; 
    $HMonths=$HMonths+10;$HDays=$HDays+23; 
    if ($HDays>29.531188 and round($HDays)!=30){ 
    $HMonths=$HMonths+1;$HDays=Round($HDays-29.531182); 
    }else{ 
        $HDays=Round($HDays); 
    } 

    if ($HMonths>12) { 
        $HMonths=$HMonths-12; 
        $HYear = $HYear+1; 

    }
                    $hjre_day = $this->hjri_day ($time,$hjri_daye_type);


                    $hjre_month = $this->hjri_month ($HMonths,$hjri_month_type);


                    $datetime = "$hjre_day $HDays- $hjre_month- $HYear $datelang[3]";


                    if ( $Christian ) {

                            $dm =  date ("j",$time);


                    $Christian_month = $this->Christian_month ($time,$Christian_month_type);



                    $Christian_year = date ("Y",$time);
    


    $datetime .=" $datelang[1] $dm-$Christian_month- $Christian_year $datelang[2]";

                        }

            return $datetime;

    }function hjri_day ($time,$hjri_daye_type) {


                if ( $hjri_daye_type == 1 ) {

                        $this_day = date ("l",$time);

                if ( $this_day=="Saturday") $hjri_daye_name="السبت";
                if ( $this_day=="Sunday") $hjri_daye_name="الأحد";
                if ( $this_day=="Monday") $hjri_daye_name="الاثنين";
                if ( $this_day=="Tuesday") $hjri_daye_name="الثلاثاء";
                if ( $this_day=="Wednesday") $hjri_daye_name="الأربعاء";
                if ( $this_day=="Thursday") $hjri_daye_name="الخميس";
                if ( $this_day=="Friday") $hjri_daye_name="الجمعة";


                    } else  {

                        $hjri_daye_name="";

                    }

            return $hjri_daye_name;

            }

        function hjri_month ($HMonths,$hejri_month_type) {


            if ($hejri_month_type) {


                if ( $HMonths == 1) $hjri_month_name="محرم";
                if ( $HMonths == 2) $hjri_month_name="صفر";
                if ( $HMonths == 3) $hjri_month_name="ربيع الأول";
                if ( $HMonths == 4) $hjri_month_name="ربيع الثاني";
                if ( $HMonths == 5) $hjri_month_name="جمادى الأولى";
                if ( $HMonths == 6) $hjri_month_name="جمادى الآخرة";
                if ( $HMonths == 7) $hjri_month_name="رجب";
                if ( $HMonths == 8) $hjri_month_name="شعبان";
                if ( $HMonths == 9) $hjri_month_name="رمضان";
                if ( $HMonths == 10) $hjri_month_name="شوال";
                if ( $HMonths == 11) $hjri_month_name="ذو القعدة";
                if ( $HMonths == 12) $hjri_month_name="ذو الحجة";

                        } else {

                if ( $HMonths == 1) $hjri_month_name=1;
                if ( $HMonths == 2) $hjri_month_name=2;
                if ( $HMonths == 3) $hjri_month_name=3;
                if ( $HMonths == 4) $hjri_month_name=4;
                if ( $HMonths == 5) $hjri_month_name=5;
                if ( $HMonths == 6) $hjri_month_name=6;
                if ( $HMonths == 7) $hjri_month_name=7;
                if ( $HMonths == 8) $hjri_month_name=8;
                if ( $HMonths == 9) $hjri_month_name=9;
                if ( $HMonths == 10) $hjri_month_name=10;
                if ( $HMonths == 11) $hjri_month_name=11;
                if ( $HMonths == 12) $hjri_month_name=12;

                        }

                return $hjri_month_name;

            }

        function Christian_month ($time,$Christian_month_type) {

                $month_number = date ("m",$time);

                if ( $Christian_month_type == 1) {

                        if ($month_number=="1") $Christian_month_name="يناير";
                        if ($month_number=="2") $Christian_month_name="فبراير";
                        if ($month_number=="3") $Christian_month_name="مارس";
                        if ($month_number=="4") $Christian_month_name="أبريل";
                        if ($month_number=="5") $Christian_month_name="مايو";
                        if ($month_number=="6") $Christian_month_name="يونيو";
                        if ($month_number=="7") $Christian_month_name="يوليو";
                        if ($month_number=="8") $Christian_month_name="أغسطس";
                        if ($month_number=="9") $Christian_month_name="سبتمبر";
                        if ($month_number=="10") $Christian_month_name="أكتوبر";
                        if ($month_number=="11") $Christian_month_name="نوفمبر";
                        if ($month_number=="12") $Christian_month_name="ديسمبر";


                    } else {

                        if ($month_number=="1") $Christian_month_name=1;
                        if ($month_number=="2") $Christian_month_name=2;
                        if ($month_number=="3") $Christian_month_name=3;
                        if ($month_number=="4") $Christian_month_name=4;
                        if ($month_number=="5") $Christian_month_name=5;
                        if ($month_number=="6") $Christian_month_name=6;
                        if ($month_number=="7") $Christian_month_name=7;
                        if ($month_number=="8") $Christian_month_name=8;
                        if ($month_number=="9") $Christian_month_name=9;
                        if ($month_number=="10") $Christian_month_name=10;
                        if ($month_number=="11") $Christian_month_name=11;
                        if ($month_number=="12") $Christian_month_name=12;
            }

        return $Christian_month_name;
    }
}

?>