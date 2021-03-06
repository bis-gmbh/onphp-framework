<?php
/***************************************************************************
 *   Copyright (C) 2008 by Denis M. Gabaidulin                             *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/

	/**
	 * @ingroup GoogleChart
	**/
	namespace Onphp;

	abstract class BaseGoogleChartData extends BaseGoogleChartParameter
	{
		protected $encoding = null;
		
		/**
		 * @return \Onphp\BaseGoogleChartData
		**/
		public static function create()
		{
			return new self;
		}
		
		/**
		 * @return \Onphp\BaseGoogleChartData
		**/
		public function setEncoding(GoogleChartDataEncoding $encoding)
		{
			$this->encoding = $encoding;
			
			return $this;
		}
	}
?>