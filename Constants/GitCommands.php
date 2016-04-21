<?php
/**
 * Created by PhpStorm.
 * User: rudi
 * Date: 12-04-2016
 * Time: 23:28
 */

namespace Rubius\VCSBundle\Constants;


final class GitCommands
{
    /**
     * Get current branch name
     */
    const GIT_BRANCH_NAME = 'git symbolic-ref --short HEAD';
    const GIT_BRANCH_LIST = 'git branch --list';

    /**
     * Get log info
     */
    const GIT_LOG_TREE = 'git log \
    --graph -10 \
    --all \
    --color \
    --date=short \
    --pretty=format:"%Cred%x09%h %Creset%ad%Cblue%d %Creset %s %C(bold)(%an)%Creset" |
    cat -';

    const GIT_LOG_LAST_COMMIT = 'git log -1 %s |cat -';

    /**
     * Get Remote Info
     */
    const GIT_CONFIG_REMOTE_ORIGIN_URL = 'git config --get remote.origin.url';

    /**
     * Get user info
     */
    const GIT_CONFIG_USER_NAME = 'git config user.name';
    const GIT_CONFIG_USER_EMAIL = 'git config user.email';
    const GIT_STATUS_FILES = 'git status --porcelain';
    const GIT_CHECKOUT_BRANCH = 'git checkout ';
}