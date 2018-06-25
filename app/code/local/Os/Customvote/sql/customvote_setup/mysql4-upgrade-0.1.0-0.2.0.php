<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('custom_question')};
CREATE TABLE {$this->getTable('custom_question')} (
  `question_id` int(11) unsigned NOT NULL auto_increment,
  `title` text NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('custom_answer')};
CREATE TABLE {$this->getTable('custom_answer')} (
  `answer_id` int(11) unsigned NOT NULL auto_increment,
  `question_id` int(11) unsigned NOT NULL,
  `title` text NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`answer_id`),
  CONSTRAINT `FK_multi_ANSWER_ITEM` FOREIGN KEY (`question_id`) REFERENCES `{$this->getTable('custom_question')}` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 