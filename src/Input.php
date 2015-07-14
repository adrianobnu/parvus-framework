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

            if ($_FILES[$prName]['name'][0] == NULL)
            {
                return false;
            }

            $aItem = array();

            foreach (range(0,sizeOf($_FILES[$prName]['name']) - 1) as $x)
            {

                foreach (array('name','type','tmp_name','error','size') as $label)
                {

                    $aItem[$x][$label] = $_FILES[$prName][$label][$x];

                }

            }

            foreach ($aItem as $x => $aInfo)
            {

                /**
                 * Get the extension of the file
                 */
                $aItem[$x]['extension'] = strToLower(pathinfo($aInfo['name'], PATHINFO_EXTENSION));

                /**
                 * Convert the size
                 */
                $size = $aInfo['size'];

                $aItem[$x]['size'] = array (
                    'byte'	   => number_format($size, 2,'.',''),
                    'kilobyte' => number_format($size / 1024, 2,'.',''),
                    'megabyte' => number_format($size / 1048576, 2,'.',''),
                    'gigabyte' => number_format($size / 1073741824, 2,'.','')
                );

                /** Se for uma imagem */
                if (exif_imagetype($aInfo['tmp_name']) !== false)
                {

                    /** Recuper as dimensções */
                    $aSize = getimagesize ($aInfo['tmp_name']);

                    if ($aSize)
                    {

                        /** Incrementa o array com as dimensões */
                        $aItem[$x]['dimension'] = array (
                            'width'     => $aSize[0],
                            'height'    => $aSize[1]
                        );

                    }

                }

            }

			return sizeOf($aItem) > 0 ? $aItem : $aItem[0];
		}

	}
