<?php

namespace Drupal\clock\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ClockForm extends ConfigFormBase {

  public function getFormId() {
    return 'clockform';
  }

  protected function getEditableConfigNames() {
    return [
      'clock.settings'
    ];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('clock.settings');

    $form['app'] = [
      '#type' => 'textfield',
      '#title' => $this->t('App'),
      '#description' => $this->t('Please Enter your full name'),
      '#default_value' => $config->get('app'),
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->config('clock.settings')
      ->set('app', $form_state->getValue('app'))
      ->save();
    parent::submitForm($form, $form_state);
  }
}
?>