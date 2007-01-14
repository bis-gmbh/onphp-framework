<?php
/***************************************************************************
 *   Copyright (C) 2006 by Konstantin V. Arkhipov                          *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	/**
	 * @see http://eaccelerator.net/
	 * 
	 * @ingroup Lockers
	**/
	final class eAcceleratorLocker extends BaseLocker
	{
		public function get($key)
		{
			eaccelerator_lock($key);
		}
		
		public function free($key)
		{
			eaccelerator_unlock($key);
		}
		
		public function drop($key)
		{
			return $this->free($key);
		}
		
		public function clean()
		{
			// will be cleaned out upon script's shutdown
			return true;
		}
	}
?>