<?php
namespace TinyBlog;
abstract class Base {  
  
    public function __construct($options = null){
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public static function getFunctionNameFromFieldName($name){
        $parts = explode( '_' , $name );        
        @$newParts = array_map('ucfirst',$parts);        
        return implode($newParts);
    }
    
    public function __set($name, $value){
        $method = 'set' . $this->getFunctionNameFromFieldName($name);
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid note property');
        }
        $this->$method($value);
    }
 
    public function __get($name){
        $method = 'get' . $this->getFunctionNameFromFieldName($name);
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid note property');
        }
        return $this->$method();
    }
 
    public function setOptions(array $options){
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . $this->getFunctionNameFromFieldName($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
}