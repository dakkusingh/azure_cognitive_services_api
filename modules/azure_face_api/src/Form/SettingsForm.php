<?php

namespace Drupal\azure_face_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\azure_cognitive_services_api\Form\SettingsForm as AzureCognitiveServicesForm;

/**
 * Admin form for Azure Face API settings.
 */
class SettingsForm extends AzureCognitiveServicesForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $form += parent::getFormElements('face', 'Face');

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::configFactory()->getEditable('azure_cognitive_services_api.settings');

    $key = 'face';
    $subKey = $key . '_subscription_key';
    $azureRegion = $key . '_azure_region';

    $config->set($subKey, $form_state->getValue($subKey));
    $config->set($azureRegion, $form_state->getValue($azureRegion));

    $config->save();

    parent::submitForm($form, $form_state);
  }

}
