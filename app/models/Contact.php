<?php


class Contact extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contact';

	public $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getName()
	{
		return $this->getName();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getData()
	{
		return $this->Data;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->Email;
	}

}