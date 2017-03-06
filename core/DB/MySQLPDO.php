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

	/**
	 * PDO MySQL DB connector.
	 * 
	 * @see http://www.mysql.com/
	 * @see http://php.net/PDO_MySQL
	 *
	 * @ingroup DB
	 */
	final class MySQLPDO extends Sequenceless
	{
		const ERROR_CONSTRAINT = 19;

		private $needAutoCommit = false;

		private $defaultEngine;

		/**
		 * @var \PDO
		 */
		protected $link;

		/**
		 * @return MySQLPDO
		 */
		public function setDbEncoding()
		{
			$this->link->exec(sprintf('SET NAMES %s', $this->encoding));

			return $this;
		}

		/**
		 * @param $flag
		 * @return MySQLPDO
		 */
		public function setNeedAutoCommit($flag)
		{
			$this->needAutoCommit = $flag == true;
			$this->setupAutoCommit();
			return $this;
		}

		/**
		 * @param string $engine
		 * @return MySQLPDO
		 */
		public function setDefaultEngine($engine)
		{
			$this->defaultEngine = $engine;
			$this->setupDefaultEngine();
			return $this;
		}

		/**
		 * @return $this
		 * @throws \Onphp\DatabaseException
		 * @throws \Onphp\UnsupportedMethodException
		 */
		public function connect()
		{
			try {
				$this->link = new \PDO(
					sprintf("mysql:dbname=%s;host=%s;port=%d", $this->basename, $this->hostname, $this->port),
					$this->username,
					$this->password,
					[
						\PDO::ATTR_PERSISTENT => $this->checkPersistent(),
					]
				);
			} catch (\PDOException $e) {
				throw new DatabaseException(
					'can not connect to MySQL server: '.$e->getMessage()
				);
			}

			if ($this->encoding)
				$this->setDbEncoding();

			$this->setupAutoCommit();
			$this->setupDefaultEngine();

			return $this;
		}

		/**
		 * @return \Onphp\MySQLim
		 */
		public function disconnect()
		{
			if ($this->link) {
				$this->link = null;
			}

			return $this;
		}

		public function isConnected()
		{
			return $this->link !== null;
		}

		/**
		 * Same as query, but returns number of
		 * affected rows in insert/update queries
		 *
		 * @param Query $query
		 * 
		 * @return mixed|null
		 */
		public function queryCount(Query $query)
		{
			$res = $this->queryNull($query);
			/* @var $res \PDOStatement */

			return $res->rowCount();
		}

		/**
		 * @param Query $query
		 *
		 * @return mixed|null
		 * @throws TooManyRowsException
		 */
		public function queryRow(Query $query)
		{
			$res = $this->query($query);
			/* @var $res \PDOStatement */

			$array = $res->fetchAll(\PDO::FETCH_ASSOC);
			if (count($array) > 1)
				throw new TooManyRowsException(
					'query returned too many rows (we need only one)'
				);
			elseif (count($array) == 1)
				return reset($array);
			else
				return null;
		}

		public function queryColumn(Query $query)
		{
			$res = $this->query($query);
			/* @var $res \PDOStatement */

			$resArray = $res->fetchAll(\PDO::FETCH_ASSOC);
			if ($resArray) {
				$array = [];
				foreach ($resArray as $row) {
					$array[] = reset($row);
				}

				return $array;
			} else
				return null;
		}

		public function queryRaw($queryString)
		{
			try {
				return $this->link->query($queryString);
			} catch (\PDOException $e) {
				$code = $e->getCode();

				if ($code == self::ERROR_CONSTRAINT)
					$exc = '\Onphp\DuplicateObjectException';
				else
					$exc = '\Onphp\DatabaseException';

				throw new $exc($e->getMessage().': '.$queryString);
			}
		}

		public function querySet(Query $query)
		{
			$res = $this->query($query);
			/* @var $res \PDOStatement */

			return $res->fetchAll(\PDO::FETCH_ASSOC) ?: null;
		}

		public function getTableInfo($table)
		{
			throw new UnimplementedFeatureException();
		}

		public function hasQueue()
		{
			return false;
		}

		protected function getInsertId()
		{
			return $this->link->lastInsertId();
		}

		/**
		 * @return MyPDODialect
		 */
		protected function spawnDialect()
		{
			return new MyPDODialect();
		}

		private function setupAutoCommit()
		{
			if ($this->isConnected()) {
				$this->link->setAttribute(\PDO::ATTR_AUTOCOMMIT, $this->needAutoCommit);
			}
		}

		private function setupDefaultEngine()
		{
			if ($this->defaultEngine && $this->isConnected()) {
				$this->link->exec(sprintf('SET storage_engine = %s', $this->defaultEngine));
			}
		}

		private function checkPersistent()
		{
			if ($this->persistent) {
				if (version_compare(PHP_VERSION, '5.3.0') < 0) {
					throw new UnsupportedMethodException('php version must be >= 5.3');
				}

				return true;
			}

			return false;
		}
	}
