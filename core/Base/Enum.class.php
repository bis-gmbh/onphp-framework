<?php
/***************************************************************************
 *   Copyright (C) 2012 by Georgiy T. Kutsurua                             *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/

	/**
	 * Parent of all enumeration classes.
	 *
	 * @see MimeType for example
	 *
	 * @ingroup Base
	 * @ingroup Module
	**/
	namespace Onphp;

	abstract class Enum extends NamedObject
		implements
			\Serializable
	{
		protected static $names = array(/* override me */);

		/**
		 * @param integer $id
		 * @return \Onphp\Enum
		 */
		public static function create($id)
		{
			return new static($id);
		}

		public function __construct($id)
		{
			$this->setInternalId($id);
		}

		/**
		 * @param $id
		 * @return \Onphp\Enum
		 * @throws \Onphp\MissingElementException
		 */
		protected function setInternalId($id)
		{
			if (isset(static::$names[$id])) {
				$this->id = $id;
				$this->name = static::$names[$id];
			} else
				throw new MissingElementException(
					get_class($this) . ' knows nothing about such id == '.$id
				);

			return $this;
		}

        public function serialize() {
            return serialize($this->__serialize());
        }

        public function unserialize($data) {
            $this->__unserialize(unserialize($data));
            return $this;
        }

        public function __serialize()
        {
            return [(string) $this->id];
        }

        public function __unserialize($serialized)
        {
            if (is_array($serialized)) {
                $this->setInternalId($serialized[0]);
                return;
            }

            $this->setInternalId($serialized);
        }

		/**
		 * Array of object
		 * @static
		 * @return array
		 */
		public static function getList()
		{
			$list = array();
			foreach (array_keys(static::$names) as $id)
				$list[] = static::create($id);

			return $list;
		}

		/**
		 * must return any existent ID
		 * 1 should be ok for most enumerations
		 * @return integer
		**/
		public static function getAnyId()
		{
			return 1;
		}

		/**
		 * @return null|integer
		 */
		public function getId()
		{
			return $this->id;
		}


		/**
		 * Alias for getList()
		 * @static
		 * @deprecated
		 * @return array
		 */
		public static function getObjectList()
		{
			return static::getList();
		}

		/**
		 * @return string
		 */
		public function toString()
		{
			return $this->name;
		}

		/**
		 * Plain list
		 * @static
		 * @return array
		 */
		public static function getNameList()
		{
			return static::$names;
		}

		/**
		 * @return \Onphp\Enum
		**/
		public function setId($id)
		{
			throw new UnsupportedMethodException('You can not change id here, because it is politics for Enum!');
		}
	}
?>