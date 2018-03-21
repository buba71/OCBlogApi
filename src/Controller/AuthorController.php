<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class AuthorController
{
    public function showAuthors(SerializerInterface $serializer, Author $author)
    {


        $data = $serializer->serialize($author, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/Json');

        return $response;
    }

    public function createAuthor(SerializerInterface $serializer, EntityManagerInterface $entityManager, Request $request)
    {
        $data = $request->getContent();


        $author = $serializer->deserialize($data, Author::class, 'json');
        $entityManager->persist($author);
        $entityManager->flush();

        return new Response(' ', Response::HTTP_CREATED);

    }
}


