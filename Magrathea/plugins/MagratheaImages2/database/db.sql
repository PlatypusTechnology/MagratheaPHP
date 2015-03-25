
--
-- TABLES
-- 
DROP TABLE IF EXISTS `magrathea_images`;
-- TEST Comment
CREATE TABLE IF NOT EXISTS `magrathea_images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `filename` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `extension` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `file_type` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `size` bigint(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

--
-- Triggers `magrathea_images`
--
DROP TRIGGER IF EXISTS `magrathea_images_create`;
CREATE TRIGGER `magrathea_images_create` BEFORE INSERT ON `magrathea_images` 
FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();

DROP TRIGGER IF EXISTS `magrathea_images_update`;
CREATE TRIGGER `magrathea_images_update` BEFORE UPDATE ON `magrathea_images`
FOR EACH ROW SET NEW.updated_at = NOW();
