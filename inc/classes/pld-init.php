<?php

if(!class_exists('PLD_Init')) {
    class PLD_Init
    {
        function __construct()
        {
            add_action('init', array($this,'pld_init'));
        }

        function pld_init()
        {
            /**
             * Fires when Init hook is fired through plugin
             *
             * @since 1.0.0
             */
            do_action('pld_init');
        }
    }

    new PLD_Init();
}