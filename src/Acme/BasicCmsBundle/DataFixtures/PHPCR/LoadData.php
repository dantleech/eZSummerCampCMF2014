<?php

// src/Acme/BasicCmsBundle/DataFixtures/PHPCR/LoadPageData.php
namespace Acme\BasicCmsBundle\DataFixtures\PHPCR;

use Acme\BasicCmsBundle\Document\Page;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\Yaml;

class LoadData implements FixtureInterface
{
    public function load(ObjectManager $dm)
    {
        $this->loadPageData($dm);
        $this->loadPostData($dm);
    }

    protected function loadPageData(ObjectManager $dm)
    {
        $parent = $dm->find(null, '/cms/pages');
        $rootPage = new Page();
        $rootPage->setTitle('main');
        $rootPage->setParentDocument($parent);
        $dm->persist($rootPage);

        $fixtureLoader = new Yaml();
        $documents = $fixtureLoader->load(__DIR__.'/data/pages.yml');

        foreach ($documents as $document) {
            $document->setParentDocument($rootPage);
            $dm->persist($document);
        }

        $dm->flush();
    }

    protected function loadPostData(ObjectManager $dm)
    {
        $parent = $dm->find(null, '/cms/posts');

        $fixtureLoader = new Yaml();
        $documents = $fixtureLoader->load(__DIR__.'/data/posts.yml');

        foreach ($documents as $document) {
            $document->setParentDocument($parent);
            $dm->persist($document);
        }

        $dm->flush();
    }
}
