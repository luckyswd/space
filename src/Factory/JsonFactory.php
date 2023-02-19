<?php

namespace App\Factory;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class JsonFactory
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    )
    {
    }

    public function createResponseJson(
        object|array $data,
        array $headers = []
    ): Response
    {
        return new Response(
            $this->serializer->serialize($data, JsonEncoder::FORMAT, [AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true]),
            Response::HTTP_OK,
            array_merge($headers, ['Content-Type' => 'application/json;charset=UTF-8'])
        );
    }

    public function transformJsonBody(
        Request|RequestStack $request
    ): RequestStack|Request
    {
        $data = null;

        if ($request instanceof Request) {
            $data = json_decode($request->getContent(), true);
        }

        if ($request instanceof RequestStack) {
            $data = json_decode($request->getMainRequest()->getContent(), true);
        }

        if ($data === null) {
            return $request;
        }

        if ($request instanceof Request) {
            $request->request->replace($data);
        }

        if ($request instanceof RequestStack) {
            $request->getMainRequest()->request->replace($data);
        }

        return $request;
    }
}