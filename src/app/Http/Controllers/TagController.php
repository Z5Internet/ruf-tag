<?php namespace z5internet\ReactTag\App\Http\Controllers;

use z5internet\ReactUserFramework\App\Http\Controllers\Controller;

use z5internet\ReactTag\Model\TagBatch;

use z5internet\ReactTag\Model\Tagged;

use Team;

use Auth;

use Nuwave\Relay\Traits\GlobalIdTrait;

class TagController extends Controller {

	use GlobalIdTrait;

    public function __construct() {

    	$this->BatchController = new BatchController;

    }

	public function addTag($args) {

		$model = $this->BatchController->getTaggableTypeFromSlug(str_slug($args['taggable_type']));

		$db = $model::where('tid', Team::currentTeam());

		$db = $this->getDBById($db, $args['id']);

		$db->tag($args['bid'], $args['tag']);

		return [];

	}

	private function getDBById($db, $id) {

		if (is_string($id)) {

			return $this->getDBByStringId($db, $id);

		}

		return $this->getDBByNumericId($db, $id);

	}

	private function getDBByNumericId($db, $id) {

		$db = $db->where('id', $id);
		$db = $db->with('tagged')->first();

		return $db;

	}

	private function getDBByStringId($db, $id) {

		$stringId = $this->decodeGlobalId($id)[1];

		$db1 = $db->where('id', $stringId);
		$db1 = $db1->with('tagged')->first();

		if (!$db1) {

			$db1 = $this->getDBByNumericId($db, $id);

		}

		return $db1;

	}

}

