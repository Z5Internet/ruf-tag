<?php namespace darrenmerrett\ReactTag\App\Http\Controllers;

use darrenmerrett\ReactUserFramework\App\Http\Controllers\Controller;

use darrenmerrett\ReactTag\Model\TagBatch;

use darrenmerrett\ReactTag\Model\Tagged;

use Team;

use Auth;

class TagController extends Controller {

    public function __construct() {

    	$this->BatchController = new BatchController;

    }

	public function addTag($args) {

		$model = $this->BatchController->getTaggableTypeFromSlug(str_slug($args['taggable_type']));
		$db = $model::where('tid', Team::currentTeam());
		$db = $db->where('id', $args['id']);

		$db = $db->with('tagged')->first();

		$db->tag($args['bid'], str_slug($args['tag']));

		return $db;

	}

}

