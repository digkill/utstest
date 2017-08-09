<?php

namespace Uts\HotelBundle\Controller;

use Doctrine\ORM\EntityManager;
use Uts\HotelBundle\CustomPagination\Adapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Uts\HotelBundle\Entity\SearchRequest;
use Symfony\Component\HttpFoundation\Request;
use Zend\Paginator\Paginator;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $objSearchForm = $this->createForm('uts_hotel_search_request', new SearchRequest());
        $objSearchForm->handleRequest($request);
        return $this->render('UtsHotelBundle:Default:index.html.twig', array('searchForm' => $objSearchForm->createView()));
    }

    public function processAction(Request $request)
    {
        $objSearchForm = $this->createForm('uts_hotel_search_request', new SearchRequest());
        $objSearchForm->submit($request->query->get($objSearchForm->getName()), false);
        if($objSearchForm->isValid()){
            /*** @var $objSearchRequest SearchRequest
             *   @var $em EntityManager
             */
            $objSearchRequest = $objSearchForm->getData();
            $em = $this->getDoctrine()->getManagerForClass('UtsHotelBundle:SearchRequest');
            $repository = $em->getRepository('UtsHotelBundle:SearchRequest');

            $objCompleteSearchRequest = $repository->isCompleteRequest($objSearchRequest);
            if(isset($objCompleteSearchRequest)){
                $objSearchRequest = $objCompleteSearchRequest;
            } else{
                $em->persist($objSearchRequest);
                $em->flush();

                try{
                    $objSearcher = $this->get('uts_hotel.searcher');
                    $results = $objSearcher->search($objSearchRequest);
                    foreach($results as $objResult){
                        $em->persist($objResult);
                    }
                    $objSearchRequest->markAsComplete();
                    $em->flush();
                }catch (\Exception $err){
                    $objSearchRequest->markAsError();
                    $em->flush();
                    throw $err;
                }
            }

            return new RedirectResponse(
                $this->get('router')
                    ->generate('uts_hotel_search_results', array('searchId' => $objSearchRequest->getId()))
            );
        }else{
            return $this->render('UtsHotelBundle:Default:index.html.twig', array('searchForm' => $objSearchForm->createView()));
        }
    }

    public function resultsAction($searchId, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $objSearchRequest = $em->find('UtsHotelBundle:SearchRequest', $searchId);
        if(!$objSearchRequest){
            $this->createNotFoundException();
        }

        $objSearchForm = $this->createForm('uts_hotel_search_request', $objSearchRequest);
        $templateVars = array(
            'searchForm' => $objSearchForm->createView(),
            'request' => $objSearchRequest
        );
        if($objSearchRequest->isComplete() || $objSearchRequest->isOld()){
            $repository = $em->getRepository('UtsHotelBundle:SearchResult');

            $paginator  = new Paginator(new Adapter($repository, $searchId));
            $paginator->setCurrentPageNumber($page);
            $paginator->setItemCountPerPage(50);

            if($page < 3){
                $pagesInRange = $paginator->getPagesInRange(1, 5);
            } elseif ($page > $paginator->count() - 3){
                $pagesInRange = $paginator->getPagesInRange($paginator->count() - 4, $paginator->count());
            } else{
                $pagesInRange = $paginator->getPagesInRange($page - 2, $page + 2);
            }

            $pagesInRangeKeys = array_keys($pagesInRange);

            $pagination = array(
                'pageCount' => $paginator->count(),
                'pagesInRange' => $pagesInRange,
                'items' => $paginator,
                'current' => $page,
                'startPage' => $pagesInRange[$pagesInRangeKeys[0]],
                'endPage' => $pagesInRange[$pagesInRangeKeys[count($pagesInRangeKeys) - 1]],
                'route' => 'uts_hotel_search_results',
                'query' => array('searchId' => $searchId),
                'pageParameterName' => 'page',
            );

            if ($page > 1){
                $pagination['previous'] = $page - 1;
            }

            if ($page < $pagesInRange[$pagesInRangeKeys[count($pagesInRangeKeys) - 1]]){
                $pagination['next'] = $page + 1;
            }

            $templateVars['pagination'] = $pagination;
        }
        return $this->render('UtsHotelBundle:Default:results.html.twig', $templateVars);
    }
}
