<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\Roll;
use App\Form\RollnoType;


class MarkController extends AbstractController
{
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository){
        $this->studentRepository = $studentRepository;
    }

    public function index(Request $request): Response
    {
        $roll = new Roll();
        $rollform = $this->createForm(RollnoType::class,$roll);
        $rollform->handleRequest($request);

        if($rollform->isSubmitted() && $rollform->isValid()){
            $inData = $rollform->getData();
            $number = $inData->rollno;
            $data = $this->studentRepository->getRecord($number);
            if($data === null){
                return $this->render('mark/fail.html.twig',['data'=>"No Record Found"]);

            }
            else{
    
                return $this->render('mark/success.html.twig',['data'=>$data]);
            }
        }
        return $this->render('mark/index.html.twig', [
            'form' => $rollform->createView(),
        ]);
    }
    
    

}
