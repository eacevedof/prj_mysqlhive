<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Components\Db\Context\ComponentContext 
 * @file component_context.php v2.1.1
 * @date 02-07-2019 20:37 SPAIN
 * @observations
 */
namespace TheFramework\Components\Db\Context;

class ComponentContext 
{
    private $isError;
    private $arErrors; 
    
    private $arContexts;
    private $arContextNoconf;
    
    private $idSelected;
    private $arSelected;
    
    public function __construct($sPathfile="",$idSelected="")
    {
        $this->idSelected = $idSelected;
        $this->arContexts = [];
        if(!$sPathfile) $sPathfile = __DIR__.DIRECTORY_SEPARATOR."contexts.json";
        if(!is_file($sPathfile))
        {
            $this->add_error("No context file found: $sPathfile");
            return -1;
        }
        $this->load_contextjs($sPathfile);
        $this->load_context_noconf();
        $this->load_selected();
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
    
    private function load_context_noconf()
    {
        foreach($this->arContexts as $arContext)
        {
            unset($arContext["config"]);
            $this->arContextNoconf[] = $arContext;
        }
    }
    
    private function load_selected()
    {
        $this->arSelected["ctx"] = $this->get_by_id($this->idSelected)[0];
        bug($this->idSelected,"id_selected");
        bug($this->arSelected,"arSelected");
        bug($this->get_by_id($this->idSelected),"get_byid");die;
        $this->arSelected["noconfig"] = $this->get_noconfig_by("id",$this->idSelected)[0];
    }
    
    private function get_filter_level_1($sKey, $sValue, $arArray=[])
    {
        if(!$arArray) $arArray = $this->arContexts;
        
        $arFiltered = array_filter($arArray, function($arConfig) use($sKey,$sValue) {
            return $arConfig[$sKey] == $sValue;
        });
        return $arFiltered;
    }    
    
    public function get_config(){ return $this->arContexts;}
    
    public function get_by_id($id){ return $this->get_filter_level_1("id",$id); }
    
    public function get_by($key,$val){ return $this->get_filter_level_1($key,$val); }
    
    public function get_config_by($key,$val)
    {
        $arConfig = $this->get_filter_level_1($key,$val);
        if($arConfig)
        {
            $arConfig = $arConfig[array_keys($arConfig)[0]];
            return $arConfig["config"];
        }
        return [];
    }
    
    public function get_selected(){return $this->arSelected;}
    public function get_selected_id(){return $this->arSelected["ctx"]["id"];}
    public function get_selected_db(){return $this->arSelected["ctx"]["config"]["database"];}
    
    public function get_noconfig_by($key,$val){return $this->get_filter_level_1($key,$val,$this->arContextNoconf);}
    
    public function get_noconfig(){return $this->arContextNoconf;}
    public function get_errors(){return isset($this->arErrors)?$this->arErrors:[];}     
    public function is_error(){return $this->isError;}
    private function add_error($sMessage){$this->isError = true; $this->arErrors[] = $sMessage;}
    
}//ComponentContext

/*
(
    [0] => Array
        (
            [id] => agencyreader
            [alias] => Test agency-reader
            [description] => Agency Reader
            [config] => Array
                (
                    [type] => mysql
                    [server] => dbb2c01-replica-bi.rdsxxx.io
                    [database] => agency
                    [user] => xxx
                    [password] => slavereader
                )

        )

    [1] => Array
        (
            [id] => dev
            [alias] => Test dev-agregacion
            [description] => Development
            [config] => Array
                (
                    [type] => mysql
                    [server] => dev01.serverxxx.io
                    [database] => db_agregacion
                    [user] => root
                    [password] => yyy
                )

        )

    [2] => Array
        (
            [id] => draco
            [alias] => Test draco-reader
            [description] => Draco Reader
            [config] => Array
                (
                    [type] => mysql
                    [server] => dbcommon-bi.rdsxxx.io
                    [database] => draco
                    [user] => stratebi
                    [password] => zzz
                )

        )

)
*/