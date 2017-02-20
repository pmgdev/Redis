<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Redis;



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
interface Exception
{

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class InvalidArgumentException extends \InvalidArgumentException implements Exception
{

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class MissingExtensionException extends \RuntimeException implements Exception
{

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class ConnectionException extends \RuntimeException implements Exception
{

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class SessionHandlerException extends \RuntimeException implements Exception
{

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class RedisClientException extends \RuntimeException implements Exception
{

	/**
	 * @var string
	 */
	public $request;

	/**
	 * @var string
	 */
	public $response;

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class TransactionException extends RedisClientException implements Exception
{

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class LockException extends RedisClientException
{

	const PROCESS_TIMEOUT = 1;
	const ACQUIRE_TIMEOUT = 2;



	/**
	 * @return LockException
	 */
	public static function highConcurrency()
	{
		return new static("Lock couldn't be acquired. Concurrency is way too high. I died of old age.", self::PROCESS_TIMEOUT);
	}



	/**
	 * @return LockException
	 */
	public static function acquireTimeout()
	{
		return new static("Lock couldn't be acquired. The locking mechanism is giving up. You should kill the request.", self::ACQUIRE_TIMEOUT);
	}



	/**
	 * @return LockException
	 */
	public static function zeroTimeout()
	{
		return new static("Timeout cannot be less than or equal to 0.");
	}



	/**
	 * @return LockException
	 */
	public static function timeoutGreaterThanDuration()
	{
		return new static("Timeout cannot be greater than duration.");
	}



	/**
	 * @return LockException
	 */
	public static function durabilityTimedOut()
	{
		return new static("Process ran too long. Increase lock duration, or extend lock regularly.");
	}



	/**
	 * @return LockException
	 */
	public static function noExpirationTime()
	{
		return new static("Lock has no expiration time.");
	}



	/**
	 * @param int $code
	 * @return LockException
	 */
	public static function unsupportedErrorCode($code)
	{
		return new static("Unsupported error code $code from EXTEND script.");
	}

}
