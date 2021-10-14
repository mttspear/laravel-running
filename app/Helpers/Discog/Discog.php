<?php

namespace App\Helpers\Discog;

use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class Discog
{
    public $baseUrl = "https://api.discogs.com";
    private $secret;
    private $key;

    public function __construct()
    {
        $this->secret = Config::get("services.discog.secret");
        $this->key = Config::get("services.discog.key");
    }

    public function getClient()
    {
        $response = Http::baseUrl($this->baseUrl)->get("/database/search", [
            "q" => "Nirvana",
            "key" => $this->key,
            "secret" => $this->secret,
        ]);
    }

    /**
     * Search the db
     */
    public function search($searchString)
    {
        $response = Http::baseUrl($this->baseUrl)->get("/database/search", [
            "q" => $searchString,
            "key" => $this->key,
            "secret" => $this->secret,
        ]);
        return $response->json();
    }

    public function getArtistById($artistId)
    {
        $response = Http::baseUrl($this->baseUrl)->get(
            "/artists/" . $artistId,
            [
                "key" => $this->key,
                "secret" => $this->secret,
            ]
        );
        return $response->json();
    }

    /**
     * Format the returned data so that only artist results are selected
     */
    public function getArtistFromSearch($artist)
    {
        $results = $this->search($artist);
        $artists = [];
        foreach ($results["results"] as $result) {
            if ($result["type"] == "artist") {
                $artists[] = $result;
            }
        }
        return $artists;
    }

    /**
     * Search for the artist
     */
    public function getSong($song, $artist)
    {
        $results = $this->search($artist . " " . $song);
        //Log::info("getSongResults:" . print_r($results, true));
        $url = null;
        foreach ($results["results"] as $result) {
            if (isset($result["master_url"])) {
                $url = $result["master_url"];
                break;
            }
        }

        Log::info("Song:" . $song . " Artist:" . $artist . " URL:" . $url);
        $response = Http::get($url)->json();
        return $response;
    }
}
