<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function get_contents(Request $request)
    {
      $dados =  preg_replace("/\s+/", "+", $request->only('busca'));
      $content = file_get_contents('https://www.uplexis.com.br/blog/?s='.$dados['busca']);
      $pattern = "'<div class=\"col-md-6 title\">(.*?)</a>'si";
      $pattern2 = "'<div class=\"title\">(.*?)</a>'si";
      $pattern3 = '/Próxima página/i';

        //Verifica se existe paginação
        $pagination_articles =  preg_match_all($pattern3,  $content, $matches3);

        //Se existe paginacao
        if ($pagination_articles){
            //contador do loop
            $g = 2;
            //Façã
            do{
            $pagination = file_get_contents('https://www.uplexis.com.br/blog/page/'.$g.'/?s='.$dados['busca']);
            //Concatena a paginação extra no conteudo principal
            $content .= $pagination;
            $pagination_extra =  preg_match_all($pattern3,  $pagination, $matches3);
            $g++;
            //Enquanto houver paginação continua o loop
            }while($pagination_extra);
        }


        // Pega o codigo bruto da postagem maior(layout)
       $great_article =  preg_match_all($pattern,  $content, $matches);

        //Pega o codigo bruto de varias postagens(menores)
       $small_articles =  preg_match_all($pattern2,  $content, $matches2);





       //Recupera usuário autenticado
        $user = \Auth::user();
        $arr_title = array();
        $arr_link = array();

        //Pega titulo e link das matérias maior(em tamanho no layout)
        foreach ($matches[0] as $matche)
        {
            //regex para pegar titulo
            $regex_titulo = "'<div class=\"col-md-6 title\">(.*?)</div>'si";
            //regex para pegar link da materia
            $regex_link = '/<a href="(.*?)"/s';
            //recupera titulo
            $crawler_title = preg_match_all($regex_titulo,  $matche, $title_notformated);
            //recupera link
            $crawler_link = preg_match_all($regex_link,  $matche, $link_notformated);
            //formata titulo , o mesmo vem cheio de espaços e simbolos
            $title = preg_replace('/\\s\\s+/', ' ', $title_notformated[1]);
            //transforma array do link em string
            foreach ($link_notformated[1] as $value){
                $arr_link[] = $value;
            }
            //transforma array do titulo em string
            foreach ($title as $value){
                $arr_title[] = $value;
            }
        }
        //#################################################################################################################
        //#################################################################################################################
        //Pega titulo e link das matérias menores(em tamanho no layout)
        foreach ($matches2[0] as $matche)
        {
            //regex para pegar titulo
            $regex_titulo = "'<div class=\"title\">(.*?)</div>'si";
            //regex para pegar link da materia
            $regex_link = '/<a href="(.*?)"/s';
            //recupera titulo
            $crawler_title = preg_match_all($regex_titulo,  $matche, $title_notformated);
            //recupera link
            $crawler_link = preg_match_all($regex_link,  $matche, $link_notformated);
            //formata titulo , o mesmo vem cheio de espaços e simbolos
            $title = preg_replace('/\\s\\s+/', ' ', $title_notformated[1]);
            //transforma array do link em string
            foreach ($link_notformated[1] as $value){
                $arr_link[] = $value;
            }
            //transforma array do titulo em string
            foreach ($title as $value){
                $arr_title[] = $value;
            }


        }
        //conta numero de titulos
        $count = count($arr_title);
        //grava cada materia e seu respectivo link até a quantidade existente de titulos no count
        for ($i = 0 ; $i < $count; $i++)
        {
            Article::create([
                'id_user' => $user->id,
                'title' =>$arr_title[$i],
                'link' => $arr_link[$i]
            ]);
        }
        if ($arr_title){
            return response()->json(['status' => 'true'],200);
        }else{
            return response()->json(['status' => 'false'],200);
        }

    }

    public function show()
    {
        $user = \Auth::user();
        $articles = Article::where('id_user','=',$user->id)->select('id','title','link')->get();
        return response()->json($articles, 200);
    }

    public function destroy($id){
        $article = Article::findOrFail($id);
        $article->delete();
        return response()->json(['status' => 'true']);
    }

}
