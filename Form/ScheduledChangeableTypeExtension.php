<?php
/**
 * Created by iBROWS AG.
 * User: marcsteiner
 * Date: 11.03.14
 * Time: 13:05
 */

namespace Ibrows\LoggableBundle\Form;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduledChangeableTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['scheduledchangeable'] === false) {
            return;
        }

        $format = "yyyy-MM-dd";
        if (isset($options['scheduledchangeable_format'])) {
            $format = $options['scheduledchangeable_format'];
        }

        $propertyName = 'scheduledChangeDate';
        if ($options['scheduledchangeable'] === 'auto') {
            if (!$this->checkIsScheduledChangeable($builder, $propertyName)) {
                return;
            }
        } else {
            if ($options['scheduledchangeable'] !== true) {
                $propertyName = $options['scheduledchangeable'];
            }
        }

        $builder->add($propertyName, DateType::class, [
            'widget' => 'single_text',
            'format' => $format,
            'required' => false
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['scheduledchangeable' => 'auto']);
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }

    protected function checkIsScheduledChangeable(FormBuilderInterface $builder, string $property): bool
    {
        $entity = $builder->getData();
        if ($entity === null || !is_object($entity) || (method_exists($entity, 'getId') && $entity->getId() === null)) {
            return false;
        }
        $class = get_class($entity);
        $reflectionClass = new \ReflectionClass($class);
        if (!$reflectionClass->implementsInterface('\Ibrows\LoggableBundle\Model\ScheduledChangeable')) {
            return false;
        }

        return property_exists($class, $property);
    }
}
