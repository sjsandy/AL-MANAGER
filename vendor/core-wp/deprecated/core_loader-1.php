<?php

/**
 *
 * @param string $className Class or Interface name automatically
 *              passed to this function by the PHP Interpreter
 */



function core_autoLoader($className) {
    //Directories added here must be
//relative to the script going to use this file.
//New entries can be added to this list
    $directories = array(
        '',
        'classes/',
        'core-wp/',
        'include/',
        'includes/'
    );


    //Add your file naming formats here
    $fileNameFormats = array(
        '%s.php',
        '%s.class.php',
        'class.%s.php',
        '%s.inc.php'
    );

    // this is to take care of the PEAR style of naming classes
    $path = str_ireplace('_', '/', $className);
    if (@include_once $path . '.php') {
        return;
    }

    foreach ($directories as $directory) {
        foreach ($fileNameFormats as $fileNameFormat) {
            $path = $directory . sprintf($fileNameFormat, $className);
            if (file_exists($path)) {
                include_once $path;
                return;
            }
        }
    }
}

spl_autoload_register('core_autoLoader');