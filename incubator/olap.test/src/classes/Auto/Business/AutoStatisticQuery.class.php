<?php
/*****************************************************************************
 *   Copyright (C) 2006-2007, onPHP's MetaConfiguration Builder.             *
 *   Generated by onPHP-0.9.300 at 2007-05-15 14:27:41                       *
 *   This file is autogenerated - do not edit.                               *
 *****************************************************************************/
/* $Id$ */

	abstract class AutoStatisticQuery extends IdentifiableObject
	{
		protected $query = null;
		protected $media = null;
		protected $when = null;
		protected $found = null;
		protected $region = null;
		protected $ip = null;
		
		public function getQuery()
		{
			return $this->query;
		}
		
		/**
		 * @return StatisticQuery
		**/
		public function setQuery($query)
		{
			$this->query = $query;
			
			return $this;
		}
		
		public function getMedia()
		{
			return $this->media;
		}
		
		/**
		 * @return StatisticQuery
		**/
		public function setMedia($media)
		{
			$this->media = $media;
			
			return $this;
		}
		
		/**
		 * @return Timestamp
		**/
		public function getWhen()
		{
			return $this->when;
		}
		
		/**
		 * @return StatisticQuery
		**/
		public function setWhen(Timestamp $when)
		{
			$this->when = $when;
			
			return $this;
		}
		
		/**
		 * @return StatisticQuery
		**/
		public function dropWhen()
		{
			$this->when = null;
			
			return $this;
		}
		
		public function getFound()
		{
			return $this->found;
		}
		
		/**
		 * @return StatisticQuery
		**/
		public function setFound($found)
		{
			$this->found = $found;
			
			return $this;
		}
		
		/**
		 * @return Region
		**/
		public function getRegion()
		{
			return $this->region;
		}
		
		/**
		 * @return StatisticQuery
		**/
		public function setRegion(Region $region)
		{
			$this->region = $region;
			
			return $this;
		}
		
		/**
		 * @return StatisticQuery
		**/
		public function dropRegion()
		{
			$this->region = null;
			
			return $this;
		}
		
		public function getIp()
		{
			return $this->ip;
		}
		
		/**
		 * @return StatisticQuery
		**/
		public function setIp($ip)
		{
			$this->ip = $ip;
			
			return $this;
		}
	}
?>