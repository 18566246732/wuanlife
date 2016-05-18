--
-- ���ݿ�: `wuan`
--

-- --------------------------------------------------------

--
-- ��Ľṹ `authorization`
--

CREATE TABLE IF NOT EXISTS `authorization` (
  `area_dif` varchar(2) COLLATE utf8_bin NOT NULL COMMENT 'Ȩ��λ������',
  `aser_dif` varchar(2) COLLATE utf8_bin NOT NULL COMMENT 'Ȩ������',
  `note` varchar(8) COLLATE utf8_bin NOT NULL COMMENT '˵��'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Ȩ�ޱ�';

--
-- ת����е����� `authorization`
--

INSERT INTO `authorization` (`area_dif`, `aser_dif`, `note`) VALUES
('01', '01', '�û�-��Ա'),
('01', '02', '�û�-����Ա'),
('01', '03', '�û�-�ܹ���'),
('02', '01', '����-������'),
('02', '02', '����-����'),
('02', '03', '����-��Ա');

-- --------------------------------------------------------

--
-- ��Ľṹ `group_base`
--

CREATE TABLE IF NOT EXISTS `group_base` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT COMMENT '��id',
  `name` varchar(11) CHARACTER SET gbk NOT NULL COMMENT '����',
  `delete` int(1) NOT NULL DEFAULT '0' COMMENT 'ɾ��',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='���' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- ��Ľṹ `group_detail`
--

CREATE TABLE IF NOT EXISTS `group_detail` (
  `group_base_id` int(4) unsigned NOT NULL COMMENT '��id',
  `user_base_id` int(5) unsigned NOT NULL COMMENT '��Աid',
  `authorization` varchar(2) COLLATE utf8_bin NOT NULL COMMENT 'Ȩ��'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='���Ա��';

-- --------------------------------------------------------

--
-- ��Ľṹ `post_base`
--

CREATE TABLE IF NOT EXISTS `post_base` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT COMMENT '����id',
  `user_base_id` int(5) unsigned NOT NULL COMMENT '������id',
  `group_base_id` int(4) unsigned NOT NULL COMMENT '��id',
  `title` varchar(30) CHARACTER SET gbk NOT NULL COMMENT '����',
  `digest` int(1) NOT NULL DEFAULT '0' COMMENT '����',
  `sticky` int(1) NOT NULL DEFAULT '0' COMMENT '�ö�',
  `delete` int(1) NOT NULL DEFAULT '0' COMMENT 'ɾ��',
  PRIMARY KEY (`id`),
  KEY `user_base_id` (`user_base_id`,`group_base_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='����' AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- ��Ľṹ `post_detail`
--

CREATE TABLE IF NOT EXISTS `post_detail` (
  `post_base_id` int(5) unsigned NOT NULL COMMENT '����id',
  `user_base_id` int(5) unsigned NOT NULL COMMENT '������id',
  `replyid` int(5) unsigned DEFAULT NULL COMMENT '�ظ���id',
  `text` varchar(140) COLLATE utf8_bin NOT NULL COMMENT '����',
  `floor` int(4) NOT NULL COMMENT '¥��',
  `createTime` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '����ʱ��',
  `delete` int(1) NOT NULL DEFAULT '0' COMMENT 'ɾ��',
  PRIMARY KEY (`post_base_id`,`floor`),
  KEY `user_base_id` (`user_base_id`,`replyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='�ظ���';

-- --------------------------------------------------------

--
-- ��Ľṹ `user_base`
--

CREATE TABLE IF NOT EXISTS `user_base` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '�û�id',
  `password` varchar(35) COLLATE utf8_bin NOT NULL COMMENT '����',
  `nickname` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '�ǳ�',
  `Email` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '����',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nickname` (`nickname`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='�û������' AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- ��Ľṹ `user_detail`
--

CREATE TABLE IF NOT EXISTS `user_detail` (
  `user_base_id` int(5) unsigned NOT NULL COMMENT '�û�id',
  `authorization` varchar(2) COLLATE utf8_bin NOT NULL COMMENT 'Ȩ��',
  `status` int(1) NOT NULL COMMENT '״̬',
  `lastLogTime` datetime NOT NULL COMMENT '�ϴε�¼',
  PRIMARY KEY (`user_base_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='�û�����';
