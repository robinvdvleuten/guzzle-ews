<?php

namespace Rvdv\Ews;

use Guzzle\Common\Collection;
use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Http\StaticClient;

/**
 * Client
 *
 * @author Robin van der Vleuten <robinvdvleuten@gmail.com>
 */
class Client extends \SoapClient
{
    /**
     * Microsoft Exchange 2007
     *
     * @var string
     */
    const VERSION_2007 = 'Exchange2007';

    /**
     * Microsoft Exchange 2007 SP1
     *
     * @var string
     */
    const VERSION_2007_SP1 = 'Exchange2007_SP1';

    /**
     * Microsoft Exchange 2007 SP2
     *
     * @var string
     */
    const VERSION_2007_SP2 = 'Exchange2007_SP2';

    /**
     * Microsoft Exchange 2007 SP3
     *
     * @var string
     */
    const VERSION_2007_SP3 = 'Exchange2007_SP3';

    /**
     * Microsoft Exchange 2010
     *
     * @var string
     */
    const VERSION_2010 = 'Exchange2010';

    /**
     * Microsoft Exchange 2010 SP1
     *
     * @var string
     */
    const VERSION_2010_SP1 = 'Exchange2010_SP1';

    /**
     * Microsoft Exchange 2010 SP2
     *
     * @var string
     */
    const VERSION_2010_SP2 = 'Exchange2010_SP2';

    /**
     * @var Guzzle\Http\Client
     */
    private $guzzleClient;

    public function __construct($server, $username, $password, $version = self::VERSION_2007)
    {
        parent::__construct(__DIR__.'/../../../php-ews/wsdl/services.wsdl', array(
            'user' => $username,
            'password' => $password,
            'version' => $version,
            'location' => 'https://'.$server.'/EWS/Exchange.asmx',
            // 'impersonation' => $this->impersonation,
        ));

        $this->guzzleClient = new GuzzleClient('https://'.$server.'/EWS/Exchange.asmx', array(
            'request.options' => array(
                'auth' => array($username, $password, 'Any'),
                'verify' => false,
            ),
            'curl.options' => array(
                'body_as_string' => true,
            ),
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function __doRequest($request, $location, $action, $version, $oneWay = 0)
    {
        $headers = array(
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction' => $action,
        );

        $response = $this->guzzleClient->post($location, $headers, $request)->send();

        return $response->getBody(true);
    }
}
