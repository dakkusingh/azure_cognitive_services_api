<?php

namespace Drupal\azure_vision_api\Service;

use Drupal\azure_cognitive_services_api\Service\Client;
use Drupal\Core\Config\ConfigFactory;

/**
 *
 * @property \Drupal\Core\Config\Config|\Drupal\Core\Config\ImmutableConfig config
 */
class Vision {

  const API_URL = '/vision/v1.0/';

  /**
   * Constructor for the Vision API class.
   *
   * @param \Drupal\Core\Config\ConfigFactory $config_factory
   */
  public function __construct(ConfigFactory $config_factory) {
    $this->client = new Client($config_factory, 'vision');
    $this->config = $config_factory->get('azure_vision_api.settings');
  }

  /**
   * See https://westus.dev.cognitive.microsoft.com/docs/services/56f91f2d778daf23d8ec6739/operations/56f91f2e778daf14a499e1ff.
   *
   * @param $photoUrl
   * @param bool $visualFeatures
   * @param bool $details
   *
   * @return bool|mixed
   */
  public function analyze($photoUrl,
                          $visualFeatures = TRUE,
                          $details = TRUE
  ) {
    $uri = self::API_URL . 'analyze';
    $params = [];

    if ($details) {
      $allowedDetails = $this->config->get('allowed_details');
      $params['details'] = implode(',', $allowedDetails);
    }
    if ($visualFeatures) {
      $allowedVisualFeatures = $this->config->get('allowed_visual_features');
      $params['visualFeatures'] = implode(',', $allowedVisualFeatures);
    }

    if (count($params) > 0) {
      $queryString = http_build_query($params);
      $uri = urldecode($uri . '?' . $queryString);
    }

    $result = $this->client->doRequest($uri, 'POST', ['url' => $photoUrl]);

    return $result;
  }

  /**
   *
   */
  public function describe() {}

  /**
   *
   */
  public function generateThumbnail() {}

  /**
   *
   */
  public function ocr() {}

  /**
   *
   */
  public function models() {}

  /**
   *
   */
  public function recognizeText() {}

  /**
   *
   */
  public function tag() {}

}
