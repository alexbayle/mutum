<?php

namespace Mutum;

use Site;

header('Content-type: application/json');

try {

    $method = isset($_REQUEST['method']) ? $_REQUEST['method'] : '';
    if (!$method) {
        throw new \InvalidArgumentException('You should provide a valid method.');
    }

    $class = new Items($method);
    $datas = $class->execute();

    $response = array('success' => true, 'datas' => $datas);
} catch (Exception $e) {
    $response = array('success' => false, 'message' => $e->getMessage());

}

die(json_encode($response));


class Items
{
    private $method;

    public function __construct($method)
    {

        if (!method_exists($this, $method)) {
            throw new \Exception(sprintf("You should provide a valid method name, '%s' given.", $method));
        }

        $this->method = $method;
    }

    protected function getShared1(){
        $article = new \article;
        $NB_ART_PAGE = 5000 ;
        $p = 0;
        if($p>=1) {$p--;}
        $offset = $p*$NB_ART_PAGE;
        $p++;
        $filteredArticles = $article->GetUsersArticleResults("", "", "", $offset, $NB_ART_PAGE, \Session::Me()->getAttr('id'), 1);
        $total = $article->GetUsersArticleResults("", "", "", $offset, $NB_ART_PAGE, \Session::Me()->getAttr('id'), 0, true);
        foreach ($filteredArticles as $filteredArticle){
            $filteredArticle[1]->stars = $filteredArticle[1]->getNoteMoy($filteredArticle[1]->getAttr('id'));
            $filteredArticle[1]->catName = $filteredArticle[1]->getCatName();
            $filteredArticle[1]->mutumByDay = $filteredArticle[1]->getMutumByDay();
            $filteredArticle[1]->nbNotes = $filteredArticle[1]->getNbNotation($filteredArticle[1]->getAttr('id')) ;
            $filteredArticle[1]->state = 1;
        }
        return array('count' => count($filteredArticles), 'articles' => $filteredArticles, 'total' => $total);
    }
    protected function getShared2()  {
        $article = new \article;
        $NB_ART_PAGE = 5000 ;
        $p = 0;
        if($p>=1) {	$p--;	}
        $offset = $p*$NB_ART_PAGE;
        $p++;
        $filteredArticles = $article->GetUsersArticleResults("", "", "", $offset, $NB_ART_PAGE, \Session::Me()->getAttr('id'), 2);
        $total = $article->GetUsersArticleResults("", "", "", $offset, $NB_ART_PAGE, \Session::Me()->getAttr('id'), 0, true);
        foreach ($filteredArticles as $filteredArticle)	{
            $filteredArticle[1]->stars = $filteredArticle[1]->getNoteMoy($filteredArticle[1]->getAttr('id'));
            $filteredArticle[1]->catName = $filteredArticle[1]->getCatName();
            $filteredArticle[1]->mutumByDay = $filteredArticle[1]->getMutumByDay();
            $filteredArticle[1]->nbNotes = $filteredArticle[1]->getNbNotation($filteredArticle[1]->getAttr('id')) ;
            $filteredArticle[1]->state = 2 ;
        }
        return array('count' => count($filteredArticles), 'articles' => $filteredArticles, 'total' => $total);
    }


    public function execute() {
        return $this->{$this->method}();
    }


}