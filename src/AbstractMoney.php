<?php

namespace Brick\Money;

use Brick\Money\Exception\MoneyMismatchException;

use Brick\Math\BigNumber;
use Brick\Math\Exception\ArithmeticException;

/**
 * Base class for Money and RationalMoney.
 */
abstract class AbstractMoney implements MoneyContainer
{
    /**
     * @return BigNumber
     */
    abstract public function getAmount();

    /**
     * @return Currency
     */
    abstract public function getCurrency();

    /**
     * Required by interface MoneyContainer.
     *
     * @return BigNumber[]
     */
    public function getAmounts()
    {
        return [
            $this->getCurrency()->getCurrencyCode() => $this->getAmount()
        ];
    }

    /**
     * Returns the sign of this money.
     *
     * @return int -1 if the number is negative, 0 if zero, 1 if positive.
     */
    public function getSign()
    {
        return $this->getAmount()->sign();
    }

    /**
     * Returns whether this money has zero value.
     *
     * @return bool
     */
    public function isZero()
    {
        return $this->getAmount()->isZero();
    }

    /**
     * Returns whether this money has a negative value.
     *
     * @return bool
     */
    public function isNegative()
    {
        return $this->getAmount()->isNegative();
    }

    /**
     * Returns whether this money has a negative or zero value.
     *
     * @return bool
     */
    public function isNegativeOrZero()
    {
        return $this->getAmount()->isNegativeOrZero();
    }

    /**
     * Returns whether this money has a positive value.
     *
     * @return bool
     */
    public function isPositive()
    {
        return $this->getAmount()->isPositive();
    }

    /**
     * Returns whether this money has a positive or zero value.
     *
     * @return bool
     */
    public function isPositiveOrZero()
    {
        return $this->getAmount()->isPositiveOrZero();
    }

    /**
     * Compares this money to the given amount.
     *
     * @param AbstractMoney|BigNumber|number|string $that
     *
     * @return int [-1, 0, 1] if `$this` is less than, equal to, or greater than `$that`.
     *
     * @throws ArithmeticException    If the argument is an invalid number.
     * @throws MoneyMismatchException If the argument is a money in a different currency.
     */
    public function compareTo($that)
    {
        $that = $this->handleAbstractMoney($that);

        return $this->getAmount()->compareTo($that);
    }

    /**
     * Returns whether this money is equal to the given amount.
     *
     * @param AbstractMoney|BigNumber|number|string $that
     *
     * @return bool
     *
     * @throws ArithmeticException    If the argument is an invalid number.
     * @throws MoneyMismatchException If the argument is a money in a different currency.
     */
    public function isEqualTo($that)
    {
        $that = $this->handleAbstractMoney($that);

        return $this->getAmount()->isEqualTo($that);
    }

    /**
     * Returns whether this money is less than the given amount.
     *
     * @param AbstractMoney|BigNumber|number|string $that
     *
     * @return bool
     *
     * @throws ArithmeticException    If the argument is an invalid number.
     * @throws MoneyMismatchException If the argument is a money in a different currency.
     */
    public function isLessThan($that)
    {
        $that = $this->handleAbstractMoney($that);

        return $this->getAmount()->isLessThan($that);
    }

    /**
     * Returns whether this money is less than or equal to the given amount.
     *
     * @param AbstractMoney|BigNumber|number|string $that
     *
     * @return bool
     *
     * @throws ArithmeticException    If the argument is an invalid number.
     * @throws MoneyMismatchException If the argument is a money in a different currency.
     */
    public function isLessThanOrEqualTo($that)
    {
        $that = $this->handleAbstractMoney($that);

        return $this->getAmount()->isLessThanOrEqualTo($that);
    }

    /**
     * Returns whether this money is greater than the given amount.
     *
     * @param AbstractMoney|BigNumber|number|string $that
     *
     * @return bool
     *
     * @throws ArithmeticException    If the argument is an invalid number.
     * @throws MoneyMismatchException If the argument is a money in a different currency.
     */
    public function isGreaterThan($that)
    {
        $that = $this->handleAbstractMoney($that);

        return $this->getAmount()->isGreaterThan($that);
    }

    /**
     * Returns whether this money is greater than or equal to the given amount.
     *
     * @param AbstractMoney|BigNumber|number|string $that
     *
     * @return bool
     *
     * @throws ArithmeticException    If the argument is an invalid number.
     * @throws MoneyMismatchException If the argument is a money in a different currency.
     */
    public function isGreaterThanOrEqualTo($that)
    {
        $that = $this->handleAbstractMoney($that);

        return $this->getAmount()->isGreaterThanOrEqualTo($that);
    }

    /**
     * Returns the amount of the given parameter.
     *
     * If the parameter is a money, its currency is checked against this money's currency.
     *
     * @param AbstractMoney|BigNumber|number|string $that A money or amount.
     *
     * @return BigNumber|number|string
     *
     * @throws MoneyMismatchException If currencies don't match.
     */
    protected function handleAbstractMoney($that)
    {
        if ($that instanceof AbstractMoney) {
            if (! $that->getCurrency()->is($this->getCurrency())) {
                throw MoneyMismatchException::currencyMismatch($this->getCurrency(), $that->getCurrency());
            }

            return $that->getAmount();
        }

        return $that;
    }
}