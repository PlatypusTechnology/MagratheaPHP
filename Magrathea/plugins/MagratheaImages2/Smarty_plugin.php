<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     MagratheaImage
 * Purpose:  MagratheaImages
 * -------------------------------------------------------------
 */
global $Smarty;
$Smarty->registerPlugin("function", "magratheaimage_code", "Smarty_MagratheaImage_Code");
$Smarty->registerPlugin("function", "magratheaimage_url", "Smarty_MagratheaImage_Url");

function Smarty_MagreatheaImage($params){
        $id = $params["id"];
        if(empty($id)){
                echo "Error in the image call - Magrathea Image";
                return null;
        }
        $width = isset($params["width"]) ? $params["width"] : null;
        $height = isset($params["height"]) ? $params["height"] : null;
        $m_image = new MagratheaImage($id);
        $m_image = $m_image->Load();
        if( $width && $height ){
                $m_image = $m_image->FixedSize($width, $height);
        } else if($width) {
                $m_image = $m_image->FixedWidth($width);
        } else if($height) {
                $m_image = $m_image->FixedHeight($height);
        }
        if(isset($params["style"])){
                $m_image = $m_image->Style($params["style"]);
        }
        if(isset($params["class"])){
                $m_image = $m_image->setClass($params["class"]);
        }
        return $m_image;
}

function Smarty_MagratheaImage_Url($params, $smarty){
        $m_image = Smarty_MagreatheaImage($params);
        return $m_image->Url();
}

function Smarty_MagratheaImage_Code($params, $smarty){
        $m_image = Smarty_MagreatheaImage($params);
        return $m_image->Code($params["title"]);
}

?>
