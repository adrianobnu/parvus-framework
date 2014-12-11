<?php
    namespace Parvus;

    class Input
    {

        public final static function get ($prName,$prValue = NULL)
        {
            return $_REQUEST[$prName] ? $_REQUEST[$prName] : $prValue;
        }

    }