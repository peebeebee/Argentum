<?php
/**
 * Admin Time Controller
 *
 * @package    Argentum
 * @author     Argentum Team
 * @copyright  (c) 2008-2010 Argentum Team
 * @license    http://www.argentuminvoice.com/license.txt
 */
include Kohana::find_file('controllers', 'admin/admin_website');
class Time_Controller extends Admin_Website_Controller {

	/**
	 *  Creates a new time block on a ticket
	 */
	public function add($ticket_id)
	{
		$time = new Time_Model();
		$time->ticket_id = $ticket_id;

		if ( ! $_POST) // Display the form
		{
			$this->view->errors = '';
			$this->view->time = $time;
		}
		else
		{
			$time->set_fields($this->input->post());
			$time->user_id = $_SESSION['auth_user']->id;

			try
			{
				$time->save();

				if ($this->input->post('ticket_complete'))
				{
					$ticket = new Ticket_Model($time->ticket_id);
					$ticket->complete= TRUE;
					$ticket->close_date = time();
					$ticket->save();
					Event::run('argentum.ticket_close', $ticket);
				}

				Event::run('argentum.ticket_time', $time);
				url::redirect('ticket/'.($time->ticket->complete ? 'closed' : 'active').'/'.$time->ticket->project->id);
			}
			catch (Kohana_User_Exception $e)
			{
				$this->view->time = $time;
				$this->view->errors = $e;
				$this->view->set($this->input->post());
			}
		}
	}

	/**
	 *  Deletes a time item for a ticket
	 */
	public function delete()
	{
		$time = new Time_Model($this->input->post('id'));
		$time->delete();
		url::redirect('ticket/view/'.$time->ticket->id);
	}
}