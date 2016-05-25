<?php
    namespace Parvus;

    class View
    {

        /**
         * @param $prView
         * @param array $prArray
         * @return mixed
         */
        public final function render ($prView,$prArray = array())
        {
            
            /** If cache folder not exists, create this */
            if (!is_dir(path.'app/cache'))
            {

                mkdir(path.'app/cache',0775,true);

            }

            $blade = new \Philo\Blade\Blade(path.'app/view', path.'app/cache');

            return $blade->view()->make($prView,$prArray)->render();

        }

    }