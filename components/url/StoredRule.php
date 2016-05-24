<?php

namespace friendsofyii2\urlalias\components\url;

use Yii;
use yii\web\Request;
use yii\web\UrlRule;
use friendsofyii2\urlalias\components\StorageInterface;

class StoredRule extends UrlRule
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    public function __construct(Request $request, array $config = array())
    {
        $this->storage = Yii::$container->get('UrlAliasFinder');
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->name === null) {
            $this->name = __CLASS__;
        }
    }

    public function parseRequest($manager, $request)
    {
        $slug = $this->checkIsPath($request);

        $dbRoute = $this->storage->getRouteFromSlug($slug);

        if ($dbRoute) {
            return array($dbRoute[0], $dbRoute[1]);
        }

        return false;
    }

    /**
     * @param \yii\web\Request $request
     * @return string
     */
    private function checkIsPath($request)
    {
        $route = $request->getPathInfo();
        $params = $request->get();

        $pathedRoute = $this->storage->checkIsPath($route, $params);

        if ($pathedRoute) {
            Yii::$app->response->redirect(
                [
                    $pathedRoute[0]
                ],
                $pathedRoute[1]['redirection_code']
            );
        }

        return $route;
    }
}