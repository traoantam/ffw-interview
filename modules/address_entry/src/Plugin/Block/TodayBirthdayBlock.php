<?php

namespace Drupal\address_entry\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Today Birthdays From' Block
 *
 * @Block(
 *   id = "today_birthday_block",
 *   admin_label = @Translation("Today's birthdays"),
 * )
 */
class TodayBirthdayBlock extends BlockBase {
  /**
  * {@inheritdoc}
  */
  public function build() {
      $build = [];
      $build['mydata_block']['#markup'] = 'Today\'s birthday';
      return $build;
  }
}
