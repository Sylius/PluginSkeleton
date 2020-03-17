<?php

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    echo '> This system is running Windows, we shall try to create a link and if it fails then a junction:' . PHP_EOL;
    exec('mklink /D node_modules tests\\Application\\node_modules 2> NUL', $output, $returnCode);
    if ($returnCode !== 0) {
        echo '> Creation of Link failed; you can try with Admin privileges; trying to create a Junction:' . PHP_EOL;
        exec('mklink /J node_modules tests\\Application\\node_modules 2> NUL', $output, $returnCode);
    }

    if ($returnCode === 0) {
        echo "> Successfully created a Link/Junction." . PHP_EOL;
    } else {
        echo "> Failed with return code: " . $returnCode;
    }
} else {
    echo '> This is a server not running Windows, we shall try to use a Symlink' . PHP_EOL;
    passthru('ln -s tests/Application/node_modules node_modules');
}
