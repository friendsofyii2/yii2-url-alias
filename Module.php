<?php

namespace friendsofyii2\urlalias;

use friendsofyii2\urlalias\components\StorageInterface;
use Yii;

class Module extends \yii\base\Module
{
	/**
	 * @var string
	 */
	const VERSION = '0.1.0';

	/**
	 * @var int
	 */
	public $defaultRedirectCode = 302;

	/**
	 * @var string
	 */
	public $defaultStorageClass = 'db';

	/**
	 * @var string
	 */
	public $defaultStoredRuleClass = '\\friendsofyii2\\urlalias\\components\\url\\StoredRule';

	/**
	 * @var array
	 */
	public $storageClasses = [
		'db' => '\\friendsofyii2\\urlalias\\components\\storage\\DbStorage'
	];
}