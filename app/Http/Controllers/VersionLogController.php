<?php

namespace App\Http\Controllers;

use App\Helpers\Params;
use Illuminate\Http\Request;


class VersionLogController extends Controller
{
    public function index(Request $request)
    {
        $id_language = strtolower($request->id_language ?? $request->query('lang') ?? "pt");

        $params = Params::all();
        $version = $request->query('version') ?? $request->query('versao') ?? $params[$id_language . "_version"];

        $version_array = explode(".", $version);
        $version_software = $version_array[0] . "." . $version_array[1];

        $url = 'https://github.com/louvorja/desktop/releases/tag/v' . $version_software;

        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        /*     $body = $response->getBody()->getContents();

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($body);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);
        $divs = $xpath->query("//div[@data-pjax='true' and @data-test-selector='body-content' and @data-view-component='true']");
        if ($divs->length > 0) {
            $div = $divs->item(0);
            $body = $div->ownerDocument->saveHTML($div);
        }
*/
        //echo $body;

        echo "EM BREVE2";
        //return redirect($url);
    }
}
