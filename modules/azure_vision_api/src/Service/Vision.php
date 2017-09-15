<?php

namespace Drupal\azure_vision_api\Service;

use Drupal\azure_cognitive_services_api\Service\Client;
use Drupal\Core\Config\ConfigFactory;

class Vision {

  const API_URL = '/vision/v1.0/';

  /**
   * Constructor for the Vision API class.
   */
  public function __construct(ConfigFactory $config_factory) {
    $this->client = new Client($config_factory, 'vision');
  }

  // See https://westus.dev.cognitive.microsoft.com/docs/services/56f91f2d778daf23d8ec6739/operations/56f91f2e778daf14a499e1ff
  public function analyze() {}
  public function describe() {}
  public function generateThumbnail() {}
  public function ocr() {}
  public function models() {}
  public function recognizeText() {}
  public function tag() {}

}
