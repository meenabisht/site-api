<?php

namespace Drupal\event;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a Contact entity.
 * @ingroup content_entity_example
 */
interface EventInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}

?>
