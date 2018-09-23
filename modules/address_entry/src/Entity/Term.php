<?php
/**
 * @file
 * Contains \Drupal\content_entity_example\Entity\ContentEntityExample.
 */

namespace Drupal\address_entry\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\EntityChangedTrait;

/**
 * Defines the ContentEntityExample entity.
 *
 * @ingroup address_entry
 *
 *
 * @ContentEntityType(
 *   id = "address_term",
 *   label = @Translation("address_entry Term entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\address_entry\Entity\Controller\TermListBuilder",
 *     "form" = {
 *       "add" = "Drupal\address_entry\Form\TermForm",
 *       "edit" = "Drupal\address_entry\Form\TermForm",
 *       "delete" = "Drupal\address_entry\Form\TermDeleteForm",
 *     },
 *     "access" = "Drupal\address_entry\TermAccessControlHandler",
 *   },
 *   list_cache_contexts = { "user" },
 *   base_table = "address_term",
 *   admin_permission = "administer address_term entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "name" = "name",
 *     "email" = "email",
 *     "phone" = "phone",
 *     "birth_date" = "birth_date",
 *   },
 *   links = {
 *     "canonical" = "/address_term/{address_term}",
 *     "edit-form" = "/address_term/{address_term}/edit",
 *     "delete-form" = "/address_term/{address_term}/delete",
 *     "collection" = "/address_term/manage"
 *   },
 *   field_ui_base_route = "entity.address.term_settings",
 * )
 */
class Term extends ContentEntityBase {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   *
   * When a new entity instance is added, set the user_id entity reference to
   * the current user as the creator of the instance.
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    // Default author to current user.
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   *
   * Define the field properties here.
   *
   * Field name, type and size determine the table structure.
   *
   * In addition, we can define how the field and its content can be manipulated
   * in the GUI. The behaviour of the widgets used can be determined here.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
        ->setLabel(t('ID'))
        ->setDescription(t('The ID of the Term entity.'))
        ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
        ->setLabel(t('UUID'))
        ->setDescription(t('The UUID of the Contact entity.'))
        ->setReadOnly(TRUE);

    // Name field for the address.
    // We set display options for the view as well as the form.
    // Users with correct privileges can change the view and edit configuration.
    $fields['name'] = BaseFieldDefinition::create('string')
        ->setLabel(t('Name'))
        ->setSettings(array(
            'default_value' => '',
            'max_length' => 255,
            'text_processing' => 0,
        ))
        ->setDisplayOptions('view', array(
            'label' => 'above',
            'type' => 'string',
            'weight' => -6,
        ))
        ->setDisplayOptions('form', array(
            'type' => 'string_textfield',
            'weight' => -6,
        ))
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

      $fields['email'] = BaseFieldDefinition::create('email')
          ->setLabel(t('Email'))
          ->setSettings(array(
              'max_length' => 50,
              'text_processing' => 0,
          ))
          ->setDefaultValue('')
          ->setDisplayOptions('view', array(
              'label' => 'above',
              'type' => 'string',
              'weight' => -5,
          ))
          ->setDisplayOptions('form', array(
              'type' => 'email_default',
              'weight' => -5,
          ))
          ->setDisplayConfigurable('form', TRUE)
          ->setDisplayConfigurable('view', TRUE);

      $fields['phone'] = BaseFieldDefinition::create('string')
          ->setLabel(t('Phone'))
          ->setSettings(array(
              'default_value' => '',
              'max_length' => 255,
              'text_processing' => 0,
          ))
          ->setDisplayOptions('view', array(
              'label' => 'above',
              'type' => 'string',
              'weight' => -4,
          ))
          ->setDisplayOptions('form', array(
              'type' => 'string_textfield',
              'weight' => -4,
          ))
          ->setDisplayConfigurable('form', TRUE)
          ->setDisplayConfigurable('view', TRUE);


      $fields['birth_date'] = BaseFieldDefinition::create('datetime')
          ->setLabel(t('Date of birth'))
          ->setRevisionable(TRUE)
          ->setSettings([
              'datetime_type' => 'date'
          ])
          ->setDefaultValue('')
          ->setDisplayOptions('view', [
              'label' => 'above',
              'type' => 'datetime_default',
              'settings' => [
                  'format_type' => 'medium',
              ],
              'weight' => -2,
          ])
          ->setDisplayOptions('form', [
              'type' => 'datetime_default',
              'weight' => -2,
          ])
          ->setDisplayConfigurable('form', TRUE)
          ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

    /**
     * {@inheritdoc}
     */
    public function postSave(EntityStorageInterface $storage, $update = TRUE)
    {
        parent::postSave($storage, $update);

        // Reindex the entity when it is updated. The entity is automatically
        // indexed when it is added, simply by being added to the {contact} table.
        // Only required if using the core search index.
        if ($update) {
            if (\Drupal::moduleHandler()->moduleExists('search')) {
                search_mark_for_reindex('address_entry_search', $this->id());
            }
        }
    }
}
