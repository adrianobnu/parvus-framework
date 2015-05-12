<?php
    namespace Parvus;

    class Input
    {

        public final static function get ($prName,$prValue = NULL)
        {
            return $_REQUEST[$prName] ? $_REQUEST[$prName] : $prValue;
        }
        
        public final static function file ($prName)
		{
			return $_FILES[$prName];
		}

    }
