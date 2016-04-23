<?php
/**
 * Created by PhpStorm.
 * User: rudi
 * Date: 17-04-2016
 * Time: 23:17
 */

namespace Rubius\VCSBundle\Parser;


interface ParserInterface
{
    /**
     * Parses the output from ran process.
     * Should add messages to ProcessResponse
     * @return void
     */
    public function parseOutput() : array;
}
