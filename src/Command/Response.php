<?php

namespace Choccybiccy\Werewolf\Command;

/**
 * Class Response.
 */
class Response
{
    /**
     * @var array
     */
    protected $response;

    /**
     * @var CommandInterface
     */
    protected $command;

    /**
     * Response constructor.
     *
     * @param array            $response
     * @param CommandInterface $command
     */
    public function __construct(array $response, CommandInterface $command)
    {
        $this->response = $response;
        $this->command = $command;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return CommandInterface
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return array_key_exists('success', $this->response) ? (bool) $this->response['success'] : false;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return array_key_exists('message', $this->response) ? $this->response['message'] : null;
    }

    /**
     * @param string $property
     *
     * @return mixed
     */
    public function get($property)
    {
        return array_key_exists($property, $this->response) ? $this->response[$property] : null;
    }
}
