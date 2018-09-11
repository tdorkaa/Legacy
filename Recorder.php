<?php

for ($seed = 4; $seed < 12; $seed++) {
    $content = shell_exec('php -r "require \'vendor/autoload.php\'; srand(' . $seed . '); require \'src/GameRunner.php\';"');
    file_put_contents('./Records/Seed_' . $seed, $content);
}
