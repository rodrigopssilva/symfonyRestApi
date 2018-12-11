<?php

namespace Tests\AppBundle\Handler;


use AppBundle\Handler\ErrorMessageHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationList;

class ErrorMessageHandlerTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * @covers \AppBundle\Handler\ErrorMessageHandler::checkErrors
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @expectedExceptionMessage id: Id not valid!
     */
    public function testConstructThrowsBadRequest()
    {
        $errors = $this->getMockBuilder(ConstraintViolationList::class)
            ->disableOriginalConstructor()
            ->setMethods(['getIterator'])
            ->getMock();

        $singleError = $this->getMockBuilder(ConstraintViolationList::class)
            ->disableOriginalConstructor()
            ->setMethods(['getPropertyPath', 'getMessage'])
            ->getMock();

        $singleError->expects($this->once())
            ->method('getPropertyPath')
            ->willReturn('id');

        $singleError->expects($this->once())
            ->method('getMessage')
            ->willReturn('Id not valid!');

        $errors->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayObject([$singleError]));

        ErrorMessageHandler::checkErrors($errors);
    }

    /**
     * @covers \AppBundle\Handler\ErrorMessageHandler::checkErrors
     */
    public function testConstruct()
    {
        $errors = $this->getMockBuilder(ConstraintViolationList::class)
            ->disableOriginalConstructor()
            ->setMethods(['getIterator'])
            ->getMock();

        $errors->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayObject([]));

        ErrorMessageHandler::checkErrors($errors);
    }
}
