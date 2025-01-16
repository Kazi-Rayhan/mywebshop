<?php

use App\Models\Language;
use Illuminate\Support\Facades\Cache;

$langs =  Cache::remember('lang', 900, function () {
	return Language::all();
});
$output = array();

foreach ($langs as $lang) {
	$output[$lang->key] = $lang->spanish;
}
return $output;
