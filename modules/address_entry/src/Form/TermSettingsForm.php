<?php
/**
 * @file
 * Contains \Drupal\address_entry\Form\TermSettingsForm.
 */

namespace Drupal\address_entry\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ContentEntityExampleSettingsForm.
 *
 * @package Drupal\address_entry\Form
 *
 * @ingroup address_entry
 */
class TermSettingsForm extends FormBase {
  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'address_term_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Empty implementation of the abstract submit class.
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['address_term_settings']['#markup'] = 'Settings form for address Term. Manage field settings here.';
    return $form;
  }

}
