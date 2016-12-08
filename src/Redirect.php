<?php
	namespace Parvus;

	class Redirect
	{

        /**
         * @return mixed
         */
        public final static function withInput ()
        {

            unset ($_SESSION[PARVUS_FLASH_SESSION_NAME]);

            $_SESSION[PARVUS_FLASH_SESSION_NAME] = $_POST;

            return self::class;

        }

        /**
         * @param null $prURL
         */
		public final static function to ($prURL = NULL)
		{
			$url = str_replace(DIRECTORY_SEPARATOR,'/',url.$prURL);

			if (substr($url,-1) == '/')
			{
				$url = substr($url,0,-1);
			}

			header('location: '.$url);
			exit;
		}

        /**
         * 
         */
		public final static function back ()
		{
			
			header('location: '.$_SERVER['HTTP_REFERER']);
			exit;
			
		}

	}
