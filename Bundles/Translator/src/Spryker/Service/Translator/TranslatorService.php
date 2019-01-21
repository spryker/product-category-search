<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Service\Translator;

use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Service\Kernel\AbstractService;
use Spryker\Service\Translator\Translator\TranslatorCacheGeneratorInterface;

/**
 * @method \Spryker\Service\Translator\TranslatorServiceFactory getFactory()
 */
class TranslatorService extends AbstractService implements TranslatorServiceInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return \Spryker\Service\Translator\Translator\TranslatorCacheGeneratorInterface
     */
    public function getTranslator(): TranslatorCacheGeneratorInterface
    {
        return $this->getFactory()->createTranslator();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return void
     */
    public function generateTranslationCache(): void
    {
        $this->getFactory()->createCacheGenerator()->generateTranslationCache();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return void
     */
    public function cleanTranslationCache(): void
    {
        $this->getFactory()->createCacheCleaner()->cleanTranslationCache();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param string $keyName
     *
     * @return bool
     */
    public function hasTranslation($keyName): bool
    {
        return $this->getFactory()->createTranslationKeyManager()->hasKey($keyName);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param string $keyName
     * @param array $data
     * @param \Generated\Shared\Transfer\LocaleTransfer|null $localeTransfer
     *
     * @return string
     */
    public function translate($keyName, array $data = [], ?LocaleTransfer $localeTransfer = null): string
    {
        return $this->getFactory()->createTranslator()->trans($keyName, $data, null, $localeTransfer->getLocaleName());
    }
}
