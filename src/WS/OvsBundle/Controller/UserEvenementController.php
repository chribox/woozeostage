<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WS\OvsBundle\Entity\Evenement;
use WS\OvsBundle\Entity\UserEvenement;
use WS\OvsBundle\Form\UserEvenementType;

/**
 * @Route("/userevenement")
 */
class UserEvenementController extends Controller {

    /**
     * @Route("/add/{id}", name="ws_ovs_userevenement_add")
     * @Template()
     */
    public function addAction(Evenement $evenement) {
        $user = $this->getUser();

        $userEvenement = new UserEvenement();
        $userEvenement->setUser($user);
        $userEvenement->setEvenement($evenement);

        if ($user == $evenement->getUser()) {
            $userEvenement->setStatut(1);
        } else {
            $userEvenement()->setStatut(2);
        }
        if ($userEvenement->getStatut() == 1) {
            $evenement->setNombreValide($evenement->getNombreValide() + 1);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($userEvenement, $evenement);
        $em->flush();
        return $this->redirect($this->generateUrl('ws_ovs_evenement_list'));
    }

    /**
     * @Route("/modifier/{id}", name="ws_ovs_userevenement_modifier")
     * @Template()
     */
    public function modifierAction(Evenement $evenement) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $userEvenement = $em->getRepository('WSOvsBundle:UserEvenement')->findOneBy(array('user' => $user, 'evenement' => $evenement));
        $form = $this->createForm(new UserEvenementType(), $userEvenement);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em->persist($userEvenement);
                $em->flush();
                return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
            }
        }
        return array('form' => $form->createView(), 'userEvenement' => $userEvenement);
    }

}
