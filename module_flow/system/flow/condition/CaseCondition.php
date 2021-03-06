<?php
/*"******************************************************************************************************
*   (c) 2010-2017 ARTEMEON                                                                              *
********************************************************************************************************/

declare(strict_types=1);

namespace Kajona\Flow\System\Flow\Condition;

use Kajona\Flow\System\FlowConditionAbstract;
use Kajona\Flow\System\FlowConditionInterface;
use Kajona\Flow\System\FlowConditionResult;
use Kajona\Flow\System\FlowTransition;
use Kajona\System\Admin\AdminFormgenerator;
use Kajona\System\System\Model;

/**
 * A meta condition which can be used to apply a condition only in a specific case. Therefor the condition uses the
 * first condition which is stored below this condition to check whether we should validate the second condition. In
 * case you need to execute multiple conditions you can use a group condition
 *
 * @author christoph.kappestein@artemeon.de
 * @since 7.1
 */
class CaseCondition extends FlowConditionAbstract
{
    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return $this->getLang("flow_condition_case_title", "contracts");
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return $this->getLang("flow_condition_case_description", "contracts");
    }

    /**
     * Returns true in case the user is in a specific user group
     *
     * @param Model $object
     * @param FlowTransition $transition
     * @return FlowConditionResult
     */
    public function validateCondition(Model $object, FlowTransition $transition)
    {
        $conditions = $this->getChildConditions();
        $leftCondition = array_shift($conditions);
        $rightCondition = array_shift($conditions);

        if ($leftCondition instanceof FlowConditionInterface && $rightCondition instanceof FlowConditionInterface) {
            if ($leftCondition->validateCondition($object, $transition)->isValid()) {
                // we validate the right condition only in case the left condition is true
                return $rightCondition->validateCondition($object, $transition);
            }
        }

        return new FlowConditionResult(true);
    }

    /**
     * @inheritdoc
     */
    public function configureForm(AdminFormgenerator $form)
    {
    }
}

