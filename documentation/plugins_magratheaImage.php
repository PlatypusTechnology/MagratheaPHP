<?php include("inc/header.php"); ?>

<div class="container main_container">
  <h1>Plugin MagratheaImages2</h1>
  <h3>Database</h3>
  <p>
    This plugin requires a database that can be installed from the plugins page:<br/>
    <textarea style="width: 100%; height: 200px;">--
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
    </textarea>
  </p>
  <h3>Config</h3>
  <p>
    It will be necessary to set some configurations for the path of images.<br/> 
    To do so, just edit the <em><b>plugins/MagratheaImages2/config/MagratheaImages.conf</em></b> file, setting the environment that is being used.
  </p>

  <h3>Magrathea Image Model:</h3>
  <p>
    Functions:
    <ul>
      <li><b>SilentLoad()</b>: Load image</li>
      <li><b>Load()</b>: Load image options and return object itself</li>
      <li><b>Thumb()</b>: Builds thumb image with the predefined thumb size</li>
      <li><b>FixedSize($w, $h)</b>: Sets a fixed size for the image<br/>
        <i>In case of portrait image</i>: image will be sliced in the bottom, keeping the top<br/>
        <i>In case of landscape</i>: image will be sliced in the sides, keeping the center</li>
      <li><b>FixedWidth($w)</b>: Sets a fixed width for the image. The height will differ, respecting the dimensions</li>
      <li><b>FixedHeight($h)</b>: Sets a fixed height for the image. The width will differ, respecting the dimensions</li>
      <li><b>MaxSize($w, $h)</b>: Sets a maximum size for the image. If one of the sides exceeds expected dimension, image will be sliced</li>
      <li><b>MaxWidth($w)</b>: Sets a maximum width for the image. Height can be of any size, once width does not exceed this one</li>
      <li><b>MaxHeight($h)</b>: Sets a maximum height for the image. Width can be of any size, once height does not exceed this one</li>
      <li><b>Url()</b>: Creates image following required parameters and returns url</li>
      <li><b>Code($title="", $moreAttr=null)</b>: generates a HTML code for the image and returns it</li>
      <li><b>otherAttr($attr)</b>: set other attributes for the &lt;img html tag</li>
      <li><b>Style($st)</b>: sets style for the img code</li>
      <li><b>SetClass($cl)</b>: sets class for the img code</li>
      <li><b>LoadConfig()</b>: Load general configurations for image</li>
      <li><b>GetUrl()</b>: Gets image url</li>
      <li><b>GetImagePath()</b>: Get Images Path</li>
      <li><b>GetWidthHeight()</b>: Sets the width and height from the image</li>
      <li><b>SetFilename($name)</b>: Sets filename for image</li>
      <li><b>Insert()</b>: Inserts image</li>
      <li><b>GetFileNameWithoutExtension()</b></li>
    </ul>
  </p>

  <h3>Uploads</h3>
  <p>
    To upload images, just call plugins/MagratheaImages2/Control/upload_image.php.<br/>
    The property that will be searched will be <em>$_POST["file"]</em>...
  </p>

  <h3>Smarty</h3>
  <p>
    <ul>
      <li>
        <b>magratheaimage_code</b>:<br/>
        Prints magrathea image HTML code:<br/>
        (title, width, height and style are optional parameters.)
        <pre>{magratheaimage_code title="image name" id="42" width="300" height="200" style="padding-top: 10px" class="img"}</pre>
      </li>
      <li>
        <b>magratheaimage_url</b>:<br/>
        Prints magrathea image direct url:<br/>
        (width and height are optional parameters.)
        <pre>{magratheaimage_url id="42" width="300" height="200"}</pre>
      </li>
    </ul>
  </p>

</div>

<?php include("inc/footer.php"); ?>