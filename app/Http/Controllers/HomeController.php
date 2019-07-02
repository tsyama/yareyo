<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $feed = file_get_contents('https://tsyama.hatenablog.com/feed');
        $invalid_characters = '/[^\x9\xa\x20-\xD7FF\xE000-\xFFFD]/';
        $feed = preg_replace($invalid_characters, '', $feed);
        $rss = simplexml_load_string($feed);

        $all_lines = [];
        foreach ($rss->entry as $entry) {
            $lines = explode("\n", $entry->content);
            foreach ($lines as $line) {
                $line = strip_tags($line);
                if (!strlen($line)) {
                    continue;
                }
                if (strstr($line, 'したい') !== false) {
                    $all_lines[] = $line;
                    continue;
                }
                if (strstr($line, 'やりたい') !== false) {
                    $all_lines[] = $line;
                    continue;
                }
                if (strstr($line, 'ないと') !== false) {
                    $all_lines[] = $line;
                    continue;
                }
            }
        }
        dd($all_lines);
    }
}
