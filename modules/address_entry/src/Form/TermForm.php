<?php
/**
 * @file
 * Contains \Drupal\address_entry\Form\TermForm.
 */

namespace Drupal\address_entry\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the content_entity_example entity edit forms.
 *
 * @ingroup content_entity_example
 */
class TermForm extends ContentEntityForm{

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\address_entry\Entity\Term */
//    var_dump($this->getFormId());
    $form = parent::buildForm($form, $form_state);
    $form['#prefix'] = "<div id=\"{$this->getFormId()}-wrapper\">";
    $form['#suffix'] = '</div>';

    $form['actions']['submit']['#ajax'] = [
      'wrapper' => $this->getFormId() . '-wrapper',
      'callback' => array($this, 'ajaxRebuildCallback'),
      'effect' => 'fade',
    ];
    return $form;
  }

    /**
     * Callback for ajax form submission.
     *
     * @param array $form
     *   An associative array containing the structure of the form.
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *   The current state of the form.
     *
     * @return array
     *   The rebuilt form.
     */
    public function ajaxRebuildCallback(array $form, FormStateInterface $form_state) {
        drupal_set_message(t('Entity was successfully created'));
        return $form;
    }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->getEntity();
    $entity->save();
  }

}
