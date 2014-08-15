<?php

namespace Acme\BasicCmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $site = $dm->find('Acme\BasicCmsBundle\Document\Site', '/cms');
        $homepage = $site->getHomepage();

        if (!$homepage) {
            throw $this->createNotFoundException('No homepage configured');
        }

        return $this->forward('AcmeBasicCmsBundle:Default:page', array(
            'contentDocument' => $homepage
        ));
    }

    /**
     * @Template()
     */
    public function pageAction($contentDocument)
    {
        $dm = $this->get('doctrine_phpcr')->getManagerForClass('AcmeBasicCmsBundle:Post');
        $posts = $dm->getRepository('AcmeBasicCmsBundle:Post')->findAll();

        return array(
            'page'  => $contentDocument,
            'posts' => $posts,
        );
    }

    /**
     * @Template()
     */
    public function postAction($contentDocument)
    {
        return array(
            'post'  => $contentDocument,
        );
    }

    /**
     * @Route(
     *   name="make_homepage",
     *   pattern="/_cms/make_homepage/{id}",
     *   requirements={"id": ".+"}
     * )
     */
    public function makeHomepageAction($id)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();

        $site = $dm->find(null, '/cms');
        if (!$site) {
            throw $this->createNotFoundException('Could not find /cms document!');
        }

        $page = $dm->find(null, $id);

        $site->setHomepage($page);
        $dm->persist($page);
        $dm->flush();

        return $this->redirect($this->generateUrl('admin_acme_basiccms_page_edit', array(
            'id' => $page->getId()
        )));
    }

    /**
     * @Route(
     *   name="search",
     *   pattern="/_cms/search"
     * )
     * @Template()
     */
    public function searchAction(Request $request)
    {
        $query = $request->get('query');


        $dm = $this->get('doctrine_phpcr')->getManager();
        $qb = $dm->createQueryBuilder();
        $qb->fromDocument('Acme\BasicCmsBundle\Document\Post', 'p')
            ->where()
                ->orX()
                    ->fullTextSearch('p.title', $query)
                    ->fullTextSearch('p.content', $query)
                ->end()
            ->end();
            // if you have jackrabbit ..
            // ->orderBy()
            //     ->desc()
            //         ->fullTextSearchScore('p')
            //     ->field
            // ->end();

        $results = $qb->getQuery()->execute();

        return array(
            'results' => $results,
            'query' => $query,
        );
    }
}
