<?php

namespace Kajona\System\Tests;

use Kajona\System\System\Carrier;
use Kajona\System\System\Database;
use Kajona\System\System\Exception;
use Kajona\System\System\Lifecycle\ServiceLifeCycleFactory;
use Kajona\System\System\Lifecycle\ServiceLifeCycleUpdateException;
use Kajona\System\System\Objectfactory;
use Kajona\System\System\Root;
use Kajona\System\System\SystemAspect;

class SystemTest extends Testbase
{


    /**
     * @throws Exception
     * @throws ServiceLifeCycleUpdateException
     */
    public function testKernel()
    {
        $objDB = Carrier::getInstance()->getObjDB();

        //--- system kernel -------------------------------------------------------------------------------------

        //nr of records currently
        $arrRow = $objDB->getPRow("SELECT COUNT(*) AS cnt FROM agp_system", array(), 0, false);
        $intNrSystemRecords = $arrRow["cnt"];
        $objAspect = new SystemAspect();
        $arrSysRecords = array();
        for ($intI = 0; $intI <= 100; $intI++) {
            $objAspect = new SystemAspect();
            ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect);
            $arrSysRecords[] = $objAspect->getSystemid();

            $arrRow = $objDB->getPRow("SELECT COUNT(*) AS cnt FROM agp_system", array(), 0, false);
            $this->assertEquals($arrRow["cnt"], $intI + $intNrSystemRecords + 1, __FILE__ . " checkCreateSysRecordsWithRights");
        }


