<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function get_contents(Request $request)
    {
      $dados =  preg_replace("/\s+/", "+", $request->only('busca'));
      $content = file_get_contents('https://www.uplexis.com.br/blog/?s='.$dados['busca']);
      $pattern = "'<div class=\"col-md-6 title\">(.*?)</div>'si";
      $pattern2 = "'<div class=\"title\">(.*?)</a>'si";

       $teste = preg_match_all($pattern,  $content, $matches);
        $teste2 = preg_match_all($pattern2,  $content, $matches2);

        dd($matches2);




    }

}
