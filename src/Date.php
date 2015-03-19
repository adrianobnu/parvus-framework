<?php
    namespace Parvus;

    class Date
    {

        public static final function show ($prDate)
        {
            return $prDate ? date ('d/m/Y'.(strpos($prDate,':') !== false ? ' H:i:s' : NULL),strToTime($prDate)) : NULL;
        }

        public static final function save ($prDate)
        {
            return $prDate ? date ('Y-m-d'.(strpos($prDate,':') !== false ? ' H:i:s' : NULL),strToTime(str_replace('/','-',$prDate))) : NULL;
        }

        public static final function diff ($prDate,$prDateFinal = NULL,$prFormat = '%Y')
        {
            if (!$prDateFinal)
            {
                $prDateFinal = date('Y-m-d');
            }

            $date = new \DateTime($prDate);
            $interval = $date->diff(new \DateTime($prDateFinal));

            return $interval->format($prFormat);
        }

    }
