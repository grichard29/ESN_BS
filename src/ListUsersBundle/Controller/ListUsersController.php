<?php

namespace ListUsersBundle\Controller;

use BSBundle\Entity\UserEntity;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORM\SearchCriteriaProvider;
use Omines\DataTablesBundle\Column\AbstractColumn;
use Omines\DataTablesBundle\Column\MapColumn;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Controller\DataTablesTrait;
use Symfony\Component\HttpFoundation\Request;

class ListUsersController extends Controller
{
    use DataTablesTrait;
    /**
     * @Route("/liste")
     */
    public function indexAction(Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $table = $this->createDataTable()
            ->add('username', TextColumn::class)
            ->add('email', TextColumn::class)
            ->createAdapter(ORMAdapter::class, [
                'entity' => UserEntity::class,
            ])
            ->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('ListUsersBundle:Default:index.html.twig',['datatable' => $table]);
    }
}
