<?php

class ProjectTicketState extends Model {

        const TABLE = 'tbl_project_ticket_state';

        public $primaryKey = array('project_id', 'ticket_type', 'ticket_state');

        public $hasMany = array(
            'Ticket' => array(
                'foreign_key' => array('project_id', 'ticket_type', 'ticket_state')
            )
        );

        public function nextState() {
            return self::getNextState($this['project_id'], $this['ticket_type'], $this['ticket_state']);
        }

        public function previousState() {
            return self::getPreviousState($this['project_id'], $this['ticket_type'], $this['ticket_state']);
        }

        public static function getNextState($project_id, $ticket_type, $ticket_state) {
            Database::$Instance->query('SELECT * FROM ticket_state_next(?, ?, ?)', [$project_id, $ticket_type, $ticket_state]);
            return Database::$Instance->fetchRow();
        }

        public static function getPreviousState($project_id, $ticket_type, $ticket_state) {
            Database::$Instance->query('SELECT * FROM ticket_state_previous(?, ?, ?)', [$project_id, $ticket_type, $ticket_state]);
            return Database::$Instance->fetchRow();
        }
}

?>