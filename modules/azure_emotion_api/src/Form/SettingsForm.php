<?php

namespace Drupal\azure_emotion_api\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\azure_cognitive_services_api\Form\SettingsForm as AzureCognitiveServicesForm;

/**
 * Admin form for Azure Emotion API settings.
 */
class SettingsForm extends AzureCognitiveServicesForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $form += parent::getFormElements('emotion', 'Emotion');
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::configFactory()->getEditable('azure_cognitive_services_api.settings');

    $key = 'emotion';
    $subKey = $key . '_subscription_key';
    $azureRegion = $key . '_azure_region';

    $config->set($subKey, $form_state->getValue($subKey));
    $config->set($azureRegion, $form_state->getValue($azureRegion));

    $config->save();

    parent::submitForm($form, $form_state);
  }

}
