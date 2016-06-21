<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2016 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\Core\Mailer;

use Windwalker\Core\Event\EventDispatcher;
use Windwalker\Core\Mailer\Adapter\MailerAdapterInterface;
use Windwalker\Event\DispatcherAwareTrait;

/**
 * The Mailer class.
 *
 * @since  {DEPLOY_VERSION}
 */
class MailerManager
{
	use DispatcherAwareTrait;

	/**
	 * Property adapter.
	 *
	 * @var  MailerAdapterInterface
	 */
	protected $adapter;

	/**
	 * Property messageClass.
	 *
	 * @var  string
	 */
	protected $messageClass = MailMessage::class;

	/**
	 * Mailer constructor.
	 *
	 * @param MailerAdapterInterface $adapter
	 * @param EventDispatcher        $dispatcher
	 */
	public function __construct(MailerAdapterInterface $adapter = null, EventDispatcher $dispatcher = null)
	{
		$this->adapter = $adapter;
		$this->dispatcher = $dispatcher;
	}

	/**
	 * createMessage
	 *
	 * @param string $subject
	 * @param string $content
	 * @param bool   $html
	 *
	 * @return  MailMessage
	 */
	public function createMessage($subject = null, $content = null, $html = true)
	{
		$class = $this->messageClass;

		$message = new $class($subject, $content, $html);

		$this->triggerEvent('onMailerAfterCreateMessage', [
			'message' => $message,
			'manager' => $this
		]);

		return $message;
	}

	/**
	 * send
	 *
	 * @param MailMessage $message
	 *
	 * @return  boolean
	 */
	public function send(MailMessage $message)
	{
		$this->triggerEvent('onMailerBeforeSend', [
			'message' => $message,
			'manager' => $this
		]);

		return $this->getAdapter()->send($message);
	}

	/**
	 * Method to set property messageClass
	 *
	 * @param   mixed $messageClass
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setMessageClass($messageClass)
	{
		$this->messageClass = $messageClass;

		return $this;
	}

	/**
	 * Method to get property Adapter
	 *
	 * @return  MailerAdapterInterface
	 */
	public function getAdapter()
	{
		return $this->adapter;
	}

	/**
	 * Method to set property adapter
	 *
	 * @param   MailerAdapterInterface $adapter
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setAdapter(MailerAdapterInterface $adapter)
	{
		$this->adapter = $adapter;

		return $this;
	}
}
