<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/CurlTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
use TheFramework\Components\ComponentCurl;

class CurlTest extends TestCase
{    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
        
    public function test_curl()
    {
        //http://docs.api.popcash.net/#/Advertiser/get_reports_advertiser
        //curl -X POST "https://api.popcash.net/reports/advertiser/download?apikey=xxxxx" -H "accept: application/json" -H "Content-Type: application/json" -d "{ \"token\": \"XkdSZUJCRnV4MVI0b0x4bjZHUU1CQm8wVDJ3XnhITW9vcU5EbE5wWWQ4MExvRWFNMFlSMHJyVFdIOUNGZXJPT2JGSHRBVnI3Z0tSVld2dnN4WWJiTmZKZyEhYVE2YUg0TmVjISFFelliY255QVNLY1NBNTM5Q0JPQ1dvUjluSl5ncWxRblZXZ2g5aENXS09vYXNkWFB4MHVNR3M5czZPZGtQNE9odmR2WUJea3ZCZEo4aVVPMVlNWHJGa2pBa1M5RmE=\"}"
        $oCurl = new ComponentCurl("https://api.popcash.net/reports/advertiser/download");
        $oCurl->add_getfield("apikey","xxxxx");
        $oCurl->add_option(CURLOPT_TIMEOUT, 15);
        $oCurl->add_option(CURLOPT_HTTPHEADER,[
            "accept: application/json"
            ,"Content-Type: application/json"
        ]);
        $r = $oCurl->get_result();
        $this->log($r,"test_curl");
        $this->assertEquals(TRUE,is_array($r));
    }
    
}//CurlTest