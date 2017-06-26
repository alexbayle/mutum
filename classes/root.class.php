<?php

class root
{

    function __construct()
    {
    }

    function Create($tab)
    {
        $attr = array_keys(get_object_vars($this));
        for ($i = 0; $i < sizeof($attr); $i++) {
            if (isset($tab[$attr[$i]])) {
                $this->$attr[$i] = $tab[$attr[$i]];
            }
        }
    }

    function getParentsPref()
    {
        $tab_parent = class_parents(get_class($this));
        $tab_pref = array();
        foreach ($tab_parent as $t) {
            if ($t != 'root') {
                array_push($tab_pref, $t::getStaticPref());
            }
        }

        return $tab_pref;
    }

    function getAttr($attr)
    {
        $pref = $this->getPref();
        $var = $pref . $attr;
        $tab_var = array_keys(get_object_vars($this));
        if (in_array($var, $tab_var)) {
            return $this->$var;
        } else {
            foreach ($this->getParentsPref() as $t) {
                $var = $t . $attr;
                if (in_array($var, $tab_var)) {
                    return $this->$var;
                }
            }
        }
    }

    function CreateMyTrueParent()
    {
        $tab_parent = array_keys(class_parents(get_class($this)));
        if (sizeof($tab_parent) > 1) {
            $name_parent = $tab_parent[0];
            $obj_parent = new $name_parent();
            $tab_var_parent = array_keys(get_object_vars($obj_parent));
            foreach ($tab_var_parent as $t) {
                $obj_parent->$t = $this->$t;
            }

            return $obj_parent;
        } else {
            return false;
        }
    }

    function Insert()
    {
        $obj_parent = $this->CreateMyTrueParent();
        if ($obj_parent != false) {
            try {
                $return_id = $obj_parent->Insert();
            } catch (Exception $e) {
                var_dump($e->getMessage());
                var_dump($obj_parent);
                die;
            }
        }

        if (@$return_id == '') {
            $attr = array_keys(get_object_vars($this));
            foreach ($attr as $offset => $attr_element) {
                if (isset(static::$exclusion)) {
                    if (in_array($attr_element, static::$exclusion)) {
                        unset($attr[$offset]);
                    }
                }
//                if (static::$pref . 'id' == $attr_element) {
//                    unset($attr[$offset]);
//                }
            }
            $attr = array_merge($attr, array());
        } else {
            if ($obj_parent != '') {
                //Attributs du parent
                $attr_parent = array_keys(get_object_vars($obj_parent));
                //Attributs du actuel
                $attr = array_keys(get_object_vars($this));
                //virer les cl�s similaires entre parent et actuel
//                array_splice($attr, sizeof($attr) - sizeof($attr_parent), sizeof($attr_parent));
                foreach ($attr as $offset => $attr_element) {
                    $prefix = static::$pref;
                    if (!preg_match("/^$prefix/", $attr_element)) {
                        unset($attr[$offset]);
                    }
                }
                $foreign_key_id = $this->getParentsPref()[0] . 'id';
                $this->setAttr($foreign_key_id, $return_id);
            }
        }
        $dotliste = '';
        for ($i = 0; $i < sizeof($attr); $i++) {
            $dotliste .= ':' . $attr[$i];
            if ($i < sizeof($attr) - 1) {
                $dotliste .= ',';
            }
        }

//        var_dump($dotliste);
        $req = DB::getInstance()->getPDO()->prepare(
            "INSERT INTO " . DBPRE . get_class($this) . " VALUES (" . $dotliste . ")"
        );
        for ($i = 0; $i < sizeof($attr); $i++) {
            $temp = ':' . $attr[$i];
            $req->bindParam($temp, $this->$attr[$i]);
//            if ($this instanceof post) {
//                var_dump($temp, $this->$attr[$i]);
//            }

//            var_dump($temp . ' : ' . $this->$attr[$i]);
        }

        if (!$req->execute()) {
            var_dump('erreur');die;
        }
        if (@$return_id == '') {
            $return_id = DB::LastId();
        }

        return $return_id;
    }


    function Update()
    {
        $obj_parent = $this->CreateMyTrueParent();
        $pref = $this->getPref();
        if ($obj_parent != false) {
            $obj_parent->Update();
        }
        if ($obj_parent != false) {
            //Attributs du parent
            $attr_parent = array_keys(get_object_vars($obj_parent));
            //Attributs du actuel
            $attr = array_keys(get_object_vars($this));
            //virer les cl�s similaires entre parent et actuel
//            array_splice($attr, sizeof($attr) - sizeof($attr_parent), sizeof($attr_parent));
            foreach ($attr as $offset => $attr_element) {
                $prefix = static::$pref;
                if (!preg_match("/^$prefix/", $attr_element)) {
                    unset($attr[$offset]);
                }
            }
            //r�cup�rer le nom de la cl� �trang�re unique
            $foreign_key_id = $this->getParentsPref()[0] . 'id';
        } else {
            $attr = array_keys(get_object_vars($this));
            $foreign_key_id = 'id';
        }
        $dotliste = [];
        for ($i = 0; $i < sizeof($attr); $i++) {
            if (preg_match("/^$pref/", $attr[$i]) && $attr[$i] != $pref . $foreign_key_id) {
                $dotliste[] = $attr[$i] . ' = :' . $attr[$i];
            }
        }
        $dotliste = implode(',', $dotliste);

        $req = DB::getInstance()->getPDO()->prepare(
            "UPDATE " . DBPRE . get_class(
                $this
            ) . " SET " . $dotliste . " WHERE " . $pref . $foreign_key_id . "=" . $this->getAttr($foreign_key_id)
        );
        for ($i = 0; $i < sizeof($attr); $i++) {
            if ($attr[$i] != $pref . $foreign_key_id) {
                $temp = ':' . $attr[$i];
                $req->bindParam(':' . $attr[$i], $this->$attr[$i]);
            }
        }
        $req->execute();
    }

    public static function Get($tab)
    {
        $class = get_called_class();
        $obj = new $class;
        $obj->Create($tab);

        return $obj;
    }

    public static function Get_Tab($tab)
    {
        $class = get_called_class();
        $obj_tab = array();
        foreach ($tab as $t) {
            array_push($obj_tab, $class::Get($t));
        }

        return $obj_tab;
    }

    function setAttr($attr, $value)
    {
        $pref = $this->getPref();
        $var = $pref . $attr;
        $tab_var = array_keys(get_object_vars($this));
        if (in_array($var, $tab_var)) {
            $this->$var = $value;
        } else {
            foreach ($this->getParentsPref() as $t) {
                $var = $t . $attr;
                if (in_array($var, $tab_var)) {
                    $this->$var = $value;
                }
            }
        }
    }

    public static function getAll($order = null)
    {
        if (is_array($order)) {
            $order = sprintf("ORDER BY %s %s", key($order), current($order));
        }
        return DB::SqlToArray("select * from " . DBPRE . get_called_class() . ' ' . $order);
    }

    public static function getById($id)
    {
        return DB::SqlToObj(
            array(get_called_class()),
            sprintf("select * from %s where `%sid`='%s'", get_called_class(), static::$pref, $id)
        );
    }

    public function getPref()
    {
        $class = get_class($this);

        return $class::$pref;
    }

    public static function getStaticPref()
    {
        $class = get_called_class();

        return $class::$pref;
    }

    public static function getListAttr()
    {
        $class = get_called_class();
        $obj = new $class;
        $attr = array_keys(get_object_vars($obj));
        $list = '';
        foreach ($attr as $a) {
            $list .= $a . ',';
        }

        return substr($list, 0, strlen($list) - 1);
    }

}