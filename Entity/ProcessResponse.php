<?php
/**
 * Created by PhpStorm.
 * User: rudi
 * Date: 12-04-2016
 * Time: 23:24
 */

namespace Rubius\VCSBundle\Entity;


class ProcessResponse
{
    /**
     * @var bool
     */
    protected $errors;

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @var string
     */
    protected $output;

    /**
     * @var array
     */
    protected $extraData = [];


    /**
     * @return boolean
     */
    public function isErrors()
    {
        return $this->errors;
    }

    /**
     * @param boolean $errors
     * @return $this
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @param $sMessage
     * @return $this
     */
    public function addMessage($sMessage)
    {
        $this->messages[] = $sMessage;
        return $this;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        if (count($this->messages) == 1) {
            return $this->messages[0];
        }
        return $this->messages;
    }

    /**
     * @param array $messages
     * @return $this
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
        return $this;
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param string $output
     * @return $this
     */
    public function setOutput($output)
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @return array
     */
    public function getExtraData()
    {
        return $this->extraData;
    }

    /**
     * @param array $extraData
     */
    public function setExtraData($extraData)
    {
        $this->extraData = $extraData;
    }

}
