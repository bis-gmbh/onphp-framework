<?php

/* * *************************************************************************
 *   Copyright (C) 2012 by Alexey Denisov                                  *
 *   alexeydsov@gmail.com                                                  *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 * ************************************************************************* */

namespace Onphp\NsConverter\Utils;

use \Onphp\NsConverter\Business\NsFunction;



interface NsObject
{
	public function getName();

	/**
	 * @return NsFunction
	**/
	public function setName($name);

	public function getNamespace();

	/**
	 * @return NsFunction
	**/
	public function setNamespace($namespace);

	public function getNewNamespace();

	/**
	 * @return NsFunction
	**/
	public function setNewNamespace($newNamespace);

	public function getFullName();

	public function getFullNewName();
}
