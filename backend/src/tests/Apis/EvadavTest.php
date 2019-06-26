<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/Apis/EvadavTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
use TheFramework\Components\ComponentCurl;

class EvadavTest extends TestCase
{   
    // OS types
    const OS_OTHER = 0;
    const OS_WINDOWS = 1;
    const OS_MACOS = 2;
    const OS_LINUX = 3;
    const OS_ANDROID = 4;
    const OS_IOS = 5;

    // Browser types
    const BROWSER_OTHER = 0;
    const BROWSER_AMIGO = 1;
    const BROWSER_YANDEX = 2;
    const BROWSER_SAFARI = 3;
    const BROWSER_OPERA = 4;
    const BROWSER_FIREFOX = 5;
    const BROWSER_CHROME = 6;

    //endpoints
    const STAT_BY_DATE = "advertiser/stats/date";
    const STAT_BY_COUNTRY = "advertiser/stats/country";
    const STAT_BY_CAMPAIGN = "advertiser/stats/campaign";
    const STAT_BY_OS = "advertiser/stats/os";
    const STAT_BY_BROWSER = "advertiser/stats/browser";
    const STAT_BY_SOURCE = "advertiser/stats/source";
    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }

    private function pr($key,$value){echo "$key:\n".var_export($value,1)."\n\n";}

    public function test_stats()
    {

        //All Avaliable filters
        $filters = [
            'period' => "01.06.2019-26.06.2019",
            //'country' => ['RU','US'], // Uppercase iso code
            //'os' => [self::OS_LINUX, self::OS_ANDROID],
            //'browser' => self::BROWSER_OPERA,
        ];

        //POST
        $endpoint="https://evadav.com/api/v1/".self::STAT_BY_CAMPAIGN;
        $this->pr("endpoint",$endpoint);
        $apikey = "7jNlvr45Yp7dPis4ndcZOZiaKfvb3vjZ";
        $headers = [
            'X-Api-Key: '.$apikey
        ];

        $ch = curl_init();
        $this->pr("filters",http_build_query($filters));
        curl_setopt($ch, CURLOPT_URL,$endpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($filters));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $this->pr("server_output",$server_output);
        curl_close ($ch);

        //GET
        $params = [
            'period' => "17.02.2019-05.03.2019"
        ];
        $ch = curl_init();
        $url = $endpoint . '?' . http_build_query($filters);

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        print_r($server_output);
        
        $this->log($server_output,"test_stats");
        $this->assertEquals(TRUE,is_array($server_output));
    }//test_stats
    
}//EvadavTest
