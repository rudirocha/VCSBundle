<?php
/**
 * Created by PhpStorm.
 * User: rudi
 * Date: 20-04-2016
 * Time: 23:25
 */

namespace Rubius\VCSBundle\Controller;

use Rubius\VCSBundle\Process\Git;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class VCSController extends Controller
{
    /**
     * @Route("/rubius/vcs/checkout/{branchName}", name="rubius.vcs.branch.checkout")
     */
    public function checkoutAction(Request $request, $branchName)
    {
        /**
         * This action tries to checkout some branch
         * Make attention if do you have local code that has to be stashed or committed first!!!!
         */
        $gitProcess = new Git();
        $processResponse = $gitProcess->gitCheckout($branchName);
        if ($processResponse->isErrors()) {
            $this->addFlash('checkoutError', $processResponse->getOutput() );
            return $this->redirect($request->server->get('HTTP_REFERER'));
        }
        return $this->redirect('/');

    }
}
