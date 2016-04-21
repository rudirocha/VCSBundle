<?php
namespace Rubius\VCSBundle\DataCollector;

use Rubius\VCSBundle\Entity\ProcessResponse;
use Rubius\VCSBundle\Process\Git;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class VCSCollector extends DataCollector
{

    /**
     * Collects data for the given Request and Response.
     *
     * @param Request $request A Request instance
     * @param Response $response A Response instance
     * @param \Exception $exception An Exception instance
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $gitProcess = new Git();
        $this->data = [
            'branchInfo' => [
                'branchName' => $gitProcess->getBranchName(),
                'branchStatus' => $gitProcess->getFileStatus(),
                'branchList' => $gitProcess->getBranchList()
                ],
            'remoteInfo' => [
                'url' => $gitProcess->getRemoteInfo()
            ],
            'userInfo' => [
                'userName' => $gitProcess->getConfigUserName(),
                'userEmail' => $gitProcess->getConfigUserEmail()
            ]
        ];
    }

    /**
     * Get Branch Name
     * @return processResponse
     */
    public function getBranchInfo() : array
    {
        return $this->data['branchInfo'];
    }

    /**
     * Get User Info
     * @return processResponse
     */
    public function getUserInfo() : array
    {
        return $this->data['userInfo'];
    }

    /**
     * Get remote Info
     * @return processResponse
     */
    public function getRemoteInfo() : array
    {
        return $this->data['remoteInfo'];
    }


    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     */
    public function getName()
    {
        return 'rubius.vcs.collector';
    }
}