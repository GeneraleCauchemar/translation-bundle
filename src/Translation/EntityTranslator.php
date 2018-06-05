<?php

namespace Umanit\TranslationBundle\Translation;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Umanit\TranslationBundle\Translation\Handlers\TranslationHandlerInterface;
use Umanit\TranslationBundle\Utils\AnnotationHelper;

/**
 * @author Arthur Guigand <aguigand@umanit.fr>
 */
class EntityTranslator
{
    /**
     * @var array
     */
    protected $locales;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var TranslationHandlerInterface[]
     */
    protected $handlers;

    /**
     * @var AnnotationHelper
     */
    private $annotationHelper;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * EntityTranslator constructor.
     *
     * @param array                    $locales
     * @param EventDispatcherInterface $eventDispatcher
     * @param EntityManagerInterface   $em
     * @param AnnotationHelper         $annotationHelper
     */
    public function __construct(
        array $locales,
        EventDispatcherInterface $eventDispatcher,
        EntityManagerInterface $em,
        AnnotationHelper $annotationHelper
    ) {
        $this->locales          = $locales;
        $this->eventDispatcher  = $eventDispatcher;
        $this->em               = $em;
        $this->annotationHelper = $annotationHelper;
    }

    /**
     * Translate an entity.
     *
     * @param mixed                    $data
     * @param string                   $locale
     * @param \ReflectionProperty|null $property
     * @param mixed|null               $parent
     *
     * @return mixed
     */
    public function translate($data, string $locale, \ReflectionProperty $property = null, $parent = null)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($data, $property)) {
                if (null !== $property) {
                    if ($this->annotationHelper->isSharedAmongstTranslations($property)) {
                        return $handler->handleSharedAmongstTranslations($data, $locale);
                    }
                    if ($this->annotationHelper->isEmptyOnTranslate($property)) {
                        return $handler->handleEmptyOnTranslate($data, $locale);
                    }
                }

                return $handler->translate($data, $locale, $property, $parent);
            }
        }

        $this->em->flush();

        return $data;
    }

    /**
     * Service call.
     *
     * @param TranslationHandlerInterface $handler
     * @param null                        $priority
     */
    public function addTranslationHandler(TranslationHandlerInterface $handler, $priority = null)
    {
        if (null === $priority) {
            $this->handlers[] = $handler;
        } else {
            $this->handlers[$priority] = $handler;
        }
    }
}
