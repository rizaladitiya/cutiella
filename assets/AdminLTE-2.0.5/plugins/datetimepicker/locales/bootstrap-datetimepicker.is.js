estamps/intervals, just in case
		if ( ( ! ctype_digit((string) $unix_start) && ($unix_start = @strtotime($unix_start)) === FALSE)
			OR ( ! ctype_digit((string) $mixed) && ($is_unix === FALSE OR ($mixed = @strtotime($mixed)) === FALSE))
			OR ($is_unix === TRUE && $mixed < $unix_start))
		{
			return FALSE;
		}

		if ($is_unix && ($unix_start == $mixed OR date($format, $unix_start) === date($format, $mixed)))
		{
			return array(date($format, $unix_start));
		}

		$range = array();

		$from = new DateTime();
		$from->setTimestamp($unix_start);

		if ($is_unix)
		{
			$arg = new DateTime();
			$arg->setTimestamp($mixed);
		}
		else
		{
			$arg = (int) $mixed;
		}

		$period = new DatePeriod($from, new DateInterval('P1D'), $arg);
		foreac