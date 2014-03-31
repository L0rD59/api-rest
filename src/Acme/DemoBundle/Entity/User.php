<?php

namespace Acme\DemoBundle\Entity;

use Doctrine\ORM;
/**
 * @JMS\Serializer\Annotation\XmlRoot("user")
 * @Hateoas\Configuration\Annotation\Relation("self", href = "expr('/users/' ~ object.getId())")
 * @Hateoas\Configuration\Annotation\Relation("comments", href = "expr('/users/' ~ object.getId() ~ '/comments')")
 * @Hateoas\Configuration\Annotation\Relation("type", href = "expr('/profile/' ~ object.getType())")
 *
 * @ORM\Mapping\Entity
 */
class User {
    /**
     * @ORM\Mapping\Id()
     * @ORM\Mapping\Column(type="integer")
     * @var
     */
    protected   $id;

    /**
     * @ORM\Mapping\Column(type="string")
     * @var
     */
    protected   $username;
} 