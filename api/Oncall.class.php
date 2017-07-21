<?php

class OnCallAlertsOncall {

    public $id;
    public $technician_id;
    public $start_date;
    public $end_date;
    public $note;
    public $phone;
    private $_context;
    private $_join;

    public function __construct() {

        $this->_context = plugin_table("oncall", "OnCallAlerts");
        $this->_join = plugin_table("technician", "OnCallAlerts");
    }

    public function fetchall() {

        $query = "SELECT * FROM {$this->_context} ORDER By start_date DESC";
        return $this->_from_db_result(db_query($query));
    } 

    public function getByDate($startDate,$endDate) {

        $query = "SELECT * FROM {$this->_context} "
                . "WHERE DATE(start_date) >= '$startDate' AND DATE(start_date) <= '$endDate'"
                . "ORDER By start_date DESC";
        
        return $this->_from_db_result(db_query($query));
    }
    
    public function getById($id) 
    {
        $query = "SELECT * FROM {$this->_context} WHERE id = {$id}";
        return $this->_from_db_result(db_query($query))[1];
    }
    
    public function save() {
        # create
        if ($this->id === null) {
            $query = "INSERT INTO {$this->_context}
				(
					technician_id,
					start_date,
					end_date,
					note
                                ) VALUES (
					" . db_param() . ",
					" . db_param() . ",
					" . db_param() . ",
					" . db_param() . "
				)";

            $resultQuery = db_query_bound($query, array(
                $this->technician_id,
                $this->start_date,
                $this->end_date,
                $this->note,
            ));
            if ($resultQuery)
                $this->id = db_insert_id($this->_context);

            return $resultQuery;

            # update
        } else {
            $query = "UPDATE {$this->_context} SET
				technician_id=" . db_param() . ",
				start_date=" . db_param() . ",
				end_date=" . db_param() . ",
				note=" . db_param() . ",
				WHERE id=" . db_param();

            $resultQuery = db_query_bound($query, array(
                $this->technician_id,
                $this->start_date,
                $this->end_date,
                $this->note,
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

    public function getInOnCall()
    {
        $date = new \DateTime();
        $time = $date->format('Y-m-d H:i:s');
        
        $query =  "SELECT * "
                . "FROM {$this->_context} AS o "
                . "LEFT JOIN {$this->_join} AS t ON o.technician_id = t.id "
                . "WHERE start_date <= '$time' "
                . "AND end_date >= '$time' ";
        
         return $this->_from_db_result_join(db_query($query));
    }
    
    private function _from_db_result($result) {
        $contexts = array();

        while ($row = db_fetch_array($result)) {
            $context = new OnCallAlertsOncall();
            $context->id = $row["id"];
            $context->technician_id = $row["technician_id"];
            $context->start_date = $row["start_date"];
            $context->end_date = $row["end_date"];
            $context->note = $row["note"];

            $contexts[$context->id] = $context;
        }

        return $contexts;
    }
        private function _from_db_result_join($result) {
        $contexts = array();

        while ($row = db_fetch_array($result)) {
            $context = new OnCallAlertsOncall();
            $context->id = $row["id"];
            $context->technician_id = $row["technician_id"];
            $context->start_date = $row["start_date"];
            $context->end_date = $row["end_date"];
            $context->note = $row["note"];
            $context->phone = $row["phone"];

            $contexts[$context->id] = $context;
        }

        return $contexts;
    }
}
