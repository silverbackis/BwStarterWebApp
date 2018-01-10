<?php

namespace App\Swagger;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class SwaggerDecorator implements NormalizerInterface
{
    private $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        $patchOpPath = '/forms/{id}/submit';
        $patchOp = $docs['paths'][$patchOpPath]['patch'];
        $patchOp['summary'] = 'Submit a single input for validation';
        $patchOp['parameters'] = $docs['paths']['/forms/{id}']['get']['parameters'];
        $patchOp['parameters'][] = [
            'name' => 'fields',
            'in' => 'body',
            'required' => false,
            'schema' => [
                'type' => 'object',
                'properties' => [
                    'form_name' => [
                        'type' => 'object',
                        'properties' => [
                            'input_name' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $patchOp['responses'] = $docs['paths']['/forms/{id}']['get']['responses'];
        $patchOp['responses']['200']['description'] = "Validation passed successfully";
        $patchOp['responses']['400'] = [
            'description' => "Validation failed",
            'schema' => [
                '$ref' => '#/definitions/Form-page'
            ]
        ];
        // $patchOp['responses']['406']['description'] = "Invalid field name for the form ID";
        $patchOp['consumes'] = $docs['paths']['/forms/{id}']['put']['consumes'];
        $patchOp['produces'] = $docs['paths']['/forms/{id}']['put']['produces'];

        $docs['paths'][$patchOpPath]['patch'] = $patchOp;
        $docs['paths'][$patchOpPath]['post']['summary'] = 'Submit and validate the entire form';
        // $docs['paths'][$patchOpPath]['post']['parameters'] = $patchOp['parameters'];
        // $docs['paths'][$patchOpPath]['post']['responses']['201']['description'] = "Form successfully submitted and valid";

        return $docs;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }
}
