<?php
/**
 * Created by PhpStorm.
 * User: Johann
 * Date: 29/03/14
 * Time: 17:19
 */

namespace Acme\DemoBundle\Model;

/**
 * @JMS\Serializer\Annotation\XmlRoot("user")
 * @Hateoas\Configuration\Annotation\Relation("self", href = "expr('/users/' ~ object.getId())")
 * @Hateoas\Configuration\Annotation\Relation("comments", href = "expr('/users/' ~ object.getId() ~ '/comments')")
 * @Hateoas\Configuration\Annotation\Relation("type", href = "expr('/profile/' ~ object.getType())")
 */
class User {

} 