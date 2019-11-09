efault
	 * @example	date(DATE_W3C, $time); // a different format and time
	 *
	 * @param	string	$fmt = 'DATE_RFC822'	the chosen format
	 * @param	int	$time = NULL		Unix timestamp
	 * @return	string
	 */
	function standard_date($fmt = 'DATE_RFC822', $time = NULL)
	{
		if (empty($time))
		{
			$time = now();
		}

		// Procedural style pre-defined constants from the DateTime extension
		if (strpos($fmt, 'DATE_') !== 0 OR defined($fmt) === FALSE)
		{
			return FALSE;
		}

		return date(constant($fmt), $time);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('timespan'))
{
	/**
	 * Timespan
	 *
	 * Returns a span of seconds in this format:
	 *	10 days 14 hours 36 mi