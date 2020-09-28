<?php

namespace purt09\interkassa\Interkassa;

/**
 * Interkassa API for PHP
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT-style license
 * @package Interkassa
 * @author Anton Suprun <kpobococ@gmail.com>
 * @version 1.0.0
 */

/**
 * Interkassa shop class
 *
 * This class represents a shop. It holds shop id and secret key. It also has
 * several convenience methods to work with the API.
 *
 * @license MIT-style license
 * @package Interkassa
 * @author Anton Suprun <kpobococ@gmail.com>
 * @version 1.0.0
 */
class InterkassaShop
{
    /**
     * Shop id
     *
     * @var string
     */
    protected $_id;

    /**
     * Secret key
     *
     * @var string
     */
    protected $_secret_key;

    /**
     * Factory method
     *
     * @param array $options
     *
     * @see InterkassaShop::__construct()
     *
     * @return InterkassaShop
     */
    public static function factory(array $options)
    {
        return new InterkassaShop($options);
    }

    /**
     * Constructor
     *
     * Accepted configuration options are:
     * - id - your interkassa shop id;
     * - secret_key - your interkassa secret key. Used to parse status requests;
     *
     * @param array $options shop configuration. See above
     *
     * @throws InterkassaException if any option values are missing
     */
    public function __construct(array $options)
    {
        if (!isset($options['id'])) {
            throw new InterkassaException('Shop id is required');
        }

        if (!isset($options['secret_key'])) {
            throw new InterkassaException('Secret key is required');
        }

        $this->_id         = $options['id'];
        $this->_secret_key = $options['secret_key'];
    }

    /**
     * Create shop payment instance
     *
     * @param array $data payment data
     *
     * @see InterkassaPayment::__construct()
     *
     * @return InterkassaPayment
     */
    public function createPayment(array $data)
    {
        return InterkassaPayment::factory($this, $data);
    }

    /**
     * Receive shop status data
     *
     * @param array $source source array to use. Defaults to $_REQUEST
     *
     * @return InterkassaStatus
     *
     * @see InterkassaStatus::__construct()
     *
     * @throws InterkassaException if received shop id does not match current shop id
     */
    public function receiveStatus(array $source = null)
    {
        if ($source == null) {
            $source = $_REQUEST;
        }

        return InterkassaStatus::factory($this, $source);
    }

    /**
     * Get shop id
     *
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Get secret key
     *
     * @return string
     */
    public function getSecretKey()
    {
        return $this->_secret_key;
    }
}
