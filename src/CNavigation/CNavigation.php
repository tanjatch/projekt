<?php

class CNavigation {

public static function GenerateMenu($menu) {

if(isset($menu['callback_selected'])) {
$class = $menu['class'];
$html = "<nav>\n<ul class='$class'>\n";

foreach($menu['items'] as $item) {

$selectedUrl = call_user_func($menu['callback_selected'], $item['url']);

if ($selectedUrl == $item['url']){
$html .= "<li class = 'selected'><a href='{$item['url']}' title='{$item['title']}'>{$item['text']}</a></li>\n";
}
else{
$html .= "<li><a href='{$item['url']}' title='{$item['title']}'>{$item['text']}</a></li>\n";
}	
}
$html .= "</ul>\n</nav>";
return $html;
}
}
}