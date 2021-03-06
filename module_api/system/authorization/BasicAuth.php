<?php
/*"******************************************************************************************************
 *   (c) ARTEMEON Management Partner GmbH
 *       Published under the GNU LGPL v2.1
 ********************************************************************************************************/

namespace Kajona\Api\System\Authorization;

use Kajona\Api\System\AuthorizationInterface;
use Kajona\System\System\Session;
use Slim\Http\Request;

/**
 * Just a POC please dont use it since it starts a PHP session which makes your API stateful
 *
 * @author christoph.kappestein@artemeon.de
 * @since 7.1
 * @internal
 */
class BasicAuth implements AuthorizationInterface
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @inheritdoc
     */
    public function isAuthorized(Request $request): bool
    {
        $header = explode(" ", $request->getHeaderLine("Authorization"), 2);
        $type = $header[0] ?? null;
        $auth = $header[1] ?? null;

        $parts = explode(":", base64_decode($auth));
        $username = $parts[0] ?? null;
        $password = $parts[1] ?? null;

        if ($type !== "Basic") {
            return false;
        }

        if (!$this->session->login($username, $password)) {
            return false;
        }

        return true;
    }
}
