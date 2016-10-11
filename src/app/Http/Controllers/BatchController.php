<?php namespace darrenmerrett\ReactTag\App\Http\Controllers;

use darrenmerrett\ReactUserFramework\App\Http\Controllers\Controller;

use darrenmerrett\ReactTag\Model\TagBatch;

use darrenmerrett\ReactTag\Model\Tagged;

use Team;

use Auth;

class BatchController extends Controller {

    public function __construct() {

    }

	public function getBatchs($args) {

    	$batchs = TagBatch::where('tid', Team::currentTeam());

        $type = '';

        if (array_get($args, 'type')) {
    
            $type = $this->getTaggableTypeFromSlug($args['type']);

            $batchs = $batchs->where('taggable_type',$type);

        }

        $batchs = $batchs->get();

        $out = [];

        foreach($batchs as $key => $tb) {

            $batchs[$key]->taggable_type = $this->getSlugFromTaggableType($tb->taggable_type);
            $batchs[$key]->options = json_decode($tb->options);

        }

        if (array_get($args, 'type')) {

            $batchIndex = [];

            foreach($batchs as $key => $tb) {

                $batchIndex[$tb->id] = $key;

            }

            $db = Tagged::where('tid', Team::currentTeam());
            $db = $db->where('taggable_id',$args['id']);
            $db = $db->where('taggable_type',$type);
            $db = $db->get();

            $temp = []; 

            foreach ($db as $tdb) {

                $bid = $tdb->tag_batch_id;

                $bidIndex = $batchIndex[$bid];

                $temp = array_add($temp,$bidIndex,[]);

                $temp[$bidIndex] = array_add($temp[$bidIndex],$tdb->taggable_id,[]);

                $temp[$bidIndex][$tdb->taggable_id] = [

                    'name' => $tdb->tag_name,
                    'slug' => $tdb->tag_slug,

                ];

            }

            foreach ($temp as $k => $v) {

                $batchs[$k]->tags = $v;

            }

        }

        return $batchs;

	}

    public function getBatchNames() {

        return $this->getBatchConfig();

    }

    public function addBatch($args) {

        $uid = Auth::id();

        $batch = new TagBatch;

        $selections = explode(',', $args['selections']);

        foreach ($selections as $k => $v) {

            $selections[$k] = [
                'name' => trim($v),
                'slug' => str_slug(trim($v)),
            ];

        }

        $batchOptions = [
            'quantity' => $args['multi']?0:1,
            'selections' => $selections,
        ];

        $batch->tid = Team::currentTeam();
        $batch->added_by = $uid;
        $batch->taggable_type = $this->getTaggableTypeFromSlug($args['taggable_type']);
        $batch->slug = str_slug($args['name']);
        $batch->name = $args['name'];
        $batch->options = json_encode($batchOptions);
        
        $batch->save();

        $batch->taggable_type = $args['taggable_type'];
        $batch->options = $batchOptions;

        return $batch;

    }

    public function getSlugFromTaggableType($tt) {

        $conf = $this->getBatchConfig();

        foreach($conf as $v) {

            if ($v['model'] == $tt) {

                return $v['slug'];

            }

        }

    }

    public function getTaggableTypeFromSlug($slug) {

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

