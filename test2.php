<?php
echo file_get_contents('storage/logs/laravel.log', false, null, filesize('storage/logs/laravel.log') - 3000);
