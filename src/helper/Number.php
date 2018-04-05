<?php
	/**
	 * @param int $prBaseValue
	 * @param int $prFinalValue
	 * @param int $prDecimal
	 * @param null $prLabelIfZero
	 * @return null|string
	 */
	function ruleOf3 ($prBaseValue = 0,$prFinalValue = 0, $prDecimal = 2, $prLabelIfZero = NULL)
	{

		$value = (($prFinalValue * 100) / $prBaseValue);

		if ($value <= 0 && $prLabelIfZero != NULL)
		{

			return $prLabelIfZero;

		}

		return number_format($value,$prDecimal,',','.');

	}
