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

			/**
			 * Get the extension of the file
			 */
			$aFile['extension'] = strToLower(pathinfo($aFile['name'], PATHINFO_EXTENSION));

			/**
			 * Convert the size
			 */
			$aFile['size'] = array (
				'byte'	   => $aFile['size'],
				'kilobyte' => $aFile['size'] * 1024,
				'megabyte' => $aFile['size'] * 2048,
				'gigabyte' => $aFile['size'] * 4096
			);

			return $aFile;
		}

    }
