<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class ArticleController
{

    public function showArticle(SerializerInterface $serializer, Article $article)
    {

        $data = $serializer->serialize($article, 'json', SerializationContext::create()->setGroups(array('detail')));

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

    public function listArticle(SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $listArticles = $entityManager->getRepository(Article::class)->findAll();
        $data = $serializer->serialize($listArticles, 'json', SerializationContext::create()->setGroups(array('list')));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/Json');

        return $response;
    }



}
