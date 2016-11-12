<?php namespace z5internet\ReactTag\App\Http\Controllers;

use z5internet\ReactUserFramework\App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class RoutesController extends Controller {

	public function __construct(Request $request) {

		$this->request = $request;

	}

	public function addBatch() {

        $args = [
        	'name' => $this->request->input('name'),
        	'taggable_type' => $this->request->input('taggable_type'),
        	'multi' => $this->request->input('multi'),
        	'selections' => $this->request->input('selections'),
        ];

    	return [
            "data" => [
              'AddBatch' => (new BatchController)->addBatch($args)
            ]
        ];

	}

	public function addTag() {

        $args = [
        	'id' => $this->request->input('id'),
        	'bid' => $this->request->input('bid'),
        	'taggable_type' => $this->request->input('taggable_type'),
        	'tag' => $this->request->input('tag'),
        ];

    	return [
            "data" => [
                "AddTag" => (new TagController)->addTag($args)
            ]
        ];  

	}

	public function getBatchs() {

        $args = [
        	'id' => $this->request->input('id'),
        	'type' => $this->request->input('type'),
        ];

    	return [
    		"data" => [
    			"batchs" => (new BatchController)->getBatchs($args),
    			"batchNames" => (new BatchController)->getBatchNames($args),
    		]
    	];

	}

}