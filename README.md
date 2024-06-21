<h1> Como rodar o docker </h1>
Após clonar o projeto, entre nele e digite

```
docker compose up --build
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan storage:link
```

AdminEmailFromDataBase@mail.com
1q2w3e4r

<h1> Rotas </h1>

<bold> Url base: </bold> http://localhost:8000/api/

<h2> Rotas sem autenticação </h2>

Cadastro

```
Url: /register
Método: post

Corpo da requisição:

{
    "name":"Carlos Alberto",
    "surname":"Carlos",
    "password":"11111111",
    "email":"ca@email.com",
    "description":"Carlos Alberto"
}

Resposta em caso de sucesso:

{
    "message": "Usuário Criado"
}
```

<hr />
Login

```
Url: /login
Método: post

Corpo da requisição:

{
    "email": "aa@mail.com",
    "password": "121212212"
}

Respota em caso de sucesso:

{
    "access_token": "2|Oid54XKvHnBBQxpCAZDgMMSFxVKnbyl7KHrud6r4555341b8",
    "token_type": "Bearer"
}

```

<hr />
Buscar ongs

```
Url: /buscar
Método: get

Corpo da requisição:

{
    "search": ""
}

Respota em caso de sucesso:

{
    [
        {
            "id": 2,
            "name": "Carlos Alberto",
            "surname": "Carlos",
            "description": "Carlos Alberto",
            "template": ""
        }
    ]
}

```

<hr />
Buscar ong

```
Url: /buscar/id
Método: get

Corpo da requisição:

{}

Respota em caso de sucesso:

{
    "template": ""
}

```
<hr />
<h1> Rotas com autenticação </h1>
<h2> Rotas do Admin </h2>

Buscar todos os Usuários

```
Url: /users
Método: get

Corpo da requisição:

{}

Reposta em caso de sucesso:

[
    {
        "id": 1,
        "name": "Carlos Alberto",
        "surname": "Carlos",
        "email": "car@email.com",
        "email_verified_at": null,
        "description": "Carlos Alberto",
        "template": "",
        "status": false,
        "admin": false
    }
]
```

<hr />
Atualizar status do usuário

```
Url: /status/id
Método: put

Corpo da requisição:

{}

Respota em caso de sucesso:

{
    "message": "Status do Usuário Atualizado"
}

```

Deletar usuário
```
Url: /delete/id
Método: delete

Corpo da requisição:

{}

Respota em caso de sucesso:

{
    "message": "Usuário deletado"
}

```
<hr />
<h2> Rotas do usuário </h2>
Salvar template

```
Url: /template
Método: post

Corpo da requisição:

{
    "template": "json transformado em string"
}

Respota em caso de sucesso:

{
    "message": "Template Salvo"
}

```

Atualizar dados de perfil

```
Url: /profile
Método: put

Corpo da requisição:

{
    "name":"Carlos Alberto",
    "surname":"Carlos",
    "description":"Carlos Alberto"
}

Respota em caso de sucesso:

{
    "message": "Perfil Atualizado"
}

```
