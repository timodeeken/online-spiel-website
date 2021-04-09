<?php 

namespace Core; 
use Symfony\Component\Yaml\Yaml;

class ConfigManager {
        private static $configArray = null;
        const CONFIGURATION_FILE_PATH = __DIR__ . '/../config.yaml';
        public $yamlParseArray = [];

        public static function GetConfiguration($key, $defaultValue = '') {
            $returnValue = $defaultValue;
            if (self::$configArray === null) {
                if (file_exists(self::CONFIGURATION_FILE_PATH)) {
                    self::$configArray = Yaml::parseFile(self::CONFIGURATION_FILE_PATH);
                } else {
                    self::$configArray = [];
                }
            }
    
            $currentVal = self::$configArray;
            $foundKey = false;
            $keySegments = array_values(array_filter(explode('.', $key)));
            foreach($keySegments as $idx => $currentKeySegment) {
                if (!isset($currentVal[$currentKeySegment])) break;
    
                $currentVal = $currentVal[$currentKeySegment];
                if ($idx == count($keySegments) -1) $foundKey = true;
            }
    
            if ($foundKey) $returnValue = $currentVal;
    
            return $returnValue;
        }



    public static function EditConfig($array) 
    {
        $yamlParseArray = Yaml::parse(file_get_contents(self::CONFIGURATION_FILE_PATH));
        for($i = 0; $i<count($array); $i++)
        {
            foreach($array[$i] as $key => $value) 
            {  
                $divide = explode('.', $key);
                for ($x = 0; $x < count($divide); $x++)
                {
                    $s = $divide[$x];
                }
            }      
        }


        $yamlParseArray = array_merge($yamlParseArray,$array[0]);
        $yaml1 = Yaml::dump($yamlParseArray,4);
        file_put_contents(self::CONFIGURATION_FILE_PATH, $yaml1);
    }
}