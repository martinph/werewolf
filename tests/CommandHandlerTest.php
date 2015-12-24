<?php

namespace Choccybiccy\Werewolf;

/**
 * Class CommandHandlerTest
 * @package Choccybiccy\Werewolf
 */
class CommandHandlerTest extends TestCase
{

    /**
     * Test handle() throws an exception is no command is provided in the data
     */
    public function testHandleThrowsExceptionIfNoCommandProvided()
    {
        $this->setExpectedException('Choccybiccy\Werewolf\Exception\MalformedDataException');
        $handler = $this->getMockCommandHandler();
        $handler->handle(["data" => "somData"], $this->getMockPlayer(), $this->getMockPlayerCollection());
    }

    /**
     * Test handle() throws an exception if the command provided is unknown
     */
    public function testHandleThrowsExceptionIfUnknownCommand()
    {
        $this->setExpectedException('Choccybiccy\Werewolf\Exception\UnknownCommandException');
        $handler = $this->getMockCommandHandler();
        $handler->handle(["command" => "nonexistentcommand"], $this->getMockPlayer(), $this->getMockPlayerCollection());
    }

    /**
     * Test handle() returns a command object
     */
    public function testHandle()
    {
        $handler = new CommandHandler();
        $commands = $handler->getCommands();
        foreach (array_keys($commands) as $command) {
            $commandObject = $handler->handle(
                ["command" => $command, "data" => "someData"],
                $this->getMockPlayer(),
                $this->getMockPlayerCollection()
            );
            $this->assertInstanceOf($commands[$command], $commandObject);
        }
    }

    /**
     * @param array|null $methods
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockCommandHandler($methods = null)
    {
        return $this->getMockBuilder('Choccybiccy\Werewolf\CommandHandler')
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();
    }

}
