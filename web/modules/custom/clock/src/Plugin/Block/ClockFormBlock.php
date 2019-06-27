<?php
namespace Drupal\clock\Plugin\Block;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\file\Entity\File;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "clock_form_block",
 *   admin_label = @Translation("Clock Form block"),
 *   category = @Translation("Clock Form"),
 * )
 */
class ClockFormBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $utcOffset = $config['utcOffset'];
    print_r($utcOffset);
    $image = $config['image'];
    $file = File::load($image[0]);
    $imageurl = $file->getFileUri();
    print_r($imageurl);   
    $app = \Drupal::config('clock.settings');
    $app = $app->get('app');
    $service = \Drupal::service('clock.test_service');
    $ress = $service->ClockMethod($config['utcOffset']);
    $result = Json::decode($ress);
    print_r($result);
    $description = $config['description']['value'];
    // $description = $desc['value'];
    print_r($description);
    
    $utcOffset = $this->t((string) $result['main']['utcOffset']);
    $dayOfTheWeek = $this->t((string) $result['main']['dayOfTheWeek']);
    $ordinalDate = $this->t((string) $result['main']['ordinalDate']);
    
    return [
      '#theme' => 'clock',
      '#city' => $city,
      '#image' => $imageurl,
      '#description' => $description,
      '#utcOffset' =>  $utcOffset,
      '#dayOfTheWeek'  =>  $dayOfTheWeek,
      '#ordinalDate'   =>  $ordinalDate,
    ];    
  }
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }
  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();
    $form['city'] = [
      '#type' => 'textfield',
      '#title' => t('City'),
      '#description' => t('Enter the city'),
      '#default_value' => 'City'
    ];
    $form['description'] = [
        '#type' => 'text_format',
        '#title' => t('Description'),
        '#description' => t('This is the description'),
        '#format' => 'full_html',
        '#rows' => 50,
        '#default_value' => ''
    ];
    $form['image'] = [
      '#type' => 'managed_file',
      '#upload_location' => 'public://upload/hello',
      '#title' => t('Image'),
      '#upload_validators' => [
          'file_validate_extensions' => ['jpg', 'jpeg', 'png', 'gif']
      ],
      '#default_value' => isset($this->configuration['image']) ? $this->configuration['image'] : '',
      '#description' => t('The image to display'),
      '#required' => true
    ];
    return $form;
    
  }
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // $abs = $form_state->getValue('description');
    // kint($abs['value']);
    // exit();
    $this->configuration['clock'] = $form_state->getValue('clock');
    
    $image = $form_state->getValue('image');
    $file = File::load( $image[0] );
    $file->setPermanent();
    $file->save();
    
    // Save configurations.
    $this->setConfigurationValue('city' , $form_state->getValue('city'));
    $this->setConfigurationValue('description' , $form_state->getValue('description'));
    $this->setConfigurationValue('image' , $form_state->getValue('image'));
  }
}