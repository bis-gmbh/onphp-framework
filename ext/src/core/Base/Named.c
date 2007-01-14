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

#include "onphp_core.h"

#include "core/Base/Named.h"

PHPAPI zend_class_entry *onphp_ce_Named;

static ONPHP_ARGINFO_ONE;

zend_function_entry onphp_funcs_Named[] = {
	ONPHP_ABSTRACT_ME(Identifiable, getName, NULL, ZEND_ACC_PUBLIC)
	ONPHP_ABSTRACT_ME(Identifiable, setName, arginfo_one, ZEND_ACC_PUBLIC)
	{NULL, NULL, NULL}
};