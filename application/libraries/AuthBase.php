<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AuthBase{
	private $secretAcessKey="";
	private $access_key="";
    
    public function initialize($secretAcessKey,$access_key){
        $this->secretAcessKey = $secretAcessKey;
		$this->access_key     = $access_key;
    }
    
    function GenerateTimeStamp()
    {
   	    return time();
    }

    function GenerateSignature($methodName,&$requestParameters) {
        $signatureBase="";
        $secretAcessKey = urlencode($this->secretAcessKey);
        $requestParameters["access_key"] = $this->access_key;
        $requestParameters["timestamp"] =$this->GenerateTimeStamp();
        $requestParameters["method"] = $methodName;
        
        foreach ($requestParameters as $key => $value){
        	if(strlen($signatureBase)>0)
        	   $signatureBase.="&";
               
        	$signatureBase.="$key=$value";
        }
        //echo "<br>signatureBase=".$signatureBase;
        return base64_encode($this->hmacsha1($secretAcessKey, $signatureBase));
    }

    function hmacsha1($key,$data) {
        $blocksize=64;
        $hashfunc='sha1';
        if (strlen($key)>$blocksize)
            $key=pack('H*', $hashfunc($key));
            
        $key=str_pad($key,$blocksize,chr(0x00));
        $ipad=str_repeat(chr(0x36),$blocksize);
        $opad=str_repeat(chr(0x5c),$blocksize);
        $hmac = pack(
                    'H*',$hashfunc(
                        ($key^$opad).pack(
                            'H*',$hashfunc(
                                ($key^$ipad).$data
                            )
                        )
                    )
                );
        return $hmac;
    }

}//end class AuthBase



?>

