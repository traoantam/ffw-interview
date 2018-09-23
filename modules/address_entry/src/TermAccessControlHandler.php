<?php

/**
 * @file
 * Contains \Drupal\content_entity_example\ContactAccessControlHandler.
 */

namespace Drupal\address_entry;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Access controller for the term entity.
 *
 * @see \Drupal\address_entry\Entity\Term.
 */
class TermAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   *
   * Link the activities to the permissions. checkAccess is called with the
   * $operation as defined in the routing.yml file.
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view address_term entity');

      case 'edit':
        return AccessResult::allowedIfHasPermission($account, 'edit address_term entity');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete address_term entity');
    }
    return AccessResult::allowed();
  }

  /**
   * {@inheritdoc}
   *
   * Separate from the checkAccess because the entity does not yet exist, it
   * will be created during the 'add' process.
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add address_term entity');
  }

}
