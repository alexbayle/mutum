<?php

namespace listener\observer;

use SplSubject;

class success implements \SplObserver
{
    public function update(SplSubject $action)
    {
        $controller = $action->getParent();
        $klass = get_class($controller);

        switch ($klass) {
            case 'Controller\NewController':
                $nbProducts = count(\Session::Me()->getArticles());
                $code = sprintf("new.%d", $nbProducts);
                $user = \Session::Me();
                break;
            case 'Controller\RegisterController':
                $code = 'register';
                $user = $controller->getUser();
                break;
            default:
                throw new \Exception(sprintf("Manager for '%s' should be implemented.", $klass));
        }

        $achievement = \DB::SqlToObj(array('achievements'), "SELECT * FROM achievements a WHERE achi_condition='{$code}'");
        if (count($achievement)) {
            $achievement = $achievement[0][0];
        }
        if (!$achievement) {
            return false;
        }

        $user->addCredit($achievement->achi_win);
        $user->addScore($achievement->achi_win);
        $user->Update();

        $action->attach(new \listener\observer\history($achievement->achi_win));

        if ($achievement->isAlreadyDoneByUser($user->user_id)) {
            return false;
        }

        $success = new \success_achievements();
        $success->suca_user_id = (int)$user->user_id;
        $success->suca_achi_id = (int)$achievement->achi_id;
        $success->suca_created_at = date('Y-m-d H:i:s');
        $success->Insert();
    }
}