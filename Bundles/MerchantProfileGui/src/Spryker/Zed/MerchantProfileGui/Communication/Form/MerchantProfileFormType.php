<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProfileGui\Communication\Form;

use Generated\Shared\Transfer\MerchantProfileTransfer;
use Generated\Shared\Transfer\UrlTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Spryker\Zed\MerchantProfileGui\Communication\Form\MerchantProfileGlossary\MerchantProfileLocalizedGlossaryAttributesFormType;
use Spryker\Zed\MerchantProfileGui\Communication\Form\MerchantProfileUrlCollection\MerchantProfileUrlCollectionFormType;
use Spryker\Zed\MerchantProfileGui\Communication\Form\Transformer\MerchantProfileUrlCollectionDataTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Required;

/**
 * @method \Spryker\Zed\MerchantProfileGui\MerchantProfileGuiConfig getConfig()
 * @method \Spryker\Zed\MerchantProfileGui\Communication\MerchantProfileGuiCommunicationFactory getFactory()
 */
class MerchantProfileFormType extends AbstractType
{
    public const SALUTATION_CHOICES_OPTION = 'salutation_choices';

    protected const FIELD_ID_MERCHANT_PROFILE = 'id_merchant_profile';
    protected const FIELD_CONTACT_PERSON_ROLE = 'contact_person_role';
    protected const FIELD_CONTACT_PERSON_TITLE = 'contact_person_title';
    protected const FIELD_CONTACT_PERSON_FIRST_NAME = 'contact_person_first_name';
    protected const FIELD_CONTACT_PERSON_LAST_NAME = 'contact_person_last_name';
    protected const FIELD_CONTACT_PERSON_PHONE = 'contact_person_phone';
    protected const FIELD_BANNER_URL = 'banner_url';
    protected const FIELD_LOGO_URL = 'logo_url';
    protected const FIELD_PUBLIC_EMAIL = 'public_email';
    protected const FIELD_PUBLIC_PHONE = 'public_phone';
    protected const FIELD_MERCHANT_PROFILE_LOCALIZED_GLOSSARY_ATTRIBUTES = 'merchantProfileLocalizedGlossaryAttributes';
    protected const FIELD_IS_ACTIVE = 'is_active';
    protected const FIELD_URL_COLLECTION = 'urlCollection';
    protected const FIELD_DESCRIPTION_GLOSSARY_KEY = 'description_glossary_key';
    protected const FIELD_BANNER_URL_GLOSSARY_KEY = 'banner_url_glossary_key';
    protected const FIELD_DELIVERY_TIME_GLOSSARY_KEY = 'delivery_time_glossary_key';
    protected const FIELD_TERMS_CONDITIONS_GLOSSARY_KEY = 'terms_conditions_glossary_key';
    protected const FIELD_CANCELLATION_POLICY_GLOSSARY_KEY = 'cancellation_policy_glossary_key';
    protected const FIELD_IMPRINT_GLOSSARY_KEY = 'imprint_glossary_key';
    protected const FIELD_DATA_PRIVACY_GLOSSARY_KEY = 'data_privacy_glossary_key';

    protected const LABEL_CONTACT_PERSON_ROLE = 'Role';
    protected const LABEL_CONTACT_PERSON_TITLE = 'Title';
    protected const LABEL_CONTACT_PERSON_FIRST_NAME = 'First Name';
    protected const LABEL_CONTACT_PERSON_LAST_NAME = 'Last Name';
    protected const LABEL_CONTACT_PERSON_PHONE = 'Phone';
    protected const LABEL_BANNER_URL = 'Banner';
    protected const LABEL_LOGO_URL = 'Logo';
    protected const LABEL_PUBLIC_EMAIL = 'Public Email';
    protected const LABEL_PUBLIC_PHONE = 'Public Phone';
    protected const LABEL_IS_ACTIVE = 'Is Active';

