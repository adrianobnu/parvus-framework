<?php
	namespace Parvus;

	class Redirect
	{

		public final static function to ($prURL = NULL)
		{
			header('location: '.url.$prURL);
			exit;
		}

	}