<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 26.05.2018
 * Time: 17:34
 */

namespace plate\test\V1Test\UnitTests\NestedSetsOrganizerTest;


use Exception;
use PHPUnit\Framework\Assert;
use plate\EntitySupport\entity\Entity;
use plate\EntitySupport\SimpleResult;
use plate\Organizer\exceptions\EntityFieldsOrganizerException;
use plate\Organizer\exceptions\HandledErrorOrganizerException;
use plate\Organizer\exceptions\OrderingOrganizerException;
use plate\Organizer\Organizer;
use plate\test\V1Test\UnitTests\NestedSetsOrganizerTest\entities\CollectionStub1;
use plate\test\V1Test\UnitTests\NestedSetsOrganizerTest\entities\EntitiesGenerator;
use plate\test\V1Test\UnitTests\NestedSetsOrganizerTest\entities\EntityStub2Bad;
use plate\test\V1Test\UnitTests\NestedSetsOrganizerTest\entities\EntityStub3Bad;
use plate\test\V1Test\UnitTests\NestedSetsOrganizerTest\entities\LevelOneEntityStub;
use plate\test\V1Test\UnitTests\NestedSetsOrganizerTest\entities\LevelTwoEntityStub;

/**
 * Class NestedSetsOrganizerTest
 * @package plate\test\V1Test\UnitTests\NestedSetsOrganizerTest
 */
class NestedSetsOrganizerTest extends \PHPUnit_Framework_TestCase
{
    public function testNestedSetsOrganizerAllOk(){
        $collectionClass = CollectionStub1::class;
        $organizer = Organizer::getOrganizer($collectionClass);


        $res = $organizer->organize(
            EntitiesGenerator::getInstance($collectionClass)
                ->add(LevelOneEntityStub::class, 1, 4, 1)
                ->add(LevelTwoEntityStub::class, 2, 3, 2)
                ->add(LevelOneEntityStub::class, 5, 10, 1)
                ->add(LevelTwoEntityStub::class, 6, 7, 2)
                ->add(LevelTwoEntityStub::class, 8, 9, 2)
                ->iterator()
        );

        Assert::assertTrue(is_array($res), "result nust be array");
        Assert::assertNotEmpty($res, "result must not be empty");
        Assert::assertEquals(2, count($res), "result must contain 2 root elems");

        foreach ($res as $root){
            Assert::assertTrue($root instanceof LevelOneEntityStub, "root element must be instance of " . LevelOneEntityStub::class);
            Assert::assertTrue(property_exists($root, $root->{CollectionStub1::$containerField}), "root element must have container field (" . CollectionStub1::$containerField . ")");
            Assert::assertTrue(is_array($root->{$root->{CollectionStub1::$containerField}}), " root element must contain array of childs");

            foreach ($root->{$root->{CollectionStub1::$containerField}} as $child) {
                Assert::assertTrue($child instanceof LevelTwoEntityStub, "child must be instance of " . LevelTwoEntityStub::class);
            }
        }
    }

    /**
     * У EntityStub2Bad нет поля collection => ожидаем ошибку
     */
    public function testNestedSetOrganizerBadNoContainerField(){
        $this->expectException(EntityFieldsOrganizerException::class);
        $collectionClass = CollectionStub1::class;
        $organizer = Organizer::getOrganizer($collectionClass);

        $organizer->organize(
            EntitiesGenerator::getInstance($collectionClass)
            ->add(EntityStub2Bad::class, 1, 1, 1)
            ->iterator()
        );
    }

    /**
     * EntityStub3Bad не является наследником plate\EntitySupport\entity\Entity
     */
    public function testNestedSetOrganizerBadWrongEntityClassInheritance(){
        $this->expectException(HandledErrorOrganizerException::class);
        $collectionClass = CollectionStub1::class;
        $organizer = Organizer::getOrganizer($collectionClass);

        $organizer->organize(
            EntitiesGenerator::getInstance($collectionClass)
                ->add(EntityStub3Bad::class, 1, 1, 1)
                ->iterator()
        );
    }

