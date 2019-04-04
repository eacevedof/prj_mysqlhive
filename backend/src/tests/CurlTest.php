<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/CurlTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
use TheFramework\Components\ComponentCurl;

class CurlTest extends TestCase
{    
    private $r;
    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
     
    //reports/advertiser
    public function get_reports_advertiser()
    {
        $oCurl = new ComponentCurl("https://api.popcash.net/reports/advertiser");
        $oCurl->add_getfield("apikey","xxxxx");
        $oCurl->add_option(CURLOPT_RETURNTRANSFER, 1);//permite guardar el retorno en una variable
        $oCurl->add_option(CURLOPT_TIMEOUT, 15);
        $oCurl->add_option(CURLOPT_HTTPHEADER,[
            "accept: application/json"
            ,"Content-Type: multipart/form-data"
        ]);
        $this->r = $oCurl->get_result();
        $this->log($this->r,"get_reports_advertiser");
        $this->assertEquals(TRUE,is_array($this->r));
    }//get_reports_advertiser
    
    /**
    * reports/advertiser/download
    */
    public function test_reports_advertiser_download()
    {
        //http://docs.api.popcash.net/#/Advertiser/get_reports_advertiser
        $this->get_reports_advertiser();
        $this->log($this->r,"this->r en advertiser download");
        $arTokens = json_decode($this->r["curl_exec"],1);
        $arTokens = $arTokens["done"];
        $this->log($arTokens,"test_reports_advertiser_download arTokens");
        
        $sToken = $arTokens[0]["token"];
        $this->log($sToken,"token");
        $oCurl = new ComponentCurl("https://api.popcash.net/reports/advertiser/download");
        $oCurl->add_getfield("apikey","xxxxx");
        $oCurl->add_postfield("token","XkdSZUJCRnV4MVI0b0x4bjZHUU1CQm8wVDJ3XnhITW9vcU5EbE5wWWQ4MExvRWFNMFlSMHJyVFdIOUNGZXJPT2JGSHRBVnI3Z0tSVld2dnN4WWJiTmZKZyEhYVE2YUg0TmVjISFFelliY255QVNLY1NBNTM5Q0JPQ1dvUjluSl5ncWxRblZXZ2g5aENXS09vYXNkWFB4MHVNR3M5czZPZGtQNE9odmR2WUJea3ZCZEo4aVVPMVlNWHJGa2pBa1M5RmE=");
        $oCurl->add_option(CURLOPT_RETURNTRANSFER, 1);//permite guardar el retorno en una variable
        $oCurl->add_option(CURLOPT_TIMEOUT, 15);
        $oCurl->add_option(CURLOPT_HTTPHEADER,[
            "accept: application/json"
            ,"Content-Type: multipart/form-data"
        ]);
        $r = $oCurl->get_result();
        $this->log($r,"test_reports_advertiser_download");
        $this->assertEquals(TRUE,is_array($r));
    }//test_reports_advertiser_download
    
}//CurlTest