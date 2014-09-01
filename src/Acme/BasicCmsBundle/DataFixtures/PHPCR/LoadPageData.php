<?php

// src/Acme/BasicCmsBundle/DataFixtures/PHPCR/LoadPageData.php
namespace Acme\BasicCmsBundle\DataFixtures\PHPCR;

use Acme\BasicCmsBundle\Document\Page;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPageData implements FixtureInterface
{
    public function load(ObjectManager $dm)
    {
        $parent = $dm->find(null, '/cms/pages');

        $page = new Page();
        $page->setTitle('Home');
        $page->setParentDocument($parent);
        $page->setContent(<<<HERE
Welcome to the homepage of this really basic CMS.
HERE
        );

        $dm->persist($page);
        $dm->flush();
    }
}  
