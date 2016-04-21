<?php
/**
 * Created by PhpStorm.
 * User: rudi
 * Date: 12-04-2016
 * Time: 23:29
 */

namespace Rubius\VCSBundle\Process;


use Rubius\VCSBundle\Entity\ProcessResponse;
use Symfony\Component\Process\Process;

abstract class VCSProcess
{
    /**
     * Run Command
     * @param $CommandStr
     * @param bool|true $run
     * @return ProcessResponse
     */
    public function runProcessCommand($CommandStr, bool $run = true) : ProcessResponse
    {
        $processResponse = new ProcessResponse();
        $process = new Process($CommandStr);

        if ($run) {
            $process->run();
            if (!$process->isSuccessful()) {
                $processResponse
                    ->setErrors(true)
                    ->setOutput($process->getErrorOutput());
            } else {
                $processResponse
                    ->setErrors(false)
                    ->setOutput($process->getOutput());
            }
        }
        return $processResponse;
    }
}