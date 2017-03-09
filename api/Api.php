<?php
namespace TinyBlog;
include_once('Post.php');
include_once('Base.php');
include_once('Feed.php');
use \TinyBlog\Base as Base;
use \TinyBlog\Feed as Feed;
use \TinyBlog\Post as Post;

class Api extends Base {
    
    private $_posts_config;
    
    public function getPosts(array $args) {
        $args = array_merge(array('rows' => 5, 'start' => 0, 'type' => 'latest'), $args);
        $this->_posts_config = include(dirname(__FILE__) . "/data/post_config.php");
        
        $i = 0;
        $e = ($args['start'] ? $args['start'] - 1 : 0) + $args['rows'];
        $selectedRows = array();
        
        if ($args['type'] == 'random') {
            if (count($this->_posts_config) < $args['rows']) {
                foreach($this->_posts_config as $k => $v) {
                    $selectedRows[] = $v;
                }
            } elseif (count($this->_posts_config) <= $e) {
                for($i = $args['start']; $i <= $e; $i++) {
                    @$selectedRows[] = $this->_posts_config[ $i ];
                }
            } else {
                for($i; $i < $args['rows']; $i++) {
                    $rand = rand(($args['start'] ? $args['start'] : 1), count($this->_posts_config));
                    $selectedRows[] = $this->_posts_config[ $rand - 1 ];
                }
            }
            
        } elseif ($args['type'] == 'latest') {
            usort($this->_posts_config, function($a, $b) { return strcmp($b["date"], $a["date"]); } );
            
            foreach($this->_posts_config as $k => $v) {
                if ($i >= $args['start'] && $i < $e) {
                    $selectedRows[] = $v;
                }
                
                if ($i > $e) break;
                $i++;
            }
        }
        
        $feed = new Feed();
        foreach($selectedRows as $pData) {
            $post = new Post($pData);
            $feed->addItem($post);
        }
        
        $feed->setRows($args['rows'])->setStart($args['start']);
        return $feed;
    }
    
    private function _cmp($a, $b) {
        return ;
    }
}