<?php include("inc/header.php"); ?>

	<h1>Plugin <i class="icon-pushpin"></i> - Magrathea Image</h1>
	<p>

	</p>
	<h3>Database</h3>
	<p>This plugin requires a specific table:
		<pre class="prettyprint linenums">
CREATE TABLE `magrathea_images` (
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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
		</pre>
    <br/>
    And it requires as well the triggers:
    <pre class="prettyprint linenums">
CREATE TRIGGER magrathea_images_create BEFORE INSERT ON `magrathea_images` FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();
CREATE TRIGGER magrathea_images_update BEFORE UPDATE ON `magrathea_images` FOR EACH ROW SET NEW.updated_at = NOW();
    </pre>
	</p>


<?php include("inc/footer.php"); ?>