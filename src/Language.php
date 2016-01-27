<?php

    namespace Parvus;

    class Language
    {

        private static $aLanguage = array();
        private static $locale = NULL;
        private static $config = array();

        /**
         * Return the text of a key
         * @param $prText (Ex: messages.error.login, this will be a array position in the language translation file)
         * @param null $prArray (Ex: array ('name' => 'John', 'email' => 'email@email.com')
         * @return array|mixed
         */
        public final static function get ($prText,$prArray = NULL)
        {

            $locale = static::getLocale();
            $aArray = static::$aLanguage;

            /** If the language array is null */
            if (static::$aLanguage == NULL)
            {

                $file = path.'app/language/'.$locale.'.php';

                /** If the locale file not exists */
                if (!file_exists($file))
                {

                    throw new \RuntimeException('Locale translation file not found.',E_ERROR);

                }

                /** Get the content */
                $aArray = include_once ($file);

                /** Save the content to array of the class */
                static::$aLanguage = $aArray;
            }

            /** Get the text position */
            foreach (explode('.',$prText) as $label)
            {

                $aArray = $aArray[$label];

            }
            
            /**
             * If the text has not found, return the original text
             */
            if ($aArray == NULL || !is_string($aArray))
            {

                return 'Missing: '.$prText;

            }

            /** Replace the macros strings by value */
            foreach ($prArray as $label => $value)
            {

                foreach (array(mb_strtolower($label),mb_strtoupper($label),$label) as $tmp)
                {

                    $aArray = str_replace('{'.$tmp.'}',$value,$aArray);

                }

            }

            /** Return the text */
            return $aArray;

        }

        /**
         * Define the locale
         * @param $prLocale
         */
        public final static function setLocale ($prLocale)
        {

            $_SESSION['parvus-locale'] = $prLocale;

        }

        /**
         * Return the actual locale
         * @return null
         */
        public final static function getLocale ()
        {

            /** If not has defined the locale */
            if (static::$locale == NULL && $_SESSION['parvus-locale'] == NULL)
            {

                $file = path.'app/config/Language.php';

                /** If the config file not exist */
                if (!file_exists($file))
                {

                    throw new \RuntimeException('Language configuration file not found.',E_ERROR);

                }

                static::$config = include_once ($file);

                /** If the default locale not exist */
                if (static::$config['default'] == NULL)
                {

                    throw new \RuntimeException('Default language not found in app/config/Language.php',E_ERROR);

                }

                /** Save in session */
                $_SESSION['parvus-locale'] = static::$config['default'];

            }

            /** Save in the class */
            static::$locale = $_SESSION['parvus-locale'];

            /** Return the locale */
            return static::$locale;

        }

    }
