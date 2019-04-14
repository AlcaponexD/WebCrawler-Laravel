# upLexis
Aplicação desenvolvida para buscar artigos no site uplexis.com.br/blog e gravar no banco de dados o titulo e url.

Desenvolvido API e utilizado ajax para o consumo do mesmo.

#Instruções para rodar a aplicação : 


►composer install.

►Copiar o arquivo .env.example , e renomear para .env

►php artisan key:generate

►Criar banco de dados e configurar usuário e senha.

►php artisan jwt:secret

►php artisan migrate --seed

►Para teste local , ligar o servidor com o comando php artisan serve.

►Acesso pela url http://localhost:8000/


#Informações de servidor utilizados:
Apache/2.4.35 (Win32) OpenSSL/1.1.0i PHP/7.2.11

Versão do cliente de base de dados: libmysql - mysqlnd 5.0.12

versão do PHP: 7.2.11
