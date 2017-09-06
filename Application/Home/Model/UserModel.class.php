<?php

namespace Home\Model;
use Think\Model\RelationModel;

class UserModel extends RelationModel{
  protected $_link = array(
    'plan_content' => array(
      'mapping_type' => self::HAS_MANY,
      'class_name' => 'plan_content',
      'foreign_key' => 'uid',
      'mapping_fields' => 'morning,afternoon,night,create_time',
      'as_fields' => 'morning,afternoon,night,create_time',
    ),
  );
}


  ?>
