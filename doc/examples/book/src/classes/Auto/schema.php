<?php
/*****************************************************************************
 *   Copyright (C) 2006-2007, onPHP's MetaConfiguration Builder.             *
 *   Generated by onPHP-0.10.3.99 at 2007-09-07 23:52:05                     *
 *   This file is autogenerated - do not edit.                               *
 *****************************************************************************/
/* $Id$ */

	$schema = new DBSchema();
	
	$schema->
		addTable(
			DBTable::create('message')->
			addColumn(
				DBColumn::create(
					DataType::create(DataType::INTEGER)->
					setNull(false),
					'id'
				)->
				setPrimaryKey(true)->
				setAutoincrement(true)
			)->
			addColumn(
				DBColumn::create(
					DataType::create(DataType::VARCHAR)->
					setNull(false)->
					setSize(255),
					'name'
				)
			)->
			addColumn(
				DBColumn::create(
					DataType::create(DataType::VARCHAR)->
					setNull(false)->
					setSize(2048),
					'text'
				)
			)->
			addColumn(
				DBColumn::create(
					DataType::create(DataType::SMALLINT)->
					setNull(false),
					'category_id'
				)
			)->
			addColumn(
				DBColumn::create(
					DataType::create(DataType::VARCHAR)->
					setSize(20),
					'author'
				)
			)->
			addColumn(
				DBColumn::create(
					DataType::create(DataType::TIMESTAMP)->
					setNull(false),
					'created'
				)
			)
		);
	
	$schema->
		addTable(
			DBTable::create('category')->
			addColumn(
				DBColumn::create(
					DataType::create(DataType::SMALLINT)->
					setNull(false),
					'id'
				)->
				setPrimaryKey(true)->
				setAutoincrement(true)
			)->
			addColumn(
				DBColumn::create(
					DataType::create(DataType::VARCHAR)->
					setNull(false)->
					setSize(255),
					'name'
				)
			)
		);
	
	// message.category_id -> category.id
	$schema->
		getTableByName('message')->
		getColumnByName('category_id')->
		setReference(
			$schema->
				getTableByName('category')->
				getColumnByName('id'),
				ForeignChangeAction::restrict(),
				ForeignChangeAction::cascade()
			);
	
?>