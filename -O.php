<?php

class GenericEncoder
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function encodeToFormat($data, string $format): string
    {
        $encoder = $this->encoderFactory->createForFormat($format);

        return $encoder->encode($data);
    }
}

interface EncoderInterface
{
    public function encode($data): string;
}


class JsonEncoder implements EncoderInterface
{
    public function encode($data): string
    {
        $this->prepareData($data);
    }

    private function prepareData($data)
    {
        // TODO: Implement prepareData() method.
    }
}

class XmlEncoder implements EncoderInterface
{
    public function encode($data): string
    {
        $this->prepareData($data);
    }

    private function prepareData($data)
    {
        // TODO: Implement prepareData() method.
    }
}

interface EncoderFactoryInterface
{
    public function createForFormat(string $format): EncoderInterface;
}

class EncoderFactory implements EncoderFactoryInterface
{
    private $factories = [];

    public function addEncoderFactory(string $format, callable $factory)
    {
        $this->factories[$format] = $factory;
    }

    public function createForFormat(string $format): EncoderInterface
    {
        $factory = $this->factories[$format];

        $encoder = $factory();

        return $encoder;
    }
}

$encoderFactory = new EncoderFactory();

$encoderFactory->addEncoderFactory('json', function () {
    return new JsonEncoder();
});
$encoderFactory->addEncoderFactory('xml', function () {
    return new XmlEncoder();
});

$genericEncoder = new GenericEncoder($encoderFactory);

$json = $genericEncoder->encodeToFormat('', 'json');























/* Wrapper around default EncoderFactory so it can fallback onto it. Called Decoration. */
class MyCustomEncoderFactory implements EncoderFactoryInterface
{
    private $fallbackFactory;
    private $serviceLocator;

    public function __construct(
        ServiceLocatorInterface $serviceLocator,
        EncoderFactoryInterface $fallbackFactory
    ) {
        $this->serviceLocator = $serviceLocator;
        $this->fallbackFactory = $fallbackFactory;
    }
    public function createForFormat($format): EncoderInterface
    {
        if ($this->serviceLocator->has($format . '.encoder') {
            return $this->serviceLocator
                ->get($format . '.encoder');
    }
        return $this->fallbackFactory->createForFormat($format);
    }
}
