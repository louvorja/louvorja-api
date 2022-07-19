<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Cache;

class CategoryController extends Controller
{
    public function __construct()
    {

    }

    public function index($lang)
    {
        //return $lang;
        //Cache::store('file')->put('foo', 'baz', 30);
        //return Cache::store('file')->get('foo');

        return response()->json(Category::all());
    }

    public function create(Request $request)
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Room $room)
    {
        //
    }

    public function edit(Room $room)
    {
        //
    }

    public function update(Request $request, Room $room)
    {
        //
    }

    public function destroy(Room $room)
    {
        //
    }
/*
public function findAll()
{
$token = JWT::sign([
'uid' => 1,
'email' => 'emaggil@email.com',
'asd' => 'emaggil@AAADD',
]);

echo "<pre>";
echo $token."\r\n";
$result = JWT::verify($token);
if (!$result){
echo "<br>eeeeeee";
}else{
print_r($result);
}

print $token;
// return response()->json(Room::all());
}
 */
}