    public const URL_PATH_PATTERN = '#^([^\s\\\\]+)$#i';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => MerchantProfileTransfer::class,
        ]);

        $resolver->setRequired(static::SALUTATION_CHOICES_OPTION);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addIdMerchantProfileField($builder)
            ->addContactPersonPhoneField($builder)
            ->addContactPersonTitleField($builder, $options[static::SALUTATION_CHOICES_OPTION])
            ->addContactPersonFirstNameField($builder)
            ->addContactPersonLastNameField($builder)
            ->addContactPersonRoleField($builder)
            ->addPublicEmailField($builder)
            ->addPublicPhoneField($builder)
            ->addLogoUrlField($builder)
            ->addIsActiveField($builder)
            ->addBannerUrlField($builder)
            ->addUrlCollectionField($builder)
            ->addDescriptionGlossaryKeyField($builder)
            ->addBannerUrlGlossaryKeyField($builder)
            ->addDeliveryTimeGlossaryKeyField($builder)
            ->addTermsConditionsGlossaryKeyField($builder)
            ->addCancellationPolicyGlossaryKeyField($builder)
            ->addImprintGlossaryKeyField($builder)
            ->addDataPrivacyGlossaryKeyField($builder)
            ->addMerchantProfileLocalizedGlossaryAttributesSubform($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addUrlCollectionField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_URL_COLLECTION, CollectionType::class, [
            'entry_type' => MerchantProfileUrlCollectionFormType::class,
            'allow_add' => true,
            'label' => false,
            'allow_delete' => true,
            'entry_options' => [
                'label' => false,
                'data_class' => UrlTransfer::class,
            ],
        ]);
        $builder->get(static::FIELD_URL_COLLECTION)
            ->addModelTransformer(new MerchantProfileUrlCollectionDataTransformer());

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIsActiveField(FormBuilderInterface $builder)
    {
        $builder
            ->add(self::FIELD_IS_ACTIVE, CheckboxType::class, [
                'label' => static::LABEL_IS_ACTIVE,
                'required' => false,
            ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIdMerchantProfileField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_ID_MERCHANT_PROFILE, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addDescriptionGlossaryKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_DESCRIPTION_GLOSSARY_KEY, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addBannerUrlGlossaryKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_BANNER_URL_GLOSSARY_KEY, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addDeliveryTimeGlossaryKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_DELIVERY_TIME_GLOSSARY_KEY, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addTermsConditionsGlossaryKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_TERMS_CONDITIONS_GLOSSARY_KEY, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addCancellationPolicyGlossaryKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_CANCELLATION_POLICY_GLOSSARY_KEY, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addImprintGlossaryKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_IMPRINT_GLOSSARY_KEY, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addDataPrivacyGlossaryKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_DATA_PRIVACY_GLOSSARY_KEY, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $choices
     *
     * @return $this
     */
    protected function addContactPersonTitleField(FormBuilderInterface $builder, array $choices = [])
    {
        $builder->add(static::FIELD_CONTACT_PERSON_TITLE, ChoiceType::class, [
            'choices' => array_flip($choices),
            'required' => false,
            'label' => static::LABEL_CONTACT_PERSON_TITLE,
            'constraints' => $this->getSalutationFieldConstraints($choices),
            'placeholder' => 'Select one',

        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addContactPersonFirstNameField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_CONTACT_PERSON_FIRST_NAME, TextType::class, [
            'label' => static::LABEL_CONTACT_PERSON_FIRST_NAME,
            'constraints' => $this->getTextFieldConstraints(),
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addContactPersonLastNameField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_CONTACT_PERSON_LAST_NAME, TextType::class, [
            'label' => static::LABEL_CONTACT_PERSON_LAST_NAME,
            'constraints' => $this->getTextFieldConstraints(),
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addContactPersonRoleField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_CONTACT_PERSON_ROLE, TextType::class, [
            'label' => static::LABEL_CONTACT_PERSON_ROLE,
            'constraints' => $this->getTextFieldConstraints(),
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addPublicEmailField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_PUBLIC_EMAIL, TextType::class, [
            'label' => static::LABEL_PUBLIC_EMAIL,
            'constraints' => $this->getEmailFieldConstraints(),
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addPublicPhoneField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_PUBLIC_PHONE, TextType::class, [
            'label' => static::LABEL_PUBLIC_PHONE,
            'constraints' => $this->getTextFieldConstraints(),
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addContactPersonPhoneField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_CONTACT_PERSON_PHONE, TextType::class, [
            'label' => static::LABEL_CONTACT_PERSON_PHONE,
            'constraints' => $this->getTextFieldConstraints(),
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addLogoUrlField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_LOGO_URL, TextType::class, [
            'label' => static::LABEL_LOGO_URL,
            'required' => false,
            'constraints' => $this->getUrlFieldConstraints(),
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addBannerUrlField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_BANNER_URL, TextType::class, [
            'label' => static::LABEL_BANNER_URL,
            'required' => false,
            'constraints' => $this->getUrlFieldConstraints(),
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMerchantProfileLocalizedGlossaryAttributesSubform(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_MERCHANT_PROFILE_LOCALIZED_GLOSSARY_ATTRIBUTES, CollectionType::class, [
            'label' => false,
            'entry_type' => MerchantProfileLocalizedGlossaryAttributesFormType::class,
            'allow_add' => true,
            'allow_delete' => true,
        ]);

        return $this;
    }

    /**
     * @return \Symfony\Component\Validator\Constraint[]
     */
    protected function getTextFieldConstraints(): array
    {
        return [
            new Length(['max' => 255]),
        ];
    }

    /**
     * @return \Symfony\Component\Validator\Constraint[]
     */
    protected function getPhoneFieldConstraints(): array
    {
        return [
            new Required(),
            new NotBlank(),
            new Length(['max' => 255]),
        ];
    }

    /**
     * @return \Symfony\Component\Validator\Constraint[]
     */
    protected function getEmailFieldConstraints(): array
    {
        return [
            new Required(),
            new NotBlank(),
            new Email(),
            new Length(['max' => 255]),
        ];
    }

    /**
     * @param array $choices
     *
     * @return \Symfony\Component\Validator\Constraint[]
     */
    protected function getSalutationFieldConstraints(array $choices = []): array
    {
        return [
            new Required(),
            new NotBlank(),
            new Length(['max' => 64]),
            new Choice(['choices' => array_keys($choices)]),
        ];
    }

    /**
     * @param array $choices
     *
     * @return \Symfony\Component\Validator\Constraint[]
     */
    protected function getUrlFieldConstraints(array $choices = []): array
    {
        return [
            new Length(['max' => 255]),
            new Regex([
                'pattern' => static::URL_PATH_PATTERN,
                'message' => 'Invalid url provided. "Space" and "\" character is not allowed.',
            ]),
        ];
    }
}
