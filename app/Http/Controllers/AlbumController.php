<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function __construct()
    {

    }

    public function index($id_language)
    {
        return response()->json(Album::all());
    }

    public function create(Request $request)
    {
        //
    }

    public function store(Request $request)
    {/*
        $err = true;
        $len = 5;

        while ($err && $len < 10) {
            try {
                $hash = $this->hash($len);
                $room = new Room;
                $room->hash = $hash;
                $room->name = $request->name;
                $room->status = 'open';
                $room->save();
                $err = false;
            } catch (\Exception $e) {
                $err = true;
                $len++;
            }
        }

        if ($err) {
            return response()->json(['error' => 'Não foi possível criar uma sala!'], 500);
        }

        $token = JWT::sign([
            'type' => 'admin',
            'id_room' => $room->id,
            'hash' => $room->hash,
        ]);

        if ($token == "") {
            return response()->json(['error' => 'Não foi possível criar token!'], 500);
        }

        $room->token = $token;

        return $room;*/
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
