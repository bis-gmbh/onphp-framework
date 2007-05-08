<?php
/***************************************************************************
 *   Copyright (C) 2006-2007 by Anton E. Lebedevich                        *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	/**
	 * Replaces \n and \r by whitespace
	 * 
	 * @ingroup Filters
	**/
	class RemoveNewlineFilter extends BaseFilter
	{
		/**
		 * @return RemoveNewLineFilter
		 */
		public static function me()
		{
			return Singleton::getInstance('RemoveNewlineFilter');
		}
		
		public function apply($value)
		{
			return preg_replace('/[\n\r]+/', ' ', $value);
		}
	}
?>