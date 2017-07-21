<?php

class OnCallAlertsPlaning {

    public $id;
    public $technician_id;
    public $monday;
    public $tuesday;
    public $wednesday;
    public $thursday;
    public $friday;
    public $saturday;
    public $sunday;
    public $start_time;
    public $end_time;
    public $note;
    public $_phone;
    private $_context;
    private $_join;

    public function __construct() {

        $this->_context = plugin_table("planing", "OnCallAlerts");
        $this->_join = plugin_table("technician", "OnCallAlerts");
    }

    public function fetchall() {

        $query =  "SELECT p.* "
                . "FROM {$this->_context} AS p "
                . "LEFT JOIN {$this->_join} AS t ON p.technician_id = t.id "
                . " ORDER By p.id DESC";
        return $this->_from_db_result(db_query($query));
    }

    public function save() {
        # create
        if ($this->id === null) {
            $query = "INSERT INTO {$this->_context}
				(
					technician_id,
                                        monday,
                                        tuesday,
                                        wednesday,
                                        thursday,
                                        friday,
                                        saturday,
                                        sunday,
                                        start_time,
                                        end_time,
					note
                                ) VALUES (
					" . db_param() . ",
					" . db_param() . ",
					" . db_param() . ",
					" . db_param() . ",
					" . db_param() . ",
					" . db_param() . ",
					" . db_param() . ",
					" . db_param() . ",
					" . db_param() . ",
					" . db_param() . ",
					" . db_param() . "
				)";

            $resultQuery = db_query_bound($query, array(
                $this->technician_id,
                $this->monday,
                $this->tuesday ,
                $this->wednesday ,
                $this->thursday ,
                $this->friday ,
                $this->saturday ,
                $this->sunday ,
                $this->start_time,
                $this->end_time,
                $this->note,
            ));
            if ($resultQuery)
                $this->id = db_insert_id($this->_context);

            return $resultQuery;

            # update
        } else {
            $query = "UPDATE {$this->_context} SET
				technician_id=" . db_param() . ",
                                monday=" . db_param() . ",
                                tuesday=" . db_param() . ",
                                wednesday=" . db_param() . ",
                                thursday=" . db_param() . ",
                                friday=" . db_param() . ",
                                saturday=" . db_param() . ",
                                sunday=" . db_param() . ",
                                start_time=" . db_param() . ",
                                end_time=" . db_param() . ",
				note=" . db_param() . ",
				WHERE id=" . db_param();

            $resultQuery = db_query_bound($query, array(
                $this->technician_id,
                $this->monday,
                $this->tuesday ,
                $this->wednesday ,
                $this->thursday ,
                $this->friday ,
                $this->saturday ,
                $this->sunday ,
                $this->start_time,
                $this->end_time,
                $this->note,
                $this->id,
            ));

            return $resultQuery;
        }
    }

    public function delete() {
        $query = "DELETE FROM {$this->_context} WHERE id=" . db_param();
        $resultQuery = db_query_bound($query, array($this->id));

        return $resultQuery;
    }

    public function getInPlaning()
    {
        $date = new \DateTime();
        $day = strtolower($date->format('l'));
        $time = $date->format('H:i:s');
        
        $query =  "SELECT * "
                . "FROM {$this->_context} AS p "
                . "LEFT JOIN {$this->_join} AS t ON p.technician_id = t.id "
                . "WHERE $day = 1 "
                . "AND start_time <= '$time' "
                . "AND end_time >= '$time' ";
        
         return $this->_from_db_result(db_query($query));
    }
    
    private function _from_db_result($result) {
        $contexts = array();

        while ($row = db_fetch_array($result)) {
            $context = new OnCallAlertsPlaning();
            $context->id = $row["id"];
            $context->technician_id = $row["technician_id"];
            $context->monday = $row["monday"];
            $context->tuesday = $row["tuesday"];
            $context->wednesday = $row["wednesday"];
            $context->thursday = $row["thursday"];
            $context->friday = $row["friday"];
            $context->saturday = $row["saturday"];
            $context->sunday = $row["sunday"];
            $context->start_time = $row["start_time"];
            $context->end_time = $row["end_time"];
            $context->note = $row["note"];
            $context->phone = $row["phone"];

            $contexts[$context->id] = $context;
        }

        return $contexts;
    }

}
