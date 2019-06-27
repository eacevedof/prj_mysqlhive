<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Components\Db\Context\ComponentContext 
 * @file component_context.php v2.0.0
 * @date 19-09-2017 04:56 SPAIN
 * @observations
 */
namespace TheFramework\Components\Db\Context;

class ComponentContext 
{

    private $isError;
    private $arErrors; 
    
    private $arContexts;
   
    public function __construct($sPathfile="")
    {
        $this->arContexts = [];
        if(!$sPathfile) $sPathfile = __DIR__.DIRECTORY_SEPARATOR."contexts.json";
        $this->load_contextjs($sPathfile);
    }
    
    private function load_contextjs($sPathfile)
    {
        if($sPathfile)
            if(is_file($sPathfile))
            {
                $sJson = file_get_contents($sPathfile);
                $this->arContexts = json_decode($sJson,1);
            }
            else
                $this->add_error("load_contextjs: file $sPathfile not found");
        else
            $this->add_error("load_contextjs: no pathfile passed");
    }
    
    public function get_config()
    {
        return $this->arContexts;
    }

    public function get_errors(){return isset($this->arErrors)?$this->arErrors:[];}     
    public function is_error(){return $this->isError;}
    private function add_error($sMessage){$this->isError = true; $this->arErrors[] = $sMessage;}
    
}//ComponentContext