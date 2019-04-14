<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap/-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <title>Pesquisar</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarNavDropdown" class="navbar-collapse collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="">Pesquisar <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./articles">Artigos</a>
                </li>


            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <span class="user nav-link"></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="logout" href="#">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <form class="card card-sm">
                <div class="card-body row no-gutters align-items-center">
                    <div class="col-auto">
                        <i class="fas fa-search h4 text-body"></i>
                    </div>
                    <!--end of col-->
                    <div class="col">
                        <input class="form-control form-control-lg form-control-borderless" type="search" placeholder="Digite aqui sua pesquisa">
                    </div>
                    <!--end of col-->
                    <div class="col-auto">
                        <button class="btn btn-lg btn-success" id="buscar" type="button">Search</button>
                    </div>
                    <!--end of col-->
                </div>
            </form>
        </div>
        <!--end of col-->
    </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>


<script>
    var id = localStorage.getItem('id');
    $(function() {
        header();
        user(id);

    });



    $('#buscar').on('click', function (e) {
        e.preventDefault;
       var busca = $('[type=search]').val();
       var dados = new FormData();
       dados['busca'] = busca;
       console.log(busca);

        $.ajax({
            type: "POST",
            url: "/api/admin/get_contents",
            data: JSON.stringify(dados),
            processData: false,
            contentType: 'application/json',
            beforeSend: function() {
                $('form').append('<img id="loader" src="https://loading.io/spinners/typing/lg.-text-entering-comment-loader.gif" height="50px" width="50px" class="text-center">')
            },
            success:function (data) {
                $("#loader").remove();
                if(data.status == 'true'){
                    $('.alert').remove();
                    $('form').append('<div class="alert alert-success text-center" role="alert">Dados gravados com sucesso</div>')
                }else{
                    $('.alert').remove();
                    $('form').append('<div class="alert alert-danger text-center" role="alert">Nenhum resultado encontrado</div>')
                }

            },
            error: function(error) {
                console.log(error)
            }
        });
    });






    function user(id)
    {
        $.ajax({
            url:'/api/admin/show/'+id,
            type:'get',
            success:function (data) {
                $('.user').text(data.user)
            },
            error: function (data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (key, value) {
                    if(value == 'Unauthenticated.'){
                        window.location.href = "./";
                    }
                });
            }
        })
    }

    $('#logout').on('click',function(){
        $.ajax({
            url:'/api/admin/logout',
            type:'get',
            success:function (data) {
                localStorage.removeItem('token');
                window.location.href = "./";
            }
        })
    });

    function header() {
        $.ajaxSetup({
            headers: {
                'Accept': 'Application/json',
                'Access-Control-Allow-Origin': '*',
                'Authorization': 'Bearer '+localStorage.getItem('token')
            }
        });
    }
</script>

</body>
</html>