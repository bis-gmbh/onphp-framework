<?php
/***************************************************************************
 *   Copyright (C) 2007 by Ivan Y. Khvostishkov                            *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/

	namespace Onphp;

	final class FormToObjectConverter extends ObjectBuilder
	{
		/**
		 * @return \Onphp\FormToObjectConverter
		**/
		public static function create(EntityProto $proto)
		{
			return new self($proto);
		}
		
		/**
		 * @return \Onphp\FormGetter
		**/
		protected function getGetter($object)
		{
			return new FormGetter($this->proto, $object);
		}
		
		/**
		 * @return \Onphp\ObjectSetter
		**/
		protected function getSetter(&$object)
		{
			return new ObjectSetter($this->proto, $object);
		}
	}
?>