        foreach ($arrSysRecords as $strOneId) {
            $objAspect = new SystemAspect($strOneId);
            $objAspect->deleteObjectFromDatabase();
        }
        $arrRow = $objDB->getPRow("SELECT COUNT(*) AS cnt FROM agp_system", array(), 0, false);
        $this->assertEquals($arrRow["cnt"], $intNrSystemRecords, __FILE__ . " checkDeleteSysRecordsWithRights");

    }


    /**
     * @throws Exception
     * @throws ServiceLifeCycleUpdateException
     */
    function testSectionHandling()
    {

        $objDB = Carrier::getInstance()->getObjDB();

        //test sections
        //create 10 test records
        $objAspect = new SystemAspect();
        //new base-node
        ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect);
        $strBaseNodeId = $objAspect->getSystemid();
        $arrNodes = array();
        for ($intI = 1; $intI <= 10; $intI++) {
            $objAspect = new SystemAspect();
            $objAspect->setStrName("sectionTest_" . $intI);
            ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, $strBaseNodeId);
            $arrNodes[] = $objAspect->getSystemid();
        }
        $arrNodes = $objDB->getPArray("SELECT system_id FROM agp_system WHERE system_prev_id = ? ORDER BY system_sort ASC", array($strBaseNodeId));
        $arrNodesSection = $objDB->getPArray("SELECT system_id FROM agp_system WHERE system_prev_id = ? ORDER BY system_sort ASC", array($strBaseNodeId), 2, 4, false);
        $this->assertEquals($arrNodesSection[0]["system_id"], $arrNodes[2]["system_id"], __FILE__ . " checkSectionLoading");
        $this->assertEquals($arrNodesSection[1]["system_id"], $arrNodes[3]["system_id"], __FILE__ . " checkSectionLoading");
        $this->assertEquals($arrNodesSection[2]["system_id"], $arrNodes[4]["system_id"], __FILE__ . " checkSectionLoading");

        //deleting all records created
        foreach ($arrNodes as $arrOneNode) {
            $objAspect = new SystemAspect($arrOneNode["system_id"]);
            $objAspect->deleteObjectFromDatabase();
        }
        $objAspect = new SystemAspect($strBaseNodeId);
        $objAspect->deleteObjectFromDatabase($strBaseNodeId);
    }


    /**
     * @throws Exception
     * @throws ServiceLifeCycleUpdateException
     */
    function testTreeBehaviour()
    {


        $objDB = Carrier::getInstance()->getObjDB();
        //nr of records currently
        $arrSysRecords = array();
        $arrRow = $objDB->getPRow("SELECT COUNT(*) AS cnt FROM agp_system", array(), 0, false);
        $intNrSystemRecords = $arrRow["cnt"];
        //base-id
        $objAspect = new SystemAspect();
        ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect);
        $intBaseId = $objAspect->getSystemid();
        //two under the base
        $objAspect = new SystemAspect();
        ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, $intBaseId);
        $intSecOneId = $objAspect->getSystemid();
        $objAspect = new SystemAspect();
        ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, $intBaseId);
        $intSecTwoId = $objAspect->getSystemid();
        $arrSysRecords[] = $intBaseId;
        $arrSysRecords[] = $intSecOneId;
        $arrSysRecords[] = $intSecTwoId;
        //twenty under both levels
        for ($intI = 0; $intI < 20; $intI++) {
            $objAspect = new SystemAspect();
            ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, $intSecOneId);
            $arrSysRecords[] = $objAspect->getSystemid();
            $objAspect = new SystemAspect();
            ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, $intSecTwoId);
            $arrSysRecords[] = $objAspect->getSystemid();
            $objAspect = new SystemAspect();
            ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, $intBaseId);
            $arrSysRecords[] = $objAspect->getSystemid();
        }
        //check nr of records
        $intCount = $objAspect->getNumberOfSiblings($intSecOneId);
        $this->assertEquals($intCount, 22, __FILE__ . " checkNrOfSiblingsInTree");
        //check nr of childs
        $arrRow = $objDB->getPRow("SELECT COUNT(*) AS cnt FROM agp_system WHERE system_prev_id = ?", array($intBaseId));
        $this->assertEquals($arrRow["cnt"], 22, __FILE__ . " checkNrOfChildsInTree1");
        $arrRow = $objDB->getPRow("SELECT COUNT(*) AS cnt FROM agp_system WHERE system_prev_id = ?", array($intSecOneId));
        $this->assertEquals($arrRow["cnt"], 20, __FILE__ . " checkNrOfChildsInTree2");
        $arrRow = $objDB->getPRow("SELECT COUNT(*) AS cnt FROM agp_system WHERE system_prev_id = ?", array($intSecTwoId));
        $this->assertEquals($arrRow["cnt"], 20, __FILE__ . " checkNrOfChildsInTree3");

        //deleting all records
        foreach ($arrSysRecords as $strOneId) {
            if (Objectfactory::getInstance()->getObject($strOneId) !== null) {
                Objectfactory::getInstance()->getObject($strOneId)->deleteObjectFromDatabase();
            }
        }

    }

    public function testIsValidSystemidChildNode()
    {
        $objAspect = new SystemAspect();
        ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, "0");
        $strRootNodeId = $objAspect->getSystemid();

        $objAspect = new SystemAspect();
        ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, $strRootNodeId);
        $strSub1Node1Id = $objAspect->getSystemid();

        $objAspect = new SystemAspect();
        ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, $strRootNodeId);
        $strSub1Node2Id = $objAspect->getSystemid();

        $objAspect = new SystemAspect();
        ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, $strRootNodeId);
        $strSub1Node2Id = $objAspect->getSystemid();

        $reflection = new \ReflectionClass(Root::class);
        $method = new \ReflectionMethod(Root::class, "isSystemidChildNode");

        $method->setAccessible(true);
        $this->assertTrue($method->invoke($objAspect, $strRootNodeId, $strSub1Node1Id));
        $this->assertTrue($method->invoke($objAspect, $strRootNodeId, $strSub1Node2Id));
        $this->assertFalse($method->invoke($objAspect, $strSub1Node1Id, $strRootNodeId));
        $this->assertFalse($method->invoke($objAspect, $strSub1Node1Id, $strSub1Node2Id));

        $this->assertFalse($method->invoke($objAspect, generateSystemid(), $strSub1Node2Id));
        $this->assertFalse($method->invoke($objAspect, generateSystemid(), generateSystemid()));


        $objAspect = new SystemAspect($strRootNodeId);
        $objAspect->deleteObjectFromDatabase();
        Database::getInstance()->flushQueryCache();

    }


    public function testTreeDelete()
    {

        $objAspect = new SystemAspect();
        ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, "0");
        $strRootNodeId = $objAspect->getSystemid();

        $objAspect = new SystemAspect();
        ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, $strRootNodeId);
        $strSub1Node1Id = $objAspect->getSystemid();
        $objAspect = new SystemAspect();
        ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, $strRootNodeId);
        $strSub1Node2Id = $objAspect->getSystemid();
        $objAspect = new SystemAspect();
        ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, $strRootNodeId);
        $strSub1Node2Id = $objAspect->getSystemid();


        $objAspect = new SystemAspect();
        ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, $strSub1Node1Id);
        $strSub2Node1aId = $objAspect->getSystemid();

        $objAspect = new SystemAspect();
        ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, $strSub1Node1Id);
        $strSub2Node1bId = $objAspect->getSystemid();

        $objAspect = new SystemAspect();
        ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, $strSub1Node1Id);
        $strSub2Node1cId = $objAspect->getSystemid();


        $this->assertEquals(3, count($objAspect->getChildNodesAsIdArray($strRootNodeId)));
        $this->assertEquals(3, count($objAspect->getChildNodesAsIdArray($strSub1Node1Id)));

        $objAspect = new SystemAspect($strRootNodeId);
        $objAspect->deleteObjectFromDatabase();
        Database::getInstance()->flushQueryCache();


        $this->assertEquals(0, count($objAspect->getChildNodesAsIdArray($strRootNodeId)));
        $this->assertEquals(0, count($objAspect->getChildNodesAsIdArray($strSub1Node1Id)));
    }

    public function testPrevIdHandling()
    {

        $objAspect = new SystemAspect();
        $objAspect->setStrName("autotest");

        $bitThrown = false;
        try {
            ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect, "invalid");
        } catch (Exception $objEx) {
            $bitThrown = true;
        }
        $this->assertTrue($bitThrown);
        $this->assertTrue($objAspect->getSystemid() == "");
        $this->assertTrue(!validateSystemid($objAspect->getSystemid()));
        $this->assertTrue(!validateSystemid($objAspect->getStrPrevId()));

        try {
            ServiceLifeCycleFactory::getLifeCycle(get_class($objAspect))->update($objAspect);
            $this->assertTrue(true);
        } catch (ServiceLifeCycleUpdateException $e) {
            $this->fail("Error savin aspect");
        }

        $this->assertTrue($objAspect->getSystemid() != "");
        $this->assertTrue(validateSystemid($objAspect->getSystemid()));
        $this->assertTrue(validateSystemid($objAspect->getStrPrevId()));

    }
}

