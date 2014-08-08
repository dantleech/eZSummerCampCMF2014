<?php

// src/Acme/BasicCmsBundle/Document/Site.php
namespace Acme\BasicCmsBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document()
 */
class Site
{
    /**
     * @PHPCR\Id()
     */
    protected $id;

    /**
     * @PHPCR\ReferenceOne(targetDocument="Acme\BasicCmsBundle\Document\Page")
     */
    protected $homepage;

    /**
     * @PHPCR\Children()
     */
    protected $children;

    public function getHomepage()
    {
        return $this->homepage;
    }

    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getChildren() 
    {
        return $this->children;
    }
    
    public function setChildren($children)
    {
        $this->children = $children;
    }
    
}
