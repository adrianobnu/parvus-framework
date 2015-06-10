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

			$time		= strToTime($prDate != NULL ? $prDate : date('Y-m-d'));
			$day 		= date('d',$time);
			$month 		= date('m',$time);
			$year 		= date('Y',$time);
			$prAction 	= strToLower($prAction);

			switch (strToLower($prType))
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
