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
/* $Id$ */

	/**
	 * @ingroup Net
	**/
	class Url extends GenericUri
	{
		protected $knownSubSchemes	= array(
			'http'		=> 'HttpUrl',
			'https'		=> 'HttpUrl',
			'ftp'		=> 'Url',
			'nntp'		=> 'Url',
			'telnet'	=> 'Url',
			'gopher'	=> 'Url',
			'wais'		=> 'Url',
			'file'		=> 'Url',
			'prospero'	=> 'Url'
		);
		
		/**
		 * @return Url
		**/
		public static function create()
		{
			return new self;
		}
		
		public function getKnownSubSchemes()
		{
			return $this->knownSubSchemes;
		}
		
		public function isValid()
		{
			if (
				$this->isAbsolute()
				|| (!$this->scheme && !$this->getAuthority())
			)
				return parent::isValid();
			
			return false;
		}
		
		public function isAbsolute()
		{
			return ($this->scheme && $this->host);
		}
		
		/**
		 * If scheme is present but authority is empty, authority part is
		 * taken from fisrt non-empty segment, i.e: http:////anything/...
		 * becomes http://anything/...
		**/
		public function fixAuthorityFromPath()
		{
			if ($this->scheme && !$this->getAuthority()) {
				$segments = explode('/', $this->path);
				
				while ($segments && empty($segments[0]))
					array_shift($segments);
				
				if ($segments) {
					$this->setAuthority(array_shift($segments));
					$this->setPath('/'.implode('/', $segments));
				}
			}
			
			return $this;
		}
		
		/**
		 * see: rfc3986, sec. 4.2, paragraph 4; rfc 2396, sec 3.1
		**/
		public function fixMistakenPath()
		{
			if ($this->scheme || $this->getAuthority())
				return $this;
			
			$urlSubSchemes = Url::create()->getKnownSubSchemes();
			
			if (
				!preg_match('/^([a-z][a-z0-9.+-]*):(.*)/i', $this->path, $matches)
				|| !isset($urlSubSchemes[strtolower($matches[1])])
			) {
				// localhost:80 not a scheme+authority
				return $this;
			}
			
			// but http:anything:80/... and http:/anything:80/.. becomes
			// http://anything:80/...
			
			$this->setScheme($matches[1]);
			$this->setPath($matches[2]);
			
			$this->fixAuthorityFromPath();
			
			return $this;
		}
		
		public function toSmartString()
		{
			$result = null;
			
			$authority = $this->getAuthority();
			
			if ($authority !== null)
				$result .= $authority;
			
			$result .= $this->path;
			
			if ($this->query !== null)
				$result .= '?'.$this->query;
			
			if ($this->fragment !== null)
				$result .= '#'.$this->fragment;
			
			return $result;
		}
		
		final protected function getSchemeHierPattern(
			$schemePattern, $hierPattern
		)
		{
			return "($schemePattern?$hierPattern)?";
		}
		
		final protected function getHierPattern()
		{
			return parent::getHierPattern();
		}
		
		final protected function getQueryFragmentPattern()
		{
			return parent::getQueryFragmentPattern();
		}
	}
?>