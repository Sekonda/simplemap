<?php
/**
 * SimpleMap for Craft CMS
 *
 * @link      https://ethercreative.co.uk
 * @copyright Copyright (c) 2019 Ether Creative
 */

namespace ether\simplemap\migrations;

use craft\db\Migration;
use craft\db\Table;
use ether\simplemap\records\Map;

/**
 * Class Install
 *
 * @author  Ether Creative
 * @package ether\simplemap\migrations
 */
class Install extends Migration
{

	public function safeUp ()
	{
		// Create

		$this->createTable(
			Map::TableName,
			[
				'id'          => $this->primaryKey(),
				'elementId'   => $this->integer()->notNull(),
				'ownerId'     => $this->integer()->notNull(),
				'ownerSiteId' => $this->integer(),
				'fieldId'     => $this->integer()->notNull(),

				'lat'     => $this->decimal(11, 9),
				'lng'     => $this->decimal(12, 9),
				'zoom'    => $this->integer(2),
				'address' => $this->string(255),
				'parts'   => $this->text(),

				'dateCreated' => $this->dateTime()->notNull(),
				'dateUpdated' => $this->dateTime()->notNull(),
				'uid'         => $this->uid()->notNull(),
			]
		);

		// Indexes

		$this->createIndex(
			null,
			Map::TableName,
			['ownerId', 'ownerSiteId', 'fieldId', 'elementId'],
			true
		);

		$this->createIndex(
			null,
			Map::TableName,
			['lat']
		);

		$this->createIndex(
			null,
			Map::TableName,
			['lng']
		);

		// Relations

		$this->addForeignKey(
			null,
			Map::TableName,
			['elementId'],
			Table::ELEMENTS,
			['id'],
			'CASCADE'
		);

		$this->addForeignKey(
			null,
			Map::TableName,
			['ownerId'],
			Table::ELEMENTS,
			['id'],
			'CASCADE'
		);

		$this->addForeignKey(
			null,
			Map::TableName,
			['ownerSiteId'],
			Table::SITES,
			['id'],
			'CASCADE',
			'CASCADE'
		);

		$this->addForeignKey(
			null,
			Map::TableName,
			['fieldId'],
			Table::FIELDS,
			['id'],
			'CASCADE'
		);
	}

	public function safeDown ()
	{
		$this->dropTableIfExists(Map::TableName);
	}

}