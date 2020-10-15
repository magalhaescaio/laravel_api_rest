# Teste Programador PHP #

Para auxiliar a documentação da API pode ser acessada [clicando aqui](http://acapu.com.br/atelie/doc/)

O teste foi desenvolvido utilizando Laravel!

O arquivo __.env__ possui as configurações do banco de dados, caso precise rodar o script manualmente por favor acesse o arquivo database/db.sql


## Empresas ##

### Listar ###

Lista todas as empresas ativas e cadastradas
Se nenhuma empresa estiver cadastrada ou disponível a mensagem a seguir será exibida: "__Nenhum resultado__"

```
method: GET
http://127.0.0.1:8000/api/companies
```

__Exemplo de retorno__
```
[
  {
    "id_company": 1,
    "company_name": "Geraldo e Malu Vidros ME",
    "corporate_tax_code": "41436998000159",
    "created_at": "2020-10-14T03:22:14.000000Z",
    "updated_at": "2020-10-14T18:15:26.000000Z"
  },
  {
    "id_company": 2,
    "company_name": "Samuel e Geraldo Vidros ME",
    "corporate_tax_code": "04057524000170",
    "created_at": "2020-10-14T18:13:51.000000Z",
    "updated_at": "2020-10-14T18:13:51.000000Z"
  }
]
```

### Cadastrar ###

Cadastra uma nova empresa

Os campos "__Nome da Empresa__" e "__CNPJ__" são obrigatórios.

O servidor válida números de CNPJ inválidos, portanto utilize um número válido.

[Clique aqui](https://www.4devs.com.br/gerador_de_cnpj) para acessar um gerador de CNPJ.

```
method: POST
http://127.0.0.1:8000/api/companies
```

__Corpo da requisição__

|Campo             |Valor                     |
|------------------|--------------------------|
|company_name      |Samuel e Geraldo Vidros ME|
|corporate_tax_code|04.057.524/0001-70        |


__Exemplo de retorno__

```
[
  {
    "text": "Empresa cadastrada com sucesso"
  }
]
```

### Consultar ###

Consulta empresa pelo id do cadastro (parâmetro informado na URL)

Caso o id da empresa informado não seja válido, o servidor irá retornar a seguinte mensagem: "__Empresa não localizada__"

```
method: GET
http://127.0.0.1:8000/api/companies/1
```

__Exemplo de retorno__

```
[
  {
    "id_company": 1,
    "company_name": "Caio Magalhães",
    "corporate_tax_code": "69179084000179",
    "created_at": "2020-10-14T02:39:30.000000Z",
    "updated_at": "2020-10-14T02:40:15.000000Z"
  }
]
```

### Atualizar ###

Atualiza os dados de uma empresa pelo id (parâmetro informado na URL)

Ao menos um parâmentro é obrigatório!

O servidor irá verificar se o CNPJ informado já esta cadastrado na base de dados, caso o novo CNPJ já tenha um cadastro a seguinte mensagem será exibida: "__Este CNPJ já foi cadastrado__"

```
method: PUT
http://127.0.0.1:8000/api/companies/1
```

__Corpo da requisição__

|Campo             |Valor                     |
|------------------|--------------------------|
|company_name      |Caio Correa Magalhães     |
|corporate_tax_code|98.762.923/0001-85        |

__Exemplo de retorno__

```
[
  {
    "text": "Empresa atualizada com sucesso"
  }
]
```

### Excluir ###

Deleta uma empresa pelo id (parâmetro informado na URL)

Se o servidor não localizar o id informado, a seguinte mensagem será exibida: "__Empresa não localizada__"

```
method: DELETE
http://127.0.0.1:8000/api/companies/1
```

__Exemplo de retorno__

```
[
  {
    "text": "Empresa foi excluída com sucesso"
  }
]
```

## Participantes ##

### Listar ###

Lista todos os participantes de uma empresa

Caso o id da empresa não seja especificado uma mensagem será retornada do servidor:
"__Empresa não localizada__"

Se o id do participante informado não estiver disponível o servidor irá retornar:
"__Nenhum participante cadastrado para esta empresa__"

```
method: GET
http://127.0.0.1:8000/api/1/participants
```

__Exemplo de retorno__

```
[
  {
    "id_participant": 2,
    "id_company": 1,
    "taxid": "38523888802",
    "name": "Caio Correa Magalhães",
    "mail": "developer.caio@gmail.com",
    "birthday": "1993-10-30",
    "created_at": "2020-10-14T18:22:52.000000Z",
    "updated_at": "2020-10-14T18:22:52.000000Z"
  },
  {
    "id_participant": 3,
    "id_company": 1,
    "taxid": "05840802042",
    "name": "Isabella Louise Peixoto",
    "mail": "iisabellalouisepeixoto@casaarte.com.br",
    "birthday": "1943-09-04",
    "created_at": "2020-10-14T18:24:05.000000Z",
    "updated_at": "2020-10-14T18:24:05.000000Z"
  }
]
```

### Cadastrar ###

Cadastra um novo participante para uma empresa

Todos os campos são obrigatórios.

O servidor irá validar o campo data de aniversário e CPF.

Será necessário gerar um número de CPF válido para cadastrar um participante [clique aqui](https://www.4devs.com.br/gerador_de_cpf) para gerar um número de CPF válido.

Caso um participante com o mesmo número de CPF já tenha sido cadastrado o servidor irá retornar a seguinte mensagem: "__CPF do participante já cadastrado para esta empresa__"

```
method: POST
http://127.0.0.1:8000/api/1/participants
```

__Corpo da requisição__

|Campo             |Valor                                 |
|------------------|--------------------------------------|
|taxid             |058.408.020-42                        |
|name              |Isabella Louise Peixoto               |
|mail              |iisabellalouisepeixoto@casaarte.com.br|
|birthday          |04/09/1943                            |

__Exemplo de retorno__

```
[
  {
    "text": "Participante cadastrado com sucesso"
  }
]
```

### Consultar ###

Exibe os dados do participante pelo id (parâmetro informado na URL)

Se o id da empresa for inválido, o servidor irá retornar a seguinte mensagem: "__Empresa não localizada__"

Se o id do participante for inválido, o servidor irá retornar a seguinte mensagem: "__Participante não localizado__"

```
method: GET
http://127.0.0.1:8000/api/1/participants/3
```

__Exemplo de retorno__

```
[
  {
    "id_participant": 3,
    "id_company": 1,
    "taxid": "05840802042",
    "name": "Isabella Louise Peixoto",
    "mail": "iisabellalouisepeixoto@casaarte.com.br",
    "birthday": "1943-09-04",
    "created_at": "2020-10-14 03:22:14",
    "updated_at": "2020-10-14 18:19:31",
    "company_name": "Caio Correa Magalhães LTDA",
    "corporate_tax_code": "98762923000185"
  }
]
```

### Atualizar ###

Atualiza os dados do participante pelo id (parâmetro informado na URL)

Se o id da empresa for inválido, o servidor irá retornar a seguinte mensagem: "__Empresa não localizada__"

Se o id do participante for inválido, o servidor irá retornar a seguinte mensagem: "__Participante não localizado__"

Caso o CPF informado já tenha sido cadastrado será exibido a seguinte mensagem: "__CPF do participante já cadastrado para esta empresa__"

```
method: PUT
http://127.0.0.1:8000/api/1/participants/1
```

__Corpo da requisição__

|Campo             |Valor                                 |
|------------------|--------------------------------------|
|taxid             |690.673.420-25                        |
|name              |Caio Magalhães                        |
|mail              |caio.magalhaes@dev.com.br             |
|birthday          |30/10/1993                            |

__Exemplo de retorno__

```
[
  {
    "text": "Participante atualizado com sucesso"
  }
]
```

### Excluir ###

Deleta um participante pelo id (parâmetro informado na URL)

Se o id da empresa for inválido, o servidor irá retornar a seguinte mensagem: "__Empresa não localizada__"

Se o id do participante for inválido, o servidor irá retornar a seguinte mensagem: "__Participante não localizado__"

```
method: DELETE
http://127.0.0.1:8000/api/1/participants/1
```

__Exemplo de retorno__

```
[
  {
    "text": "Participante foi excluído com sucesso"
  }
]
```