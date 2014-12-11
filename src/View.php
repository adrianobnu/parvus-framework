<?php
    namespace Parvus;

    class View
    {

        public final function render ($prView,$prArray = array())
        {
            $blade = new \Philo\Blade\Blade(path.'app/view', path.'app/cache');

            return $blade->view()->make($prView,$prArray)->render();
        }

    }