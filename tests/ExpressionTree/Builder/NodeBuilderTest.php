<?php
/*
 * This file is part of ExpressionTree.
 *
 * (c) 2013 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ExpressionTree\Test\Builder;

use ExpressionTree\Tree\Node;
use ExpressionTree\Builder\NodeBuilder;

/**
 * Unit tests for class FirstClass
 */
class NodeTest extends \PHPUnit_Framework_TestCase
{
    /** @var NodeBuilder */
    protected $builder;

    public function setUp()
    {
        $this->builder = new NodeBuilder;
    }

    public function testConstructorCreatesEmptyNodeIfNoSpecified()
    {
        $builder = new NodeBuilder;

        $this->assertNull($builder->getNode()->getValue());
    }

    public function testConstructor()
    {
        $builder = new NodeBuilder($node = new Node('node'));

        $this->assertEquals($node, $builder->getNode());
    }

    public function testSetNodeAndGetNode()
    {
        $this->builder->setNode($node1 = new Node('node1'));
        $this->assertEquals($node1, $this->builder->getNode());

        $this->builder->setNode($node2 = new Node('node2'));
        $this->assertEquals($node2, $this->builder->getNode());
    }

    public function testLeaf()
    {
        $this->builder->leaf('a')->leaf('b');

        $children = $this->builder->getNode()->getChildren();

        $this->assertEquals('a', $children[0]->getValue());
        $this->assertEquals('b', $children[1]->getValue());
    }

    public function testLeafs()
    {
        $this->builder->leafs('a', 'b');

        $children = $this->builder->getNode()->getChildren();

        $this->assertEquals('a', $children[0]->getValue());
        $this->assertEquals('b', $children[1]->getValue());
    }

    public function testTree()
    {
        $this->builder->tree('a')->tree('b');

        $this->assertEquals('b', $this->builder->getNode()->getValue());
    }

    public function testEnd()
    {
        $this->builder
            ->value('root')
            ->tree('a')
                ->tree('b')
                    ->tree('c')
                    ->end();

        $this->assertEquals('b', $this->builder->getNode()->getValue());

        $this->builder->end();
        $this->assertEquals('a', $this->builder->getNode()->getValue());

        $this->builder->end();
        $this->assertEquals('root', $this->builder->getNode()->getValue());
    }

    public function testValue()
    {
        $this->builder->value('foo')->value('bar');

        $this->assertEquals('bar', $this->builder->getNode()->getValue());
    }

    public function testNodeInstanceByValue()
    {
        $node = $this->builder->nodeInstanceByValue('baz');

        $this->assertEquals('baz', $node->getValue());
        $this->assertInstanceOf('ExpressionTree\Tree\Node', $node);
    }
}