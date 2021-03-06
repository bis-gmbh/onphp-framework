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
	 * Factory for various childs of LogicalObjects
	 *
	 * @ingroup Logic
	**/
	namespace Onphp;

	final class Expression extends StaticFactory
	{
		/**
		 * @return \Onphp\BinaryExpression
		**/
		public static function expAnd($left, $right)
		{
			return new BinaryExpression(
				$left, $right, BinaryExpression::EXPRESSION_AND
			);
		}
		
		/**
		 * @return \Onphp\BinaryExpression
		**/
		public static function expOr($left, $right)
		{
			return new BinaryExpression(
				$left, $right, BinaryExpression::EXPRESSION_OR
			);
		}
		
		/**
		 * @return \Onphp\BinaryExpression
		**/
		public static function eq($field, $value)
		{
			return new BinaryExpression($field, $value, BinaryExpression::EQUALS);
		}
		
		/**
		 * @return \Onphp\BinaryExpression
		**/
		public static function eqId($field, Identifiable $object)
		{
			return self::eq($field, DBValue::create($object->getId()));
		}
		
		/**
		 * @return \Onphp\BinaryExpression
		**/
		public static function notEq($field, $value)
		{
			return new BinaryExpression(
				$field, $value, BinaryExpression::NOT_EQUALS
			);
		}
		
		/**
		 * greater than
		 *
		 * @return \Onphp\BinaryExpression
		**/
		public static function gt($field, $value)
		{
			return new BinaryExpression(
				$field, $value, BinaryExpression::GREATER_THAN
			);
		}
		
		/**
		 * greater than or equals
		 *
		 * @return \Onphp\BinaryExpression
		**/
		public static function gtEq($field, $value)
		{
			return new BinaryExpression(
				$field, $value, BinaryExpression::GREATER_OR_EQUALS
			);
		}
		
		/**
		 * lower than
		 *
		 * @return \Onphp\BinaryExpression
		**/
		public static function lt($field, $value)
		{
			return new BinaryExpression(
				$field, $value, BinaryExpression::LOWER_THAN
			);
		}
		
		/**
		 * lower than or equals
		 *
		 * @return \Onphp\BinaryExpression
		**/
		public static function ltEq($field, $value)
		{
			return new BinaryExpression(
				$field, $value, BinaryExpression::LOWER_OR_EQUALS
			);
		}
		
		/**
		 * @return \Onphp\PostfixUnaryExpression
		**/
		public static function notNull($field)
		{
			return new PostfixUnaryExpression($field, PostfixUnaryExpression::IS_NOT_NULL);
		}
		
		/**
		 * @return \Onphp\PostfixUnaryExpression
		**/
		public static function isNull($field)
		{
			return new PostfixUnaryExpression($field, PostfixUnaryExpression::IS_NULL);
		}
		
		/**
		 * @return \Onphp\PostfixUnaryExpression
		**/
		public static function isTrue($field)
		{
			return new PostfixUnaryExpression($field, PostfixUnaryExpression::IS_TRUE);
		}
		
		/**
		 * @return \Onphp\PostfixUnaryExpression
		**/
		public static function isFalse($field)
		{
			return new PostfixUnaryExpression($field, PostfixUnaryExpression::IS_FALSE);
		}
		
		/**
		 * @return \Onphp\BinaryExpression
		**/
		public static function like($field, $value)
		{
			return new BinaryExpression($field, $value, BinaryExpression::LIKE);
		}
		
		/**
		 * @return \Onphp\BinaryExpression
		**/
		public static function notLike($field, $value)
		{
			return new BinaryExpression($field, $value, BinaryExpression::NOT_LIKE);
		}

		/**
		 * @return \Onphp\BinaryExpression
		**/
		public static function ilike($field, $value)
		{
			return new BinaryExpression($field, $value, BinaryExpression::ILIKE);
		}
		
		/**
		 * @return \Onphp\BinaryExpression
		**/
		public static function notIlike($field, $value)
		{
			return new BinaryExpression($field, $value, BinaryExpression::NOT_ILIKE);
		}
		
		/**
		 * @return \Onphp\BinaryExpression
		**/
		public static function similar($field, $value)
		{
			return new BinaryExpression($field, $value, BinaryExpression::SIMILAR_TO);
		}
		
		/**
		 * @return \Onphp\BinaryExpression
		**/
		public static function notSimilar($field, $value)
		{
			return new BinaryExpression($field, $value, BinaryExpression::NOT_SIMILAR_TO);
		}
		
		/**
		 * @return \Onphp\EqualsLowerExpression
		**/
		public static function eqLower($field, $value)
		{
			return new EqualsLowerExpression($field, $value);
		}
		
		/**
		 * @return \Onphp\LogicalBetween
		**/
		public static function between($field, $left, $right)
		{
			return new LogicalBetween($field, $left, $right);
		}
		
		/**
		 * {,not}in handles strings, arrays and SelectQueries
		 *
		 * @return \Onphp\LogicalObject
		**/
		public static function in($field, $value)
		{
			if (is_numeric($value) && $value == (int) $value)
				return self::eq($field, $value);
			elseif (is_array($value) && count($value) == 1)
				return self::eq($field, current($value));
			else {
				return new InExpression(
					$field, $value, InExpression::IN
				);
			}
		}
		
		/**
		 * @return \Onphp\LogicalObject
		**/
		public static function notIn($field, $value)
		{
			if (is_numeric($value) && $value == (int) $value)
				return self::notEq($field, $value);
			elseif (is_array($value) && count($value) == 1)
				return self::notEq($field, current($value));
			else {
				return new InExpression(
					$field, $value, InExpression::NOT_IN
				);
			}
		}

		/**
		 * +
		 *
		 * @return \Onphp\BinaryExpression
		**/
		public static function add($field, $value)
		{
			return new BinaryExpression($field, $value, BinaryExpression::ADD);
		}
		
		/**
		 * -
		 *
		 * @return \Onphp\BinaryExpression
		**/
		public static function sub($field, $value)
		{
			return new BinaryExpression($field, $value, BinaryExpression::SUBSTRACT);
		}
		
		/**
		 * *
		 *
		 * @return \Onphp\BinaryExpression
		**/
		public static function mul($field, $value)
		{
			return new BinaryExpression($field, $value, BinaryExpression::MULTIPLY);
		}
		
		/**
		 * /
		 *
		 * @return \Onphp\BinaryExpression
		**/
		public static function div($field, $value)
		{
			return new BinaryExpression($field, $value, BinaryExpression::DIVIDE);
		}
		
		/**
		 * %
		 *
		 * @return \Onphp\BinaryExpression
		**/
		public static function mod($field, $value)
		{
			return new BinaryExpression($field, $value, BinaryExpression::MOD);
		}
		
		/**
		 * @return \Onphp\FullTextSearch
		**/
		public static function fullTextAnd($field, $wordsList)
		{
			return new FullTextSearch($field, $wordsList, DB::FULL_TEXT_AND);
		}
		
		/**
		 * @return \Onphp\FullTextSearch
		**/
		public static function fullTextOr($field, $wordsList)
		{
			return new FullTextSearch($field, $wordsList, DB::FULL_TEXT_OR);
		}
		
		/**
		 * @return \Onphp\FullTextRank
		**/
		public static function fullTextRankOr($field, $wordsList)
		{
			return new FullTextRank($field, $wordsList, DB::FULL_TEXT_OR);
		}
		
		/**
		 * @return \Onphp\FullTextRank
		**/
		public static function fullTextRankAnd($field, $wordsList)
		{
			return new FullTextRank($field, $wordsList, DB::FULL_TEXT_AND);
		}
		
		/**
		 * @return \Onphp\LogicalChain
		**/
		public static function orBlock(/* ... */)
		{
			return self::block(
				func_get_args(),
				BinaryExpression::EXPRESSION_OR
			);
		}

		/**
		 * @return \Onphp\LogicalChain
		**/
		public static function andBlock(/* ... */)
		{
			return self::block(
				func_get_args(),
				BinaryExpression::EXPRESSION_AND
			);
		}
		
		/**
		 * @return \Onphp\LogicalChain
		**/
		public static function chain()
		{
			return new LogicalChain();
		}
		
		/**
		 * @return \Onphp\PrefixUnaryExpression
		**/
		public static function not($field)
		{
			return new PrefixUnaryExpression(PrefixUnaryExpression::NOT, $field);
		}

		/**
		 * @return \Onphp\PrefixUnaryExpression
		**/
		public static function minus($field)
		{
			return new PrefixUnaryExpression(PrefixUnaryExpression::MINUS, $field);
		}
		
		/**
		 * @return \Onphp\Ip4ContainsExpression 
		**/
		public static function containsIp($range, $ip)
		{
			return new Ip4ContainsExpression($range, $ip);
		}
		
		/**
		 * @return \Onphp\LogicalChain
		**/
		private static function block($args, $logic)
		{
			return LogicalChain::block($args, $logic);
		}
	}
?>