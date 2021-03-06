<?php
/*"******************************************************************************************************
*   (c) 2018 ARTEMEON                                                                                   *
*       Published under the GNU LGPL v2.1                                                               *
********************************************************************************************************/

declare(strict_types=1);

namespace Kajona\System\View\Components\Formentry\Objectselector;

use Kajona\System\System\Carrier;
use Kajona\System\System\Link;
use Kajona\System\System\Root;
use Kajona\System\View\Components\Formentry\FormentryComponentAbstract;

/**
 * General formentry which can be used to select a specific object. By default it uses the search engine endpoint to
 * find the fitting objects but you can also provide a custom endpoint. It is also possible to specify object types.
 *
 * @author christoph.kappestein@artemeon.de
 * @since 7.1
 * @componentTemplate core/module_system/view/components/formentry/objectselector/template.twig
 */
class Objectselector extends FormentryComponentAbstract
{
    /**
     * @var string
     */
    protected $endpointUrl;

    /**
     * @var Root
     */
    protected $object;

    /**
     * @var string
     */
    protected $addLink;

    /**
     * @var array
     */
    protected $objectTypes;

    /**
     * @param string $name
     * @param string $title
     * @param string $endpointUrl
     * @param string $object
     * @param Root|null $object
     */
    public function __construct(string $name, string $title, string $endpointUrl = null, Root $object = null)
    {
        parent::__construct($name, $title);

        $this->endpointUrl = $endpointUrl;
        $this->object = $object;
    }

    /**
     * @param string $addLink
     */
    public function setAddLink(string $addLink)
    {
        $this->addLink = $addLink;
    }

    /**
     * @param array $objectTypes
     */
    public function setObjectTypes(array $objectTypes)
    {
        $this->objectTypes = $objectTypes;
    }

    /**
     * @inheritdoc
     */
    public function buildContext()
    {
        $context = parent::buildContext();

        $toolkit = Carrier::getInstance()->getObjToolkit("admin");
        $resetLink = $toolkit->listButton(Link::getLinkAdminManual(
            "href=\"#\" onclick=\"\$('#" . $this->name . "').val('');\$('#" . $this->name . "_id').val('');return false;\"",
            "",
            Carrier::getInstance()->getObjLang()->getLang("object_browser_reset", "system"),
            "icon_delete"
        ));

        $endpointUrl = $this->endpointUrl;
        if (empty($this->endpointUrl)) {
            $endpointUrl = _webpath_."/xml.php?admin=1&module=search&action=searchXml&asJson=1";
        }

        $context["endpoint_url"] = $endpointUrl;
        $context["object"] = $this->object;
        $context["add_link"] = $this->addLink;
        $context["reset_link"] = $resetLink;
        $context["object_types"] = !empty($this->objectTypes) ? json_encode($this->objectTypes) : 'null';

        return $context;
    }
}
