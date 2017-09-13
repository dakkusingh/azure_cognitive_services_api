<?php

namespace Drupal\azure_cognitive_services_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Admin form for Azure Cognitive Services API settings.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'azure_cognitive_services_api_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'azure_cognitive_services_api.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormTitle() {
    return 'Azure Cognitive Services API Settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('azure_cognitive_services_api.settings');

    $form['subscription_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Token'),
      '#description' => $this->t('Cognitive Services Subscription Key to use.'),
      '#default_value' => $config->get('subscription_key'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('azure_cognitive_services_api.settings')
      ->set('subscription_key', $form_state->getValue('subscription_key'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
