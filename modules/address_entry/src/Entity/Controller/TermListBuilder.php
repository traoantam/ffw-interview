<?php

/**
 * @file
 * Contains \Drupal\address_entry\Entity\Controller\TermListBuilder.
 */

namespace Drupal\address_entry\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\address_entry\Form\TermForm;

/**
 * Provides a list controller for address_term entity.
 *
 * @ingroup address_entry
 */
class TermListBuilder extends EntityListBuilder {

  /**
   * The url generator.
   *
   * @var \Drupal\Core\Routing\UrlGeneratorInterface
   */
  protected $urlGenerator;


  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity.manager')->getStorage($entity_type->id()),
      $container->get('url_generator')
    );
  }

  /**
   * Constructs a new addressTermListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type term.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Routing\UrlGeneratorInterface $url_generator
   *   The url generator.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, UrlGeneratorInterface $url_generator) {
    parent::__construct($entity_type, $storage);
    $this->urlGenerator = $url_generator;
  }

  /**
   * {@inheritdoc}
   *
   * We override ::render() so that we can add our own content above the table.
   * parent::render() is where EntityListBuilder creates the table using our
   * buildHeader() and buildRow() implementations.
   */
  public function render() {
//    $entity = TermForm::class;
//    $form = \Drupal::formBuilder()->getForm($entity);
//    $form['search_address']['name'] = array(
//        '#type' => 'textfield',
//        '#title' => t('Name'),
//        '#default_value' => '',
//    );
//    $form['search_address']['submit'] = array(
//      '#type' => 'submit',
//      '#value' => t('Search'),
//      '#prefix' => '<div class="action">',
//      '#suffix' => '</div>',
//      '#weight' => 100,
//    );

    $build['table'] = parent::render();
    return $build;
  }

    /**
     * Loads entity IDs using a pager sorted by the entity id.
     */
    protected function getEntityIds() {
        $form_id = \Drupal::request()->get('form_id');

        if ($form_id && $form_id === 'address_term_add_form') {
            $query = \Drupal::entityQuery($this->entityTypeId);
            $text = \Drupal::request()->get('text');
            $query->condition('text', $text, 'CONTAINS');
            if ($this->limit) {
                $query->pager($this->limit);
            }
            $res = $query->execute();
        }
        else {
            $res = parent::getEntityIds();
        }
        return $res;
    }

  public function load() {
    $entity_query = \Drupal::service('entity.query')->get('address_term');
    $header = $this->buildHeader();
    $entity_query->pager(10);
    $entity_query->tableSort($header);
    $uids = $entity_query->execute();

    return $this->storage->loadMultiple($uids);
  }

  /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the address_term list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and inserts the 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['name'] = $this->t('Name');
    $header['email'] = $this->t('Email');
    $header['phone'] = $this->t('Phone');
    $header['birth_date'] = $this->t('Date of birth');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\address_entry\Entity\Term */
    $row['id'] = $entity->id();
    $row['name'] = $entity->name->value;
    $row['email'] = $entity->email->value;
    $row['phone'] = $entity->phone->value;
    $row['birth_date'] = $entity->birth_date->value;
    return $row + parent::buildRow($entity);
  }

}
