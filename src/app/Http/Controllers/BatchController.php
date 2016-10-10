<?php namespace darrenmerrett\ReactTag\App\Http\Controllers;

use darrenmerrett\ReactUserFramework\App\Http\Controllers\Controller;

use darrenmerrett\ReactTag\Model\TagBatch;

use Team;

use Auth;

class BatchController extends Controller {

    public function __construct() {

    }

	public function getBatchs($args) {

    	$batchs = TagBatch::where('tid', 1);#Team::currentTeam());
        $batchs = $batchs->get();

        foreach($batchs as $key => $tb) {

            $batchs[$key]->taggable_type = $this->getSlugFromTaggableType($tb->taggable_type);

        }

        return $batchs;

	}

    public function getBatchNames($args) {

        return $this->getBatchConfig();

    }

    public function addBatch($args) {

        $uid = Auth::id();

        $batch = new TagBatch;

        $batch->tid = Team::currentTeam();
        $batch->added_by = $uid;
        $batch->taggable_type = $this->getTaggableTypeFromSlug($args['taggable_type']);
        $batch->slug = str_slug($args['name']);
        $batch->name = $args['name'];
        $batch->options = json_encode([
            'quantity' => $args['multi']?0:1,
            'selections' => explode(',', $args['selections']),
        ]);
        
        $batch->save();

        return $batch;

    }

    private function getSlugFromTaggableType($tt) {

        $conf = $this->getBatchConfig();

        foreach($conf as $v) {

            if ($v['model'] == $tt) {

                return $v['slug'];

            }

        }

    }

    private function getTaggableTypeFromSlug($slug) {

        $conf = $this->getBatchConfig();

        foreach($conf as $v) {

            if ($v['slug'] == $slug) {

                return $v['model'];

            }

        }
        
    }

    private function getBatchConfig() {

        return config('DM.react-tag.tag_batches');

    }

}

