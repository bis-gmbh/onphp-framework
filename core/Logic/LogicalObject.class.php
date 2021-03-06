<?php
/***************************************************************************
 *   Copyright (C) 2004-2007 by Konstantin V. Arkhipov                     *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/

	/**
	 * Support interface for Form's logic rules.
	 * 
	 * @ingroup Logic
	**/
	namespace Onphp;

	interface LogicalObject extends DialectString
	{
		public function toBoolean(Form $form);
	}
?>