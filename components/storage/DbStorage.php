<?php

namespace friendsofyii2\urlalias\components\storage;

use Yii;
use friendsofyii2\urlalias\components\StorageInterface;
use yii\db\Query;

class DbStorage implements StorageInterface
{
	/**
	 * @param $path
	 * @param array $params
	 * @return array|bool
	 */
	public function checkIsPath($path, array $params = array())
	{
		$query = $this->getQuery();
		$query->select('*');
		$query->from('url_alias ua');
		$query->where(
			array(
				'ua.path' => $path
			)
		);

		$result = $query->one();


		if ($result)
		{
			$query = $this->getQuery();
			$query->select('*');
			$query->from('url_alias_params uap');
			$query->where(
				array(
					'uap.alias_id' => $result['id']
				)
			);

			$results = $query->all();

			if (count($results) != count($params)) {
				return false;
			}

			$slug = $result['slug'];
			return array($slug, $result);
		}

		return false;
	}


	/**
	 * @param $slug
	 * @return string
	 */
	public function getRouteFromSlug($slug)
	{
		$query = $this->getQuery();
		$query->select('*');
		$query->from('url_alias ua');
		$query->where(
			array(
				'ua.slug' => $slug
			)
		);

		$result = $query->one();

		if ($result)
		{
			$query = $this->getQuery();
			$query->select('*');
			$query->from('url_alias_params uap');
			$query->where(
				array(
					'uap.alias_id' => $result['id']
				)
			);

			$results = $query->all();

			$params = array();
			if ($results) {
				foreach ($results as $r) {
					$params[$r['param']] = $r['param_value'];
				}
			}

			return array($result['path'], $params);
		}

		return false;
	}

	private function getQuery()
	{
		return new Query();
	}

	public function set($slug, $route, $attributes)
	{

	}
}