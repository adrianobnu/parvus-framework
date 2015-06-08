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

			$aFile = $_FILES[$prName];

			$aFile['extension'] = strToLower(pathinfo($aFile['name'], PATHINFO_EXTENSION));

			return $aFile;
		}

    }
