<?php

class OnCallAlertsTechnician {

    public $id;
    public $name;
    public $phone;
    private $_context;

    public function __construct() {

        $this->_context = plugin_table("technician", "OnCallAlerts");
    }

    public function fetchall() {

        $query = "SELECT * FROM {$this->_context} ORDER By name DESC";
        return $this->_from_db_result(db_query($query));
    }
    
    public function getById($idTech) 
    {
        $query = "SELECT * FROM {$this->_context} WHERE id = '{$idTech}'";
        return $this->_from_db_result(db_query($query))[$idTech];
    }

    public function save() {
        # create
        if ($this->id === null) {
            $query = "INSERT INTO {$this->_context}
				(
					name,
					phone
                                ) VALUES (
					" . db_param() . ",
					" . db_param() . "
				)";

            $resultQuery = db_query_bound($query, array(
                $this->name,
                $this->phone
            ));
            if ($resultQuery)
                $this->id = db_insert_id($this->_context);

            return $resultQuery;

            # update
        } else {
            $query = "UPDATE {$this->_context} SET
				name =" . db_param() . ",
				phone =" . db_param() . "
				WHERE id=" . db_param();

            $resultQuery = db_query_bound($query, array(
                $this->name,
                $this->phone,
                $this->id
            ));

            return $resultQuery;
        }
    }

    public function delete() {
        $query = "DELETE FROM {$this->_context} WHERE id=" . db_param();
        $resultQuery = db_query_bound($query, array($this->id));

        return $resultQuery;
    }

    private function _from_db_result($result) {
        $contexts = array();

        while ($row = db_fetch_array($result)) {
            $context = new OnCallAlertsTechnician();
            $context->id = $row["id"];
            $context->name = $row["name"];
            $context->phone = $row["phone"];

            $contexts[$context->id] = $context;
            
        }

        return $contexts;
    }

}
