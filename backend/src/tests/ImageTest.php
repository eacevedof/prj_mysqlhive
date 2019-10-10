<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/ImageTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;

class ImageTest extends TestCase
{    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
        if($sTitle) print_r("\n$sTitle\n");
        print_r("\n$mxVar\n");
    }
    
    public function test_metadata()
    {
        $url = "https://d3mfch55dy5n4c.cloudfront.net/contenidos-noticias/news_744_el-tackling-mobile-ad-fraud-se-celebra-en-telecoming-_20191007010611.jpg";
        //$url = "https://d3mfch55dy5n4c.cloudfront.net/empleados/450x450/vferrero@telecoming.com.jpgg";
        //$url = "https://d3mfch55dy5n4c.cloudfront.net/contenidos-noticias/news_undefined__20191001091432.png";
        $exif = exif_read_data($url,"IFD0");
        print_r($url);
        print_r($exif);
        $this->assertEquals(TRUE,is_array($exif));
    }  
    
}//ImageTest