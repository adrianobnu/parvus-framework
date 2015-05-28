<?php
    namespace Parvus;

    class Database
    {

		private $args;

		/**
		 * Save the args
		 * @param $args
		 */
		public function __construct($args)
		{

			$this->args = $args;

		}

		/**
		 * Show help
		 */
		private function help()
		{

			echo "Utilização: php database migration\n";

		}

		/**
		 * Run the classe
		 */
		public function run()
		{

			if (count($this->args) <= 1)
			{
				$this->help();
			}
			else
			{
				switch ($this->args[1])
				{

					case "migrate" :
					{
						$this->migration();

						break;
					}

					case "help"		:
					case "--help"	:
					{
						$this->help();
						break;
					}

				}
			}

		}

		/**
		 * Execute migrations files
		 */
		private function migration()
		{

			$aFile = glob(path.'app/database/migration/*.php');

			foreach ($aFile as $file)
			{

				include_once($file);

				$class = basename($file, '.php');

				if (class_exists($class))
				{

					$migration = new $class();

					if (method_exists($migration,'run'))
					{


						$migration->run();

					}

				}

			}

		}

    }
