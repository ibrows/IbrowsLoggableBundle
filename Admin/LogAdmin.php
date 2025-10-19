<?php
namespace Ibrows\LoggableBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;

class LogAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_page' => 1,
        '_per_page' => 25,
        '_sort_order' => 'DESC',
        '_sort_by' => 'id'
    ];

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('id', null, ['route' => ['name' => 'show']]);
        $list->add('action');
        $list->add('objectId');
        $list->add('objectClass');
        $list->add('loggedAt');
        $list->add('username');
        $list->add('sourceUsername');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('id');
        $show->add('action');
        $show->add('objectId');
        $show->add('objectClass');
        $show->add('data', 'array', ['template' => '@IbrowsLoggable/Admin/show_array.html.twig']);
        $show->add('oldData', 'array', ['template' => '@IbrowsLoggable/Admin/show_array.html.twig']);
        $show->add('loggedAt');
        $show->add('username');
        $show->add('sourceUsername');
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter->add('objectClass', 'doctrine_orm_callback', [
            'callback' => function ($queryBuilder, $alias, $field, $value) {
                if (!$value['value']) {
                    return false;
                }
                // get some extra slashes for "double" escaping
                $value = addcslashes($value['value'], '\\');
                $queryBuilder->andWhere("$alias.objectClass like :objectClass");
                $queryBuilder->setParameter('objectClass', $value);
                return true;
            },
            'field_type' => 'text'
        ]);
        $filter->add('objectId', 'doctrine_orm_number', [], 'text', []);
        $filter->add('username');
        $filter->add('sourceUsername');
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('create');
        $collection->remove('edit');
        $collection->remove('delete');
    }
}
