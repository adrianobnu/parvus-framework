<?php
    namespace Parvus;

    class Header
    {

        public static function pdf ()
        {
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-type: application/pdf');
        }

        public final static function CSV ($prFileName)
        {

            if (mb_substr(mb_strtolower($prFileName,'UTF-8'),-4) != '.csv')
            {

                $prFileName.= '.csv';

            }

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename="'.$prFileName);
        }

        public final static function JSON ($prJSON = NULL)
        {
            header('Content-Type: application/json');

            if ($prJSON)
            {
                exit(json_encode($prJSON));
            }
        }

    }
