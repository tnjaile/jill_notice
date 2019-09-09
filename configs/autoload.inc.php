<?php
/**
 *
 * @authors Your Name (you@example.org)
 * @date    2017-11-16 11:38:28
 * @version $Id$
 */
die(basename(dirname(__DIR__)));
spl_autoload_register(function ($_className) {

    // base directory for the namespace prefix
    if (substr($_className, -6) == 'Action') {
        //控制類
        require_once JILLNOTICE_DIR . '/action/' . $_className . '.class.php';
    } elseif (substr($_className, -5) == 'Model') {

        //model
        require_once JILLNOTICE_DIR . '/model/' . $_className . '.class.php';
    } elseif (substr($_className, -5) == 'Check') {
        //Check(驗證類)
        require_once JILLNOTICE_DIR . '/check/' . $_className . '.class.php';
    } else {
        $publicDir = dirname(__DIR__) . '/public/';
        $file      = $publicDir . $_className . '.class.php';
        if (file_exists($file)) {
            //公共類
            require_once JILLNOTICE_DIR . '/public/' . $_className . '.class.php';
        }
    }

});
