<?php
/***************************************************************************
 *   Copyright (C) 2007 by Konstantin V. Arkhipov                          *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/

	/**
	 * @ingroup Projections
	**/
	namespace Onphp;

	abstract class CountProjection extends BaseProjection
	{
		/**
		 * @return \Onphp\JoinCapableQuery
		**/
		public function process(Criteria $criteria, JoinCapableQuery $query)
		{
			return
				$query->get(
					$this->getFunction($criteria, $query),
					$this->alias
				);
		}
		
		/**
		 * @return \Onphp\SQLFunction
		**/
		protected function getFunction(
			Criteria $criteria,
			JoinCapableQuery $query
		)
		{
			Assert::isNotNull($this->property);
			
			return
				SQLFunction::create(
					'count',
					$this->property
						? $criteria->getDao()->guessAtom($this->property, $query)
						: $criteria->getDao()->getIdName()
				);
		}
	}
?>