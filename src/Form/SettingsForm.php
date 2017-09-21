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
    $this->config = $this->config('azure_cognitive_services_api.settings');

    $form['azure_cognitive_services_api'] = [
      '#type' => 'vertical_tabs',
    ];

    $modules = self::listModules();
    if (!empty($modules)) {
      foreach ($modules as $key => $value) {
        $form += self::getFormElements($key, $value);
      }
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('azure_cognitive_services_api.settings');

    $modules = self::listModules();
    if (!empty($modules)) {
      foreach ($modules as $key => $value) {
        $subKey = $key . '_subscription_key';
        $azureRegion = $key . '_azure_region';
        $config->set($subKey, $form_state->getValue($subKey));
        $config->set($azureRegion, $form_state->getValue($azureRegion));
      }
    }

    $config->save();
    parent::submitForm($form, $form_state);
  }

  private function getRegions() {
    return [
      'westus' => 'West US',
      'eastus2' => 'East US 2',
      'westcentralus' => 'West Central US',
      'westeurope' => 'West Europe',
      'southeastasia' => 'Southeast Asia'
    ];
  }

  public function getFormElements($key, $value) {
    $subKey = $key . '_subscription_key';
    $azureRegion = $key . '_azure_region';

    $formElements[$key] = [
      '#type' => 'details',
      '#title' => $this->t($value),
      '#group' => 'azure_cognitive_services_api',
    ];

    $formElements[$key][$subKey] = [
      '#type' => 'textfield',
      '#title' => $this->t('Ocp Apim Subscription Key'),
      '#description' => $this->t('Cognitive Services Subscription Key to use.'),
      '#default_value' => $this->config->get($subKey),
    ];

    $formElements[$key][$azureRegion] = [
      '#type' => 'select',
      '#title' => $this->t('Select Microsoft Azure Region'),
      '#description' => $this->t('Select Microsoft Azure Region to use for Cognitive Services API calls.'),
      '#default_value' => $this->config->get($azureRegion),
      '#options' => self::getRegions(),
    ];

    return $formElements;
  }

  private function listModules() {
    $modules = [];
    if (\Drupal::moduleHandler()->moduleExists('azure_emotion_api')) {
      $modules['emotion'] = 'Emotion';
    }
    if (\Drupal::moduleHandler()->moduleExists('azure_face_api')) {
      $modules['face'] = 'Face';
    }
    if (\Drupal::moduleHandler()->moduleExists('azure_vision_api')) {
      $modules['vision'] = 'Vision';
    }

    return $modules;
  }

}
