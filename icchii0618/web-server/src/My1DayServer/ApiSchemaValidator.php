<?php

namespace My1DayServer;

class ApiSchemaValidator extends \JsonSchema\Validator
{
    protected $schema;
    protected $refResolver;

    public function setDefaultSchemaByLocation($location)
    {
        $retriever = new \JsonSchema\Uri\UriRetriever;
        $this->schema = $retriever->retrieve($location);
    }

    public function setRefResolver($refResolver)
    {
        $this->refResolver = $refResolver;
    }

    public function getDefaultSchema()
    {
        return $this->schema;
    }

    protected function validateBySchema($value, $category, $defaultPropertyName, $index = null, $baseSchema = null)
    {
        if (null === $baseSchema) {
            $baseSchema = $this->schema;
        }

        $this->refResolver->resolve($baseSchema);
        $categorySchema = $baseSchema->definitions->{$category};

        $linkConfig = null;
        if (null !== $index && isset($categorySchema->links[$index])) {
            $linkConfig = $categorySchema->links[$index];
        }

        if (isset($linkConfig->{$defaultPropertyName})) {
            $_schema = $linkConfig->{$defaultPropertyName};
        } else {
            $_schema = $categorySchema;
        }

        if (isset($linkConfig->rel) && $linkConfig->rel === 'instances') {
            $schema = new \StdClass();
            $schema->type = 'array';
            $schema->items = $_schema;
        } else {
            $schema = $_schema;
        }

        return $this->check($value, $schema);
    }

    public function validateResponseBySchema($value, $category, $index = null, $baseSchema = null)
    {
        return $this->validateBySchema(json_decode($value), $category, 'targetSchema', $index, $baseSchema);
    }
}
