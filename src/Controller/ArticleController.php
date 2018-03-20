<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\Tests\Serializer\SerializableClass;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;


class ArticleController
{

    public function showArticle(SerializerInterface $serializer)
    {
        $article = new Article();
        $article
            ->setTitle('Mon premier article')
            ->setContent('Le contenu de mon article.')
        ;
        $data = $serializer->serialize($article, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    public function createArticle(SerializerInterface $serializer,EntityManagerInterface $entityManager, Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->getContent();
            $article = $serializer->deserialize($data, 'App\Entity\Article', 'json');


            $entityManager->persist($article);
            $entityManager->flush();

            return new Response('', Response::HTTP_CREATED);
        }
    }

}
