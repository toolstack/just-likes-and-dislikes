<?php

if(!class_exists('JLAD_Init')) {
    class JLAD_Init
    {
        function __construct()
        {
            add_action('init', array($this,'jlad_init'));
        }

        function jlad_init()
        {
            /**
             * Fires when Init hook is fired through plugin
             *
             * @since 1.0.0
             */
            do_action('jlad_init');
        }
    }

    new JLAD_Init();
}