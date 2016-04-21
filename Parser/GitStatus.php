<?php
/**
 * Created by PhpStorm.
 * User: rudi
 * Date: 17-04-2016
 * Time: 23:14
 */

namespace Rubius\VCSBundle\Parser;


use Rubius\VCSBundle\Entity\ProcessResponse;

class GitStatus implements Parser
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
        $fileIndex = [];
        foreach ($lines as $l) {
            $fileStatus = substr($l, 0, 2);
                switch ($fileStatus){
                    case 'A ':
                        $fileIndex['added'][] = substr($l, 2);
                        break;
                    case 'AA':
                        $fileIndex['bothAdded'][] = substr($l, 2);
                        break;
                    case 'AU':
                        $fileIndex['addedByUs'][] = substr($l, 2);
                        break;
                    case 'UA':
                        $fileIndex['addedByThem'][] = substr($l, 2);
                        break;
                    case ' M':
                    case 'M ':
                        $fileIndex['modified'][] = substr($l, 2);
                        break;
                    case 'UU':
                        $fileIndex['bothModified'][] = substr($l, 2);
                        break;
                    case 'UD':
                        $fileIndex['deletedByThem'][] = substr($l, 2);
                        break;
                    case 'D ':
                        $fileIndex['deleted'][] = substr($l, 2);
                        break;
                    case ' D':
                        $fileIndex['deletedRemote'][] = substr($l, 2);
                        break;
                    case 'DD':
                        $fileIndex['bothDeleted'][] = substr($l, 2);
                        break;
                    case 'DU':
                        $fileIndex['deletedByUs'][] = substr($l, 2);
                        break;
                    case 'R ':
                        $fileIndex['renamed'][] = substr($l, 2);
                        break;
                    case 'C ':
                        $fileIndex['copied'][] = substr($l, 2);
                        break;
                    case '??':
                        $fileIndex['unTracked'][] = substr($l, 2);
                        break;
                    case '!!':
                        $fileIndex['ignored'][] = substr($l, 2);
                        break;
                    default:
                        if (substr($l, 2)) {
                            dump($fileStatus);
                            $fileIndex['unknown'][] = substr($l, 2);
                        }

                        break;
                }
        }
        return $fileIndex;
    }
}