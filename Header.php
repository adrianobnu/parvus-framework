<?php
    namespace Parvus;

    class Header
    {

        public final static function JSON ($prJSON = NULL)
        {
            header('Content-Type: application/json');

            if ($prJSON)
            {
                exit(json_encode($prJSON));
            }
        }

    }