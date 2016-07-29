<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Answer;
use AppBundle\Entity\User;
use Doctrine\ORM\Query;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    const MAX_ERRORS = 3;
    const QUESTIONS = 10;

    /**
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/api/start")
     * @param Request $request
     * @return JsonResponse
     */
    public function startAction(Request $request) {
        $name = $request->request->get("name");
        if(!$name) {
            return new JsonResponse(null,400);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $user = new User();
        $user->setName($name);
        $em->persist($user);
        $em->flush();
        return new JsonResponse(["userId" => $user->getId()]);
    }

    /**
     * @Route("/api/exam")
     * @param Request $request
     * @return JsonResponse
     */
    public function examAction(Request $request) {
        $userId = $request->request->get("userId");
        if(!$userId) {
            return new JsonResponse(null, 400);
        }
        $errors = $this->getDoctrine()->getRepository("AppBundle:Answer")->getErrorsCount($userId);
        $score = $this->getDoctrine()->getRepository("AppBundle:Answer")->getScore($userId);
        $questions = $this->getDoctrine()->getRepository("AppBundle:Answer")->getAskedQuestions($userId);
        if($errors >= $this::MAX_ERRORS) {
            return new JsonResponse([
                "status" => "failed",
                "score" => $score
            ]);
        }
        if(count($questions) >= $this::QUESTIONS) {
            return new JsonResponse([
                "status" => "success",
                "score" => $score,
                "errors" => $errors
            ]);
        }

        $em = $this->getDoctrine()->getEntityManager();

        $query= $em->createQueryBuilder()
            ->select(["d.id","d.ru", "d.en"])
            ->from("AppBundle:Dict","d");
        if(count($questions)) {
            $query->where("d.id not in (:asked)")
                ->setParameter("asked", $questions);
        }
        $q = $query->orderBy("rand()")
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();

        $a = $em
            ->createQuery('select d.ru from AppBundle:Dict d where d.id <> :id order by rand()')
            ->setParameter('id', $q['id'])
            ->setMaxResults(3)
            ->getResult();

        $answers = array_map(function($i)
            {
                return $i['ru'];
            }, $a);
        array_push($answers, $q['ru']);
        shuffle($answers);

        return new JsonResponse([
            "status" => "in_progress",
            "userId" =>$userId,
            "question" => [
                "q" => $q['en'],
                "a" => $answers
            ],
            "errors" => $errors,
            "score" => $score,
            "q" => $questions
        ]);
    }

    /**
     * @Route("/api/answer")
     * @param Request $request
     * @return JsonResponse
     */
    public function answerAction(Request $request) {
        $uId = $request->request->get("userId");
        $qText = $request->request->get("q");
        $aText = $request->request->get("a");

        if(!$uId || !$qText || !$aText) {
            return new JsonResponse(null, 400);
        }

        $user = $this->getDoctrine()
            ->getRepository("AppBundle:User")
            ->find($uId);

        $q = $this->getDoctrine()
            ->getRepository("AppBundle:Dict")
            ->findOneBy(["en"=>$qText]);
        $a = $this->getDoctrine()
            ->getRepository("AppBundle:Dict")
            ->findOneBy(["ru"=>$aText]);

        $answer = new Answer();
        $answer->setUser($user);
        $answer->setRu($a);
        $answer->setEn($q);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($answer);
        $em->flush();

        if($q->getId() == $a->getId()) {
            return new JsonResponse("success");
        } else {
            $errors = $this->getDoctrine()->getRepository("AppBundle:Answer")->getErrorsCount($uId);
            if($errors >=$this::MAX_ERRORS) {
                return new JsonResponse("failed");
            } else {
                return new JsonResponse("error");
            }

        }
    }
}
