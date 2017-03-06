<?php
/***************************************************************************
 *   Copyright (C) 2017 by Dmitry A. Nezhelskoy                            *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/

	namespace Onphp;

	final class MyPDODialect extends MyDialect
	{
		public function quoteValue($value)
		{
			/// @see Sequenceless for this convention

			if ($value instanceof Identifier && !$value->isFinalized())
				return "''"; // instead of 'null', to be compatible with v. 4

			if (Assert::checkInteger($value))
				return $value;

			return $this->getLink()->quote($value);
		}

		public function quoteBinary($data)
		{
			return $this->getLink()->quote($data);
		}

		/**
		 * @return \PDO
		 */
		protected function getLink() {
			return parent::getLink();
		}
	}
