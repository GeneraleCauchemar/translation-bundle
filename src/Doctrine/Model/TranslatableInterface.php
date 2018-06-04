<?php

namespace Umanit\TranslationBundle\Doctrine\Model;

/**
 * @author Arthur Guigand <aguigand@umanit.fr>
 */
interface TranslatableInterface
{
    /**
     * Returns entity's id.
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set entity's id.
     *
     * @param int|null $id
     *
     * @return TranslatableInterface
     */
    public function setId(int $id = null): TranslatableInterface;

    /**
     * Returns entity's locale (fr/en/...)
     */
    public function getLocale();

    /**
     * Set entity's locale (fr/en/...)
     *
     * @param string $locale
     */
    public function setLocale(string $locale = null);

    /**
     * Set entity's UUID
     *
     * @param string $uuid
     */
    public function setUuid(string $uuid);

    /**
     * Returns entity's UUID
     */
    public function getUuid(): string;

    /**
     * Returns translations ids per locale
     *
     * @return array
     */
    public function getTranslations(): array;

    /**
     * Set translations ids per locale
     *
     * @param array $translations
     *
     * @return TranslatableInterface
     */
    public function setTranslations(array $translations): TranslatableInterface;
}
