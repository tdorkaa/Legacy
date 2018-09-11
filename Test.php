<?php

for ($seed = 4; $seed < 12; $seed++) {
    $content = shell_exec('php -r "srand(' . $seed . '); require \'GameRunner.php\';"');
    if ($content !== file_get_contents('./Records/Seed_' . $seed)) {
        echo 'X';
    } else {
        echo '.';
    }
}
echo PHP_EOL;