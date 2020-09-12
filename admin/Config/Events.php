<?php namespace Config;

use CodeIgniter\Events\Events;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', function () {
    if (ENVIRONMENT !== 'testing') {
        while (\ob_get_level() > 0) {
            \ob_end_flush();
        }

        \ob_start(function ($buffer) {
            return $buffer;
        });
    }

    // Fetch Events from DB
    $events_model = new \Admin\Models\Setting\Events();
    $results = $events_model->where(['status' => 1])->findAll();
    foreach ($results as $result) {
        if ((substr($result['action'], 0, 6) == 'Admin\\')) {
            if ($result['priority'] != 0) {
                Events::on($result['code'], $result['action'], $result['priority']);
            } else {
                Events::on($result['code'], $result['action']);
            }
        }
    }

    /*
     * --------------------------------------------------------------------
     * Debug Toolbar Listeners.
     * --------------------------------------------------------------------
     * If you delete, they will no longer be collected.
     */
    if (ENVIRONMENT !== 'production') {
        Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
        Services::toolbar()->respond();
    }
});
