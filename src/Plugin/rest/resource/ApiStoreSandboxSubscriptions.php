<?php
namespace Drupal\api_store\Plugin\rest\resource;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Provides a ApiStoreSubscriptions Types Resource
 *
 * @RestResource(
 *   id = "sandbox_subscriptions",
 *   label = @Translation("ApiStoreSandboxSubscriptions"),
 *   uri_paths = {
 *     "canonical" = "/api_store/sandbox_subscriptions"
 *   }
 * )
 */
class ApiStoreSandboxSubscriptions extends ResourceBase {
  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\JsonResponse
   */
  public function get() {
    $http_client = \Drupal::httpClient();
    $current_user = \Drupal::currentUser();
    $user = \Drupal\user\Entity\User::load($current_user->id());
    $email = $user->getEmail();
    if (!isset($_GET['lang']) ||  $_GET['lang'] !== 'fr') {
      $lang = 'en';
    } else {
      $lang = 'fr';
    }
    $config = \Drupal::config('api_store.settings');
    $sandbox_subscriptions_endpoint = $config->get('sandbox_subscriptions_endpoint');
    $res = $http_client->request('GET', $sandbox_subscriptions_endpoint, [
        'query' => [
            'lang' => $lang,
            'email' => $email
        ]
    ]);
    $output = $res->getBody();
    return new JsonResponse( json_decode($output) );
  }
}