<?php namespace Philo\Twitter;

use Config;

class Twitter extends \TijsVerkoyen\Twitter\Twitter{

	/**
	 * Default constructor
	 *
	 * @param string $consumerKey    The consumer key to use.
	 * @param string $consumerSecret The consumer secret to use.
	 */
	public function __construct()
	{
	    $this->setConsumerKey( Config::get('twitter::CONSUMER_KEY') );
	    $this->setConsumerSecret( Config::get('twitter::CONSUMER_SECRET') );
	}

}
