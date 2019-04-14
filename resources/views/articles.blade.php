<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap/-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <title>Pesquisar</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarNavDropdown" class="navbar-collapse collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./dashboard">Pesquisar</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Artigos <span class="sr-only">(current)</span></a>
                </li>


            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" id="logout" href="#">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
<div class="container">
    <table id="artigos" class="display" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>Link</th>
            <th>Ação</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


<script>
    var id = localStorage.getItem('id');
    $(function() {
        header();
        user(id);
        articles();


    });

    function articles() {
        $.ajax({
            url:'/api/admin/show_articles',
            type:'get',
            success:function (data) {
                for(i = 0 ; i < data.length; i++)
                {
                    var html = '<tr id="'+data[i].id+'">';
                    html += '<td>'+data[i].id+'</td>';
                    html += '<td>'+data[i].title+'</td>';
                    html += '<td>'+data[i].link+'</td>';
                    html += '<td><button onclick="delete_article('+data[i].id+')">Deletar</button></td>';
                    html += '</tr>';
                    $('tbody').append(html);
                }
            },
            complete: function () {
                $('#artigos').DataTable();
            }
        })

    }
    function delete_article(id){
        $('#'+id+'').remove();

        $.ajax({
            url:'/api/admin/delete/article/'+id,
            type:'delete',
            success:function (data) {
            }
        })
    }
    function user(id)
    {
        $.ajax({
            url:'/api/admin/show/'+id,
            type:'get',
            success:function (data) {
                console.log(data)
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