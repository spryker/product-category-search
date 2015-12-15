<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Customer\Business;

use Generated\Shared\Transfer\AddressesTransfer;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method CustomerDependencyContainer getDependencyContainer()
 */
class CustomerFacade extends AbstractFacade
{

    /**
     * @param string $email
     *
     * @return bool
     */
    public function hasEmail($email)
    {
        return $this->getDependencyContainer()
            ->createCustomer()
            ->hasEmail($email);
    }

    /**
     * @param CustomerTransfer $customerTransfer
     *
     * @return CustomerResponseTransfer
     */
    public function registerCustomer(CustomerTransfer $customerTransfer)
    {
        return $this->getDependencyContainer()
            ->createCustomer()
            ->register($customerTransfer);
    }

    /**
     * @param CustomerTransfer $customerTransfer
     *
     * @return CustomerTransfer
     */
    public function confirmRegistration(CustomerTransfer $customerTransfer)
    {
        return $this->getDependencyContainer()
            ->createCustomer()
            ->confirmRegistration($customerTransfer);
    }

    /**
     * @param CustomerTransfer $customerTransfer
     *
     * @return CustomerResponseTransfer
     */
    public function forgotPassword(CustomerTransfer $customerTransfer)
    {
        return $this->getDependencyContainer()
            ->createCustomer()
            ->forgotPassword($customerTransfer);
    }

    /**
     * @param CustomerTransfer $customerTransfer
     *
     * @return CustomerResponseTransfer
     */
    public function restorePassword(CustomerTransfer $customerTransfer)
    {
        return $this->getDependencyContainer()
            ->createCustomer()
            ->restorePassword($customerTransfer);
    }

    /**
     * @param CustomerTransfer $customerTransfer
     *
     * @return bool
     */
    public function deleteCustomer(CustomerTransfer $customerTransfer)
    {
        return $this->getDependencyContainer()
            ->createCustomer()
            ->delete($customerTransfer);
    }

    /**
     * @param CustomerTransfer $customerTransfer
     *
     * @return CustomerTransfer
     */
    public function getCustomer(CustomerTransfer $customerTransfer)
    {
        return $this->getDependencyContainer()
            ->createCustomer()
            ->get($customerTransfer);
    }

    /**
     * @param CustomerTransfer $customerTransfer
     *
     * @return CustomerResponseTransfer
     */
    public function updateCustomer(CustomerTransfer $customerTransfer)
    {
        return $this->getDependencyContainer()
            ->createCustomer()
            ->update($customerTransfer);
    }

    /**
     * @param CustomerTransfer $customerTransfer
     *
     * @return CustomerResponseTransfer
     */
    public function updateCustomerPassword(CustomerTransfer $customerTransfer)
    {
        return $this->getDependencyContainer()
            ->createCustomer()
            ->updatePassword($customerTransfer);
    }

    /**
     * @param AddressTransfer $addressTransfer
     *
     * @return AddressTransfer
     */
    public function getAddress(AddressTransfer $addressTransfer)
    {
        return $this->getDependencyContainer()
            ->createAddress()
            ->getAddress($addressTransfer);
    }

    /**
     * @param CustomerTransfer $customerTransfer
     *
     * @return AddressesTransfer
     */
    public function getAddresses(CustomerTransfer $customerTransfer)
    {
        return $this->getDependencyContainer()
            ->createAddress()
            ->getAddresses($customerTransfer);
    }

    /**
     * @param AddressTransfer $addressTransfer
     *
     * @return AddressTransfer
     */
    public function updateAddress(AddressTransfer $addressTransfer)
    {
        return $this->getDependencyContainer()
            ->createAddress()
            ->updateAddress($addressTransfer);
    }

    /**
     * @param AddressTransfer $addressTransfer
     *
     * @return CustomerTransfer
     */
    public function updateAddressAndCustomerDefaultAddresses(AddressTransfer $addressTransfer)
    {
        return $this->getDependencyContainer()
            ->createAddress()
            ->updateAddressAndCustomerDefaultAddresses($addressTransfer);
    }

    /**
     * @param AddressTransfer $addressTransfer
     *
     * @return CustomerTransfer
     */
    public function createAddressAndUpdateCustomerDefaultAddresses(AddressTransfer $addressTransfer)
    {
        return $this->getDependencyContainer()
            ->createAddress()
            ->createAddressAndUpdateCustomerDefaultAddresses($addressTransfer);
    }

    /**
     * @param AddressTransfer $addressTransfer
     *
     * @return AddressTransfer
     */
    public function createAddress(AddressTransfer $addressTransfer)
    {
        return $this->getDependencyContainer()
            ->createAddress()
            ->createAddress($addressTransfer);
    }

    /**
     * @param AddressTransfer $addressTransfer
     *
     * @return bool
     */
    public function setDefaultBillingAddress(AddressTransfer $addressTransfer)
    {
        return $this->getDependencyContainer()
            ->createAddress()
            ->setDefaultBillingAddress($addressTransfer);
    }

    /**
     * @param AddressTransfer $addressTransfer
     *
     * @return bool
     */
    public function setDefaultShippingAddress(AddressTransfer $addressTransfer)
    {
        return $this->getDependencyContainer()
            ->createAddress()
            ->setDefaultShippingAddress($addressTransfer);
    }

    /**
     * @param AddressTransfer $addressTransfer
     *
     * @return string
     */
    public function renderAddress(AddressTransfer $addressTransfer)
    {
        return $this->getDependencyContainer()
            ->createAddress()
            ->getFormattedAddressString($addressTransfer);
    }

    /**
     * @param CustomerTransfer $customerTransfer
     *
     * @return AddressTransfer
     */
    public function getDefaultShippingAddress(CustomerTransfer $customerTransfer)
    {
        return $this->getDependencyContainer()
            ->createAddress()
            ->getDefaultShippingAddress($customerTransfer);
    }

    /**
     * @param CustomerTransfer $customerTransfer
     *
     * @return AddressTransfer
     */
    public function getDefaultBillingAddress(CustomerTransfer $customerTransfer)
    {
        return $this->getDependencyContainer()
            ->createAddress()
            ->getDefaultBillingAddress($customerTransfer);
    }

    /**
     * @param AddressTransfer $addressTransfer
     *
     * @return AddressTransfer
     */
    public function deleteAddress(AddressTransfer $addressTransfer)
    {
        return $this->getDependencyContainer()
            ->createAddress()
            ->deleteAddress($addressTransfer);
    }

    /**
     * @param CustomerTransfer $customerTransfer
     *
     * @return bool
     */
    public function tryAuthorizeCustomerByEmailAndPassword(CustomerTransfer $customerTransfer)
    {
        return $this->getDependencyContainer()
            ->createCustomer()
            ->tryAuthorizeCustomerByEmailAndPassword($customerTransfer);
    }

}
