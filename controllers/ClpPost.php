<?php

class Clp_Post
{
    private $_post;

    public function __construct()
    {
        global $post;
        $this->_post = $post;
    }

    public function isPublish()
    {
        return $this->getPost()->post_status == 'publish' ? true : false;
    }

    public function removeAllUrlsByPostId()
    {
        add_action( 'save_post', array($this, 'removeUrls'));
    }

    public function removeUrls($post)
    {
        $computeLinkModel = new Clp_Link();
        $a = $computeLinkModel->deleteUrlsByPostId($post);
    }

    public function getPost()
    {
        return $this->_post;
    }
}
