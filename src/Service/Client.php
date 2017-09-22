<?php

namespace Drupal\azure_cognitive_services_api\Service;

use Drupal\Core\Config\ConfigFactory;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

/**
 *
 */
class Client {

  const API_BASE_URL = '.api.cognitive.microsoft.com';

  /**
   * Create the Azure Cognitive Services client.
   */
  public function __construct(ConfigFactory $config_factory, $service = 'face') {
    // Get the config.
    $config = $config_factory->get('azure_cognitive_services_api.settings');
    $this->subscriptionKey = $config->get($service . '_subscription_key');
    $this->azureApiUri = 'https://' . $config->get($service . '_azure_region') . self::API_BASE_URL;

    $this->guzzleClient = new GuzzleClient(
      [
        'base_uri' => $this->azureApiUri,
        'headers'  => [
          'Content-Type' => 'application/json',
          'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
        ],
      ]
    );
  }

  /**
   *
   */
  public function doRequest($uri, $method = 'GET', $body = []) {
    try {
      $response = $this->guzzleClient->request(
        $method,
        $this->azureApiUri . $uri,
        [
          'json' => $body,
        ]
      );

      return json_decode($response->getBody(), TRUE);
    }
    catch (RequestException $e) {
      \Drupal::logger('azure_cognitive_services_api')->warning(
        "Azure Cognitive Services error code @code: @message",
        [
          '@code' => $e->getCode(),
          '@message' => $e->getMessage(),
        ]
      );

      // TODO Should this service return FALSE or throw exception... hmm.
      return FALSE;
    }
  }

}
