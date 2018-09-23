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
      $query_birth_date = db_query("SELECT name FROM {address_term} WHERE DATE_FORMAT(birth_date, '%m-%d') = DATE_FORMAT(NOW(),'%m-%d')")->fetchAll();
      $build = [];
      if (!empty($query_birth_date)) {
          $list_name = '';
          foreach ($query_birth_date as $k => $val) {
              $list_name .= ($k !== count($query_birth_date) - 1) ? $val->name.", ":$val->name."";
          }
          $build['today_birthday_block']['#markup'] = "Today is Birthday: ".$list_name;
      }else {
          $build['today_birthday_block']['#markup'] = "Today is Birthday: not persons";
      }

      return $build;
  }
}
