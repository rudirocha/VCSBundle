<?php
/**
 * Created by PhpStorm.
 * User: rudi
 * Date: 11-04-2016
 * Time: 23:35
 */

namespace Rubius\VCSBundle\Process;


use Rubius\VCSBundle\Constants\GitCommands;
use Rubius\VCSBundle\Entity\ProcessResponse;
use Rubius\VCSBundle\Parser\BranchName;
use Rubius\VCSBundle\Parser\GitStatus;

class Git extends VCSProcess
{

    #region GIT USER Info
    /**
     * Get GIT config user.name
     * @return ProcessResponse
     */
    public function getConfigUserName() : ProcessResponse
    {
        $processResponse = new ProcessResponse();
        try {
            $processResponse = $this->runProcessCommand(GitCommands::GIT_CONFIG_USER_NAME);
        } catch (\Exception $ex) {
            $processResponse->addMessage('Some unknown error has occurred getting UserName')->setErrors(true);
        }
        return $processResponse;
    }
    /**
     * Get GIT config user.name
     * @return ProcessResponse
     */
    public function getConfigUserEmail() : ProcessResponse
    {
        $processResponse = new ProcessResponse();
        try {
            $processResponse = $this->runProcessCommand(GitCommands::GIT_CONFIG_USER_EMAIL);
        } catch (\Exception $ex) {
            $processResponse->addMessage('Some unknown error has occurred getting UserEmail')->setErrors(true);
        }
        return $processResponse;
    }
    #endregion

    /**
     * Get branch name info
     * @return ProcessResponse|string
     */
    public function getBranchName() : ProcessResponse
    {
        $processResponse = new ProcessResponse();
        try {
            $processResponse = $this->runProcessCommand(GitCommands::GIT_BRANCH_NAME);
            if ($processResponse->isErrors()) {

                //Try to understand process error
                if (strpos($processResponse->getOutput(), 'unknown revision or path not in the working tree')) {
                    $processResponse->addMessage('rubius.vcs.messages.noCommittedBranchesFull');
                } else {
                    $processResponse->addMessage('rubius.vcs.messages.notInitialized');
                }
            }
        } catch (\Exception $ex) {
            $processResponse->addMessage('Some unknown error has occurred getting BranchName')->setErrors(true);
        }

        return $processResponse;
    }

    /**
     * @return ProcessResponse
     */
    public function getRemoteInfo() : ProcessResponse
    {
        $processResponse = new ProcessResponse();

        try {
            $processResponse = $this->runProcessCommand(GitCommands::GIT_CONFIG_REMOTE_ORIGIN_URL);

        } catch (\Exception $ex) {
            $processResponse->addMessage('Some unknown error has occurred getting Remote Info')->setErrors(true);
        }

        return $processResponse;
    }

    /**
     * @return ProcessResponse
     */
    public function getBranchList() : ProcessResponse
    {
        $processResponse = new ProcessResponse();

        try {
            $processResponse = $this->runProcessCommand(GitCommands::GIT_BRANCH_LIST);
            $branchNamesParser = new BranchName($processResponse);

            $branchInfo = [];
            $branchNames = $branchNamesParser->parseOutput();
            foreach ($branchNames as $branchName) {
                if ($branchName) {
                    $branchInfoProcessResponse = $this->runProcessCommand(sprintf(GitCommands::GIT_LOG_LAST_COMMIT, $branchName));
                    $branchInfo[$branchName] = $branchInfoProcessResponse;
                }
            }

            $processResponse->setExtraData(['branches' => $branchInfo]);

        } catch (\Exception $ex) {
            $processResponse->addMessage('Some unknown error has occurred getting Remote Info')->setErrors(true);
        }

        return $processResponse;
    }

    /**
     * @param $branchName
     * @return ProcessResponse
     */
    public function gitCheckout($branchName) : ProcessResponse
    {
        $processResponse = new ProcessResponse();

        try {
            $processResponse = $this->runProcessCommand(sprintf("%s %s", GitCommands::GIT_CHECKOUT_BRANCH, $branchName));
        } catch (\Exception $ex) {
            $processResponse->addMessage('Some unknown error has occurred getting Remote Info')->setErrors(true);
        }

        return $processResponse;
    }
    /**
     * @return ProcessResponse
     */
    public function getFileStatus() : ProcessResponse
    {
        $processResponse = new ProcessResponse();
        try {
            $processResponse = $this->runProcessCommand(GitCommands::GIT_STATUS_FILES);

            if (!$processResponse->isErrors()) {
                $statusParser = new GitStatus($processResponse);
                $processResponse->setExtraData(['fileIndex' => $statusParser->parseOutput()]);
            }

        } catch(\Exception $ex) {
            $processResponse->addMessage('Some unknown error has occurred getting file status')->setErrors(true);
        }
        return $processResponse;
    }
}
