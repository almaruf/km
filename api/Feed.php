<?php
namespace TinyBlog;
include_once('Base.php');
use \TinyBlog\Base as Base;

/**
 * A class for manipulating an array of objects. Feed is specially used 
 * when there is a one-to-many relationship between objects is present, 
 * ie. a restaurant has a number of videos that creates a perfect one-many 
 * relationship between a restaurant and the videos, in this case we put the 
 * video objects for this restaurant into a Feed and use this feed to look 
 * for more or less videos etc.
 * 
 * 
 * @see Base.php
 * @package TinyBlog
 * @version 1.0
 *
 * @author Md Abdullah Al Maruf <maruf.sylhet@gmail.com>
 */
 
class Feed extends Base{
    /**
    * The type of the items, usually it is the Class of the items stored in items array
    */
    public $type;
    
    /**
    * The start index for this feed
    */
    public $start = 0;
    
    /**
    * The number of items obtained in this feed
    */
    public $rows = 20;
    
    /**
    * The number of possible items
    */
    public $total = 0;
    
    /**
    * The actual items in an array, usually these are objects
    */
    public $items = array();
    
    
    /**
    * Creates a Feed object recursively from the provided array
    * 
    * @param    array    $options
    */
    public function __construct($options = null){
        parent::__construct($options);
        
        if (is_array(end($this->items))) {
            foreach($this->items as $k => $item) {
                if (! $this->getType()) {
                    throw new EzyException("Feed type not provided.");
                }
                
                $className = "\Ezy\\" . ucwords($this->getType());
                $this->items[ $k ] = new $className($item);
            }
        }
    }
     
    /**
    * Whether previous feed is present
    * 
    * @return   Boolean
    */
    public function hasPrevious(){
        if( ($this->start >= $this->rows) ){
            return true;
        }
    }   
    
    /**
    * Whether next feed is present
    * 
    * @return   Boolean
    */
    public function hasNext(){
        if( !is_null($this->total) && ($this->start + $this->rows) < $this->total ){
            return true;
        }
    }
        
    /**
    * Get all the items on that Feed
    * 
    * @return   array
    */   
    public function getItems(){
        return $this->items;
    }
    public  function setItems($items = null){
        if(null !== $items) {
            $this->items = $items;            
        }
        return $this;
    }  
    public  function addItem($item){
        $this->items[] = $item;
        return $this;
    }    
    
    
    /**
    * Get the type of the objects stored, usually it is the Class name of the items objects
    * 
    * @return   String
    */       
    public function getType(){    
        return $this->type;
    }
    public function setType($value){  
        $this->type = $value;
        return $this;
    }
    
    /**
    * Get the start index of the Feed, default is 0
    * 
    * @return   Integer
    */ 
    public function getStart(){    
        return $this->start;
    }
    public function setStart($value){  
        $this->start = $value;
        return $this;
    }
    
    
    /**
    * Get the total number of items possible
    * 
    * @return   Integer
    */ 
    public function getTotal(){    
        return $this->total;
    }    
    public function setTotal($value){  
        $this->total = $value;
        return $this;
    }
    
    
    /**
    * Get the number of objects returned in this Feed
    * 
    * @return   Integer
    */ 
    public function getRows(){    
        return $this->rows;
    } 
    public function setRows($value){  
        $this->rows = $value;
        return $this;
    }   
}
