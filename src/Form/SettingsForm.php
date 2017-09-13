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

    $tabs = self::getTabs();

    $form['vision'] = [
      '#type' => 'vertical_tabs',
      '#default_tab' => 'edit-publication',
    ];

    foreach ($tabs as $key => $value) {
      $subKey = $key . '_subscription_key';
      $azureRegion = $key . '_azure_region';

      $form[$key] = [
        '#type' => 'details',
        '#title' => $this->t($value),
        '#group' => 'vision',
      ];

      $form[$key][$subKey] = [
        '#type' => 'textfield',
        '#title' => $this->t('Ocp Apim Subscription Key'),
        '#description' => $this->t('Cognitive Services Subscription Key to use.'),
        '#default_value' => $config->get($subKey),
      ];

      $form[$key][$azureRegion] = [
        '#type' => 'select',
        '#title' => $this->t('Select Microsoft Azure Region'),
        '#description' => $this->t('Select Microsoft Azure Region to use for Cognitive Services API calls.'),
        '#default_value' => $config->get($azureRegion),
        '#options' => self::getRegions(),
      ];
    }

    //$foo2 = \Drupal::service('azure_cognitive_services_api.faces_api')->detect('http://www.hairstylestyle.com/i/Salma-Hayek-Hairstyle.jpg');
    //ksm($foo2);
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('azure_cognitive_services_api.settings');

    $tabs = self::getTabs();

    foreach ($tabs as $key => $value) {
      $subKey = $key . '_subscription_key';
      $azureRegion = $key . '_azure_region';
      $config->set($subKey, $form_state->getValue($subKey));
      $config->set($azureRegion, $form_state->getValue($azureRegion));
    }

    $config->save();

    parent::submitForm($form, $form_state);
  }

  private function getTabs() {
    return [
      'faces' => 'Faces',
      'emotions' => 'Emotions',
      'computervision' => 'Computer Vision',
      'contentmoderation' => 'Content Moderation',
    ];
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
}
