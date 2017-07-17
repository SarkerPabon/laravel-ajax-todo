<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ListsController extends Controller
{
	public function index()
	{
		$items = Item::all();
		return view('list', compact('items'));
	}

    public function create()
    {
    	Item::forceCreate([
    		'item' => request()->text
    	]);
    	return 'Done';
    	// return $request->all();
    }

    public function update(Request $request)
    {
    	Item::whereId($request->id)->update([ 'item' => $request->value]);
    	return 'Updated';
    	// return $request->all();
    }

    public function delete(Request $request)
    {
    	Item::whereId($request->id)->delete();
    	return 'Deleted';
    	// return $request->all();
    }

    public function search(Request $request)
    {
    	$term = $request->term;
    	$items = Item::where('item', 'LIKE', '%'.$term.'%')->get();

    	if(!count($items)) {
    		$search[] = 'No Item Found';
    	} else {
    		foreach ($items as $key => $value) {
    			$search[] = $value->item;
    		}
    		/*foreach ($items as $item) {
    			$search[] = $item->item;
    		}*/
    	}

    	return $search;
    	// return $items;

    	// return $availableTags = [
    	//   "ActionScript",
    	//   "AppleScript",
    	// ];
    }
}
