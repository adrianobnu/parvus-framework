<?php
    namespace Parvus;

    class Date
    {

		/**
		 * Sub a data and return then
		 * @param $prDate string Date in format Y-m-d or Ymd (If null, use the actual date)
		 * @param $prQuantity number Quantity to sub
		 * @param string $prType string Type (d,m,y)
		 * @param string $prFormat string Output format of the date
		 * @return string
		 */
		public static final function sub ($prDate, $prQuantity, $prType = 'd', $prFormat = 'Y-m-d')
		{

			return Date::addSub($prDate,$prQuantity,$prType,$prFormat,'sub');

		}

		/**
		 * Add a data and return then
		 * @param $prDate string Date in format Y-m-d or Ymd (If null, use the actual date)
		 * @param $prQuantity number Quantity to add
		 * @param string $prType string Type (d,m,y)
		 * @param string $prFormat string Output format of the date
		 * @return string
		 */
		public static final function add ($prDate, $prQuantity, $prType = 'd', $prFormat = 'Y-m-d')
		{

			return Date::addSub($prDate,$prQuantity,$prType,$prFormat,'add');

		}

		/**
		 * Add a data and return then
		 * @param $prDate string Date in format Y-m-d or Ymd (If null, use the actual date)
		 * @param $prQuantity number Quantity to add/sub
		 * @param $prType string Type (d,m,y)
		 * @param $prFormat string Output format of the date
		 * @param $prAction string Action (add,sub)
		 * @return string
		 */
		private static final function addSub ($prDate, $prQuantity, $prType , $prFormat, $prAction)
		{

			$time		= strtotime($prDate != NULL ? $prDate : date('Y-m-d'));
			$day 		= date('d',$time);
			$month 		= date('m',$time);
			$year 		= date('Y',$time);
			$prAction 	= mb_strtolower($prAction,'UTF-8');

			switch (mb_strtolower($prType,'UTF-8'))
			{

				case 'd' :
				{
					$day = ($prAction == 'sub' ? $day -= $prQuantity : $day += $prQuantity);
					break;
				}

				case 'y' :
				{
					$year = ($prAction == 'sub' ? $year -= $prQuantity : $year += $prQuantity);
					break;
				}

				case 'm' :
				{
					$month = ($prAction == 'sub' ? $month -= $prQuantity : $month += $prQuantity);
					break;
				}

			}

			return date($prFormat, mktime (0, 0, 0, $month, $day, $year));

		}

        /**
         * Show a date
         * @param $prDate
         * @param string $prFormat
         * @return bool|null|string
         */
        public final static function date ($prDate, $prFormat = 'd/m/Y')
        {

            return $prDate != NULL ? date ($prFormat,strtotime($prDate)) : NULL;

        }

        /**
         * Show a time
         * @param $prDate
         * @param string $prFormat
         * @return bool|null|string
         */
        public final static function time ($prDate, $prFormat = 'H:i')
        {

            return self::date($prDate,$prFormat);

        }

        /**
         * Show a datetime
         * @param $prDatetime
         * @param string $prFormat
         * @return bool|null|string
         */
        public final static function datetime ($prDatetime, $prFormat = 'd/m/Y H:i')
        {

            return self::date($prDatetime,$prFormat);

        }

        /**
         * Show a date
         * @deprecated Use DATE or TIME function
         * @param $prDate
         * @return bool|null|string
         */
        public static final function show ($prDate)
        {

            trigger_error("Function SHOW is deprecated. Use DATE or TIME function.", E_USER_NOTICE);

            $format = 'd/m/Y';

            if (strpos($prDate, ':') !== false)
            {

                $format .= ' H:i';

            }

            return self::date($prDate,$format);

        }

        /**
         * Convert a date to american format
         * @param $prDate
         * @return bool|null|string
         */
        public static final function save ($prDate)
        {

            $format = 'Y-m-d';

            if (strpos($prDate, ':') !== false)
            {

                $format .= ' H:i:s';

            }

            return $prDate != NULL ? date ($format,strtotime(str_replace('/','-',$prDate))) : NULL;

        }

        /**
         * @param $prDate
         * @param null $prDateFinal
         * @param string $prFormat (http://php.net/manual/en/dateinterval.format.php)
         * @return string
         */
        public static final function diff ($prDate,$prDateFinal = NULL,$prFormat = '%Y')
        {

            if ($prDateFinal == NULL)
            {

                $prDateFinal = date('Y-m-d H:i:s');

            }

            $date = new \DateTime($prDate);
            $interval = $date->diff(new \DateTime($prDateFinal));

            return $interval->format($prFormat);
        }

    }
