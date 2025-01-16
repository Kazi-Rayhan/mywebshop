<?php

use App\Models\Language;

$langs = Language::all();
$output = array();

foreach($langs as $lang){
	$output[$lang->key] = $lang->danish;
}
return $output;