<?php
/****************************************************************************
 *   Copyright (C) 2009 by Vladlen Y. Koshelev                              *
 *                                                                          *
 *   This program is free software; you can redistribute it and/or modify   *
 *   it under the terms of the GNU Lesser General Public License as         *
 *   published by the Free Software Foundation; either version 3 of the     *
 *   License, or (at your option) any later version.                        *
 *                                                                          *
 ****************************************************************************/

	/**
	 * @ingroup OQL
	**/
	namespace Onphp;

	final class OqlSelectPropertiesClause extends OqlProjectionClause
	{
		private $distinct = false;
		
		/**
		 * @return \Onphp\OqlSelectPropertiesClause
		**/
		public static function create()
		{
			return new self;
		}
		
		public function isDistinct()
		{
			return $this->distinct;
		}
		
		/**
		 * @return \Onphp\OqlSelectPropertiesClause
		**/
		public function setDistinct($orly = true)
		{
			$this->distinct = ($orly === true);
			
			return $this;
		}
	}
?>