<?php
/****************************************************************************
 *   Copyright (C) 2004-2006 by Konstantin V. Arkhipov, Anton E. Lebedevich *
 *                                                                          *
 *   This program is free software; you can redistribute it and/or modify   *
 *   it under the terms of the GNU General Public License as published by   *
 *   the Free Software Foundation; either version 2 of the License, or      *
 *   (at your option) any later version.                                    *
 *                                                                          *
 ****************************************************************************/
/* $Id$ */

	/**
	 * @ingroup Primitives
	**/
	final class PrimitiveArray extends RangedPrimitive
	{
		public function import($scope)
		{
			if (!BasePrimitive::import($scope))
				return null;

			if (
				is_array($scope[$this->name])
				&& !($this->min && count($scope[$this->name]) < $this->min)
				&& !($this->min && count($scope[$this->name]) > $this->max))
			{
				$this->value = $scope[$this->name];

				return true;
			}

			return false;
		}
	}
?>