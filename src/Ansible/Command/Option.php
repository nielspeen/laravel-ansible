<?php

namespace Peen\Ansible\Command;

class Option
{
    protected string|null $name = null;
    protected string|null $value = null;

    /**
     * Option constructor.
     */
    public function __construct(?string $name, ?string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    public function __toString() : string
    {
        return sprintf('%s=%s', $this->name, $this->value);
    }

    public function toString(): string
    {
        return $this->__toString();
    }

    public function equals(?Option $other) : bool
    {
        if ($other === null) {
            return false;
        }

        return $this->name === $other->getName() && $this->value === $other->value;
    }
}
