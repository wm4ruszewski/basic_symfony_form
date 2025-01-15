<?php

namespace App\Tests\Entity;

use App\Entity\Message;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MessageTest extends TestCase
{
    private ValidatorInterface $validator;

    /**
     * @return ValidatorExtension[]
     */
    protected function getExtensions(): array
    {
        $this->validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        return [
            new ValidatorExtension($this->validator),
        ];
    }

    /**
     * @return void
     */
    public function testNameAndLastNameBlankValidation(): void
    {
        $this->getExtensions();

        $message = new Message();

        $violations = $this->validator->validate($message);

        $this->assertEquals(2, $violations->count());
        $this->assertEquals('This value should not be blank.', $violations[0]->getMessage());
        $this->assertEquals('This value should not be blank.', $violations[1]->getMessage());
    }
}
