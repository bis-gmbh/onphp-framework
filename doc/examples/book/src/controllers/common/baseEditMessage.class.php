<?php
/***************************************************************************
 *   Copyright (C) 2007 by Denis Gabaidulin                                *
 *   gabaden@gmail.com                                                     *
 ***************************************************************************/
/* $Id$ */

	abstract class baseEditMessage extends EditorController
	{
		public function __construct()
		{
			parent::__construct(Message::create());
			
			$this->commandMap['add'] 	= new MessageAddCommand();
			$this->commandMap['save'] 	= new MessageSaveCommand();
		}
		
		public function handleRequest(HttpRequest $request)
		{
			$mav = parent::handleRequest($request);
			
			$mav->getModel()->set(
				'categories',
				Criteria::create(Category::dao())->
				getList()
			);
			
			return $mav;
		}
	}
?>