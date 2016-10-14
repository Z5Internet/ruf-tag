<?php namespace darrenmerrett\ReactTag\app\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

use GraphQl;

class BatchOptionsSelectionsType extends GraphQLType {

    protected $attributes = [
        'name' => 'BatchOptionsSelections',
        'description' => 'Batch Options Selections',
    ];

    public function fields() {

        return [
			'name' => [
				'type' => Type::string(),
				'description' => 'batch selection name',
			],
			'slug' => [
				'type' => Type::string(),
				'description' => 'batch selection slug',
			],
		];

    }

}