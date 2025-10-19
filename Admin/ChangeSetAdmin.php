<?php
namespace Ibrows\LoggableBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;

class ChangeSetAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('id', null, ['route' => ['name' => 'show']]);
        $list->add('action');
        $list->add('objectId');
        $list->add('objectClass');
        $list->add('changeAt');
        $list->add('username');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('id');
        $show->add('action');
        $show->add('objectId');
        $show->add('objectClass');
        $show->add('data', 'array');
        $show->add('oldData', 'array');
        $show->add('changeAt');
        $show->add('username');
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter->add('objectClass');
        $filter->add('objectId', 'doctrine_orm_number', [], 'text', []);
        $filter->add('username');
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('create');
        $collection->remove('edit');
    }
}
