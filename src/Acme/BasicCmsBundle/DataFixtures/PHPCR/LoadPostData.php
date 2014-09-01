<?php

// src/Acme/BasicCmsBundle/DataFixtures/PHPCR/LoadPostData.php
namespace Acme\BasicCmsBundle\DataFixtures\Phpcr;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\BasicCmsBundle\Document\Post;

class LoadPostData implements FixtureInterface
{
    public function load(ObjectManager $dm)
    {
        $parent = $dm->find(null, '/cms/posts');

        foreach (array('First', 'Second', 'Third', 'Forth') as $title) {
            $post = new Post();
            $post->setTitle(sprintf('My %s Post', $title));
            $post->setParentDocument($parent);
            $post->setContent(<<<HERE
This is the content of my post.
HERE
            );

            $dm->persist($post);
        }

        $dm->flush();
    }
}
