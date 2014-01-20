<?php

Route::any('bench', function(){
		return Config::get('pm::app.abc');
	});

?>