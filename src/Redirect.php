<?php
	namespace Parvus;

	class Redirect
	{

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

	}