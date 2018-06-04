<?php

namespace Umanit\TranslationBundle\Doctrine\Model;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @author Arthur Guigand <aguigand@umanit.fr>
 */
trait TranslatableTrait
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    protected $id;

    /**
     * @var UuidInterface
     * @ORM\Column(name="uuid", type="guid", length=36)
     */
    protected $uuid;

    /**
     * @var string
     * @ORM\Column(name="locale", type="string", length=7)
     */
    protected $locale;

    /**
     * @var array
     * @ORM\Column(type="json_array")
     */
    protected $translations = [];

    /**
     * TranslatableTrait constructor.
     *
     * @param string             $locale
     * @param UuidInterface|null $uuid
     */
    public function __construct(string $locale = null, UuidInterface $uuid = null)
    {
        if (null === $uuid) {
            $uuid = Uuid::uuid4();
        }

        $this->locale = $locale;
        $this->uuid   = (string) $uuid;
    }

    /**
     * Set the locale
     *
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale(string $locale = null): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Returns entity's locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set the UUID
     *
     * @param string $uuid
     *
     * @return $this
     */
    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Returns entity's UUID.
     *
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return array
     */
    public function getTranslations(): array
    {
        return $this->translations;
    }

    /**
     * @param array $translations
     *
     * @return $this
     */
    public function setTranslations(array $translations): TranslatableInterface
    {
        $this->translations = $translations;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id = null): TranslatableInterface
    {
        // Set Id is only called on a new translation, we
        // need the id to be null so it'll be inserted in DB.
        $this->id = null;

        return $this;
    }
}