    /**
     * Здесь передаем не упорядоченные по lkey объекты
     * ожидаем ошибку, тк упорядочить можно только отсортированные объекты
     */
    public function testNestedSetOrganizerBadOrderingInput(){
        // ждем ошибку
        $this->expectException(OrderingOrganizerException::class);

        $collectionClass = CollectionStub1::class;
        $organizer = Organizer::getOrganizer($collectionClass);

        $organizer->organize(
            EntitiesGenerator::getInstance($collectionClass)
                // 1й уровень
                ->add(LevelOneEntityStub::class, /* lkey: */1, 4, 1)
                ->add(LevelOneEntityStub::class, /* lkey: */5, 10, 1)
                // 2й уровень - как видно, сортировки по lkey нет: 1-5-2-8-6
                ->add(LevelTwoEntityStub::class, /* lkey: */2, 3, 2)
                ->add(LevelTwoEntityStub::class, /* lkey: */8, 9, 2)
                ->add(LevelTwoEntityStub::class, /* lkey: */6, 7, 2)
                ->iterator()
        );
    }

    public function testNestedSetsOrganizerWithNotAllowedNodes(){
        $collectionClass = CollectionStub1::class;
        $organizer = Organizer::getOrganizer($collectionClass);

        $res = $organizer->organize(
            EntitiesGenerator::getInstance($collectionClass)
                // 1й уровень
                ->add(LevelOneEntityStub::class, /* lkey: */1, 4, 1, 1)
                // а прав на этот узел у нас нет (allowed == 0), а значит, в результате мы не должны видеть ни его, ни его потомков!
                ->add(LevelOneEntityStub::class, /* lkey: */2, 10, 1, 0)
                // 2й уровень - как видно, сортировки по lkey нет: 1-5-2-8-6
                ->add(LevelTwoEntityStub::class, /* lkey: */3, 4, 2)
                ->add(LevelTwoEntityStub::class, /* lkey: */6, 7, 2)
                ->add(LevelTwoEntityStub::class, /* lkey: */8, 9, 2)
                ->add(LevelOneEntityStub::class, 11, 16, 1)
                ->add(LevelTwoEntityStub::class, 12,13, 2)
                ->add(LevelTwoEntityStub::class, 14,15,2)
                ->iterator()
        );

        // результат должен содержать всего 2 корневых элемента - 1 элемент нам не доступен
        Assert::assertTrue(count($res) == 2, "Must be 2 elements, " . count($res) . " irl");

        foreach ($res as $node){
            Assert::assertTrue(
                in_array($node->lkey,
                [1,11,12,14]
                ),
                "Hidden elements must not be here!"
            );
        }
    }

    public function testNestedSetsOrganizerFlatList(){
        $collectionClass = CollectionStub1::class;
        $organizer = Organizer::getOrganizer($collectionClass);

        $res = $organizer->organize(
            EntitiesGenerator::getInstance($collectionClass)
                // 1й уровень
                ->add(LevelOneEntityStub::class, /* lkey: */1, 2, 1)
                ->add(LevelOneEntityStub::class, /* lkey: */2, 3, 1)
                ->add(LevelOneEntityStub::class, /* lkey: */4, 5, 1)
                ->add(LevelOneEntityStub::class, /* lkey: */6, 7, 1)
                ->add(LevelOneEntityStub::class, /* lkey: */8, 9, 1)
                ->add(LevelOneEntityStub::class, 11, 12, 1)
                ->add(LevelOneEntityStub::class, 13,14, 1)
                ->add(LevelOneEntityStub::class, 15,16,1)
                ->iterator()
        );

        Assert::assertTrue(count($res) == 8);
    }

    protected function getEntityStub($entityClass, $lkey, $rkey, $level, $lkeyField = 'lkey', $rkeyField = 'rkey', $levelField = 'level', $containerField = 'devices'){
        $ent = new $entityClass();
        $ent->$lkeyField = $lkey;
        $ent->$rkeyField = $rkey;
        $ent->$levelField = $level;

        return $ent;
    }

    public function setUp()
    {
        parent::setUp();
    }
}
