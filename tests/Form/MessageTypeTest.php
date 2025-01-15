<?php

namespace App\Tests\Form;

use App\Entity\Message;
use App\Form\MessageType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class MessageTypeTest extends TypeTestCase
{
    /**
     * @return ValidatorExtension[]
     */
    protected function getExtensions(): array
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        return [
            new ValidatorExtension($validator),
        ];
    }

    /**
     * @return void
     */
    public function testSubmitValidData(): void
    {
        $formData = [
            'name' => 'John Doe',
            'lastname' => '12345678910',
        ];

        $message = new Message();

        $form = $this->factory->create(MessageType::class, $message);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());

        $expectedMessage = new Message();
        $expectedMessage->setName($formData['name']);
        $expectedMessage->setLastname($formData['lastname']);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }

        $this->assertEquals($expectedMessage, $form->getData());
    }

    /**
     * @return void
     */
    public function testSubmitBlankLastName(): void
    {
        $formData = [
            'lastname' => 'John Doe',
        ];

        $message = new Message();

        $form = $this->factory->create(MessageType::class, $message);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
    }

    /**
     * @return void
     */
    public function testSubmitBlankName(): void
    {
        $formData = [
            'name' => '12345678901',
        ];

        $message = new Message();

        $form = $this->factory->create(MessageType::class, $message);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
    }
}
