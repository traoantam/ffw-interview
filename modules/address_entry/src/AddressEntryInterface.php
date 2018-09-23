<?php

namespace Drupal\address_entry;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a Contact entity.
 * @ingroup address_entry
 */
interface AddressEntryInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}

?>