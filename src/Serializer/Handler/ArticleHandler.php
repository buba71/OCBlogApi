<?php

namespace App\Serializer\Handler;

use App\Entity\Article;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\JsonSerializationVisitor;

class ArticleHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'App\Entity\Article',
                'method' => 'serialize',

            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => 'AppBundle\Entity\Article',
                'method' => 'deserialize',

            ]
        ];
    }

    public function serialize(JsonSerializationVisitor $visitor, Article $article, array $type, Context $context)
    {
        $date = new \DateTime();

        $data =
            [
                'title'        => $article->getTitle(),
                'content'      => $article->getContent(),
                'delivered_at' => $date->format('l jS \of F Y h:i:s A')
            ];

        return $visitor->visitArray($data, $type, $context);

    }

    public function deserialize(JsonDeserializationVisitor $visitor, $data)
    {
        return new Article($data);
    }
}