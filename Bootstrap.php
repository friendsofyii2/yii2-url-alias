<?php

namespace friendsofyii2\urlalias;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Exception;

class Bootstrap implements BootstrapInterface
{
	public function bootstrap($app)
	{
		if (!$app->hasModule('urlalias'))
		{
			$app->setModule('urlalias', Module::class);
		}

		/**
		 * @var Module $module
		 */
		$module = $app->getModule('urlalias');

		if (
			!(
				!empty($module->defaultStorageClass) &&
				array_key_exists($module->defaultStorageClass, $module->storageClasses)
			)
		) {
			throw new Exception('hata');
		}

		Yii::$container->set('UrlAliasFinder', $module->storageClasses[$module->defaultStorageClass]);

		/**
		 * todo check interface
		 */
		$ruleClass = Yii::createObject(['class' => $module->defaultStoredRuleClass]);

		$app->urlManager->addRules(
			array(
				$ruleClass
			),
			false
		);

	}
}