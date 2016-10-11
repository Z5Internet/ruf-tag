<?php namespace darrenmerrett\ReactTag\app\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

use GraphQl;

class BatchOptionsType extends GraphQLType {

    protected $attributes = [
        'name' => 'batchOptions',
        'description' => 'Batch Options',
    ];

    public function fields() {

        return [
			'quantity' => [
				'type' => Type::int(),
				'description' => 'batch options quantity',
			],
			'selections' => [
				'type' => Type::listOf(GraphQL::type('batchOptionsSelections')),
				'description' => 'Added by',
			],
		];

    }

}