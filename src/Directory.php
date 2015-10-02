<?php
	namespace Parvus;

	class Directory
	{

        /**
         * Creates a directory
         * @param $prDirectory
         * @param int $prPermission
         */
        public final static function create ($prDirectory,$prPermission = 0775)
        {

            foreach ($prDirectory as $directoryTMP)
            {

                $tmp = NULL;

                foreach (explode('/',$directoryTMP) as $subdirectory)
                {

                    $tmp .= $subdirectory.'/';

                    if (!is_dir($tmp))
                    {
                        mkdir($tmp,$prPermission,true);
                    }

                    if (strpos(PHP_OS,'WIN') === false)
                    {
                        chmod($tmp,$prPermission);
                    }

                }

            }

        }

	}