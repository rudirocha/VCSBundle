<?php
/**
 * Created by PhpStorm.
 * User: rudi
 * Date: 20-04-2016
 * Time: 23:04
 */

namespace Rubius\VCSBundle\Parser;


use Rubius\VCSBundle\Entity\ProcessResponse;

class BranchName implements Parser
{
    /**
     * @var ProcessResponse
     */
    private $processResponse;

    public function __construct(ProcessResponse $pr)
    {
        $this->processResponse = $pr;
    }

    /**
     * Parses the output from ran process.
     * Should add messages to ProcessResponse
     * @return array
     */
    public function parseOutput() : array
    {
        $lines = explode(PHP_EOL, $this->processResponse->getOutput());
        $branches = [];
        foreach ($lines as $l) {
            $branches[] = substr($l,2);
        }
        return $branches;
    }

    /**
     * @return ProcessResponse
     */
    public function getProcessResponse()
    {
        return $this->processResponse;
    }

    /**
     * @param ProcessResponse $processResponse
     */
    public function setProcessResponse($processResponse)
    {
        $this->processResponse = $processResponse;
    }


}