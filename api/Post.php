<?php
namespace TinyBlog;
include_once('Base.php');
use \TinyBlog\Base as Base;

class Post extends Base {
    public $ref;
    public $url;
    public $title;
    public $excerpt;
    public $author_name;
    public $date;
    
    public function __construct($options = null) {
        parent::__construct($options);
    }
    
    public function setRef($v) {
        $this->ref = $v;
        return $this;
    }
    public function getRef() {
        return $this->ref;
    }
    
    public function setUrl($v) {
        $this->url = $v;
        return $this;
    }
    public function getUrl() {
        if (null == $this->url) {
            $this->url = "./post?title=" . $this->getRef();
        }
        return $this->url;
    }
    
    public function setTitle($v) {
        $this->title = $v;
        return $this;
    }
    public function getTitle() {
        return $this->title;
    }
    
    public function setExcerpt($v) {
        $this->excerpt = $v;
        return $this;
    }
    public function getExcerpt() {
        return $this->excerpt;
    }
    
    public function setAuthorName($v) {
        $this->author_name = $v;
        return $this;
    }
    public function getAuthorName() {
        return $this->author_name;
    }
    
    public function setDate($v) {
        $this->date = $v;
        return $this;
    }
    public function getDate() {
        return $this->date;
    }
}