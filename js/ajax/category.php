<?php

namespace Mutum;

use Site;

header('Content-type: application/json');

try {
    $method = Site::obtain_post('method');
    if (!$method) {
        throw new \InvalidArgumentException('You should provide a valid method.');
    }

    $class = new Category($method);
    $datas = $class->execute();

    $response = array('success' => true, 'datas' => $datas);
} catch (Exception $e) {
    $response = array('success' => false, 'message' => $e->getMessage());

}

die(json_encode($response));


class Category
{
    private $method;

    public function __construct($method)
    {

        if (!method_exists($this, $method)) {
            throw new \Exception(sprintf("You should provide a valid method name, '%s' given.", $method));
        }

        $this->method = $method;
    }


    public function execute() {
        return $this->{$this->method}();
    }
    protected function getChildren()
    {
        $categoryId = Site::obtain_post('category_id');
        if (!$categoryId) {
            throw new \InvalidArgumentException('You should provide a valid category_id');
        }

        /** @var \category_article $category */
        $category = \category_article::getById($categoryId);
        if (!count($category)) {
            throw new \InvalidArgumentException(
                sprintf("You should provide a valid category_id, '%s' given.", $categoryId)
            );
        }

        $category = $category[0][0];
        $children = $category->getChildren();

        return $children;
    }
}