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
			$size = $aFile['size'];

			unset ($aFile['size']);

			$aFile['size'] = array (
				'byte'	   => number_format($size, 2,'.',''),
				'kilobyte' => number_format($size / 1024, 2,'.',''),
				'megabyte' => number_format($size / 1048576, 2,'.',''),
				'gigabyte' => number_format($size / 1073741824, 2,'.','')
			);

			return $aFile;
		}

	}
