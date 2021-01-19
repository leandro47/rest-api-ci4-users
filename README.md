# PHP-test-1


Development of API in PHP for manipulated citizen data.

You can use this [URL](https://leandro47.com/php-test-1/public/client) to use the API, (except CLI mode). 

## Installation

Clone this repository.

```bash
git clone https://leandro47@bitbucket.org/leandro47/php-test-1.git
```

Navigate to the folder.

```bash
cd php-test-1/
```

Install all dependencies with composer.

```bash
composer install
```

Configure your .env file. Don't forget of import `api.sql` database ;D

```bash
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
database.default.hostname = localhost
database.default.database = api
database.default.username = user
database.default.password = password
database.default.DBDriver = MySQLi
```

Start the service.

```bash
php spark serve
```

#

# REST API

* It allows inserting, updating and deleting citizen data with: `first name`, `last name`, `cpf`, `email`, `phone`, `cep`, `street`, `district`, `city` and `uf`.
* Allows you to consult all citizens in ascending alphabetical order.
* Allow consulting a citizen by CPF;
It does not allow registering citizens with the same CPF.
* With the CEP the information of `street`, `district`, `city` and `uf` are sought in [ViaCep](https://viacep.com.br/): `https://viacep.com.br/ws/01001000/json/`.

### Header
A request to the API includes the following headers:

    Content-Type: application/json; charset=UTF-8


## Get list of clients

### Request

`GET /client/`

Get all clients in alphabetical order.

    localhost:8080/client/

### Response

```json
{
    "code": 200,
    "message": "OK",
    "data": [
        {
            "name": "Abigail shover",
            "cpf": "31240727232",
            "cep": "07096130",
            "street": "Rua Segundo-Tenente Ary Rauen",
            "district": "Jardim Santa Mena",
            "city": "Guarulhos",
            "uf": "SP",
            "phone": "47985472635",
            "email": "Abigail@leandro47.com"
        },
        {
            "name": "Madelyn Gilbert",
            "cpf": "75037110351",
            "cep": "88070115",
            "street": "Rua Tenente Ary Rauen",
            "district": "Estreito",
            "city": "Florianópolis",
            "uf": "SC",
            "phone": "4799956830",
            "email": "Madelyn@leandro47.com"
        },
        {
            "name": "Scarlett Salvadore",
            "cpf": "69631776948",
            "cep": "89300026",
            "street": "Rua Tenente Ary Rauen",
            "district": "Centro II Alto de Mafra",
            "city": "Mafra",
            "uf": "SC",
            "phone": "47985472635",
            "email": "Scarlett@leandro47.com"
        }
    ]
}
```

## Get a specific client

### Request

`GET /client/:cpf`

    localhost:8080/client/75037110351

### Response

``` json
{
    "code": 200,
    "message": "OK",
    "data": {
        "id": "21",
        "firstName": "Madelyn",
        "lastName": "Gilbert",
        "cpf": "75037110351",
        "cep": "88070115",
        "street": "Rua Tenente Ary Rauen",
        "district": "Estreito",
        "city": "Florianópolis",
        "uf": "SC",
        "phone": "4799956830",
        "email": "Madelyn@leandro47.com"
    }
}
```

## Create a new client

### Request

`POST /client/`

    localhost:8080/client/
### Json format

``` json
{
	"cpf": "360.853.299-46",
	"firstName": "James",
	"lastName": "Slover",
	"cep": "88512115",
	"phone": "1198756324",
	"email": "James@leandro47.com"
}
```

### Response

```json
{
    "code": 201,
    "message": "Created",
    "data": {
        "id": "22",
        "firstName": "James",
        "lastName": "Slover",
        "cpf": "36085329946",
        "cep": "88512115",
        "street": "Praça Tenente Ary Rauen",
        "district": "Santo Antônio",
        "city": "Lages",
        "uf": "SC",
        "phone": "1198756324",
        "email": "James@leandro47.com"
    }
}
```

## Get a non-existent client

### Request

`GET /client/:cpf`

    localhost:8080/client/08617207841

### Response
```json
{
    "code": 204,
    "message": "No content",
    "data": null
}
```

## Update a client

### Request

`PUT /client/:cpf`

    localhost:8080/client/31240727232

### Json format

```json
{
	"firstName": "Abigail",
	"lastName": "Updatedata",
	"cep": "07096130",
	"phone": "47985472635",
	"email": "update@leandro47.com"
}
```

### Response

```json
{
    "code": 200,
    "message": "Client updated",
    "data": {
        "id": "19",
        "firstName": "Abigail",
        "lastName": "Update",
        "cpf": "31240727232",
        "cep": "07096130",
        "street": "Rua Segundo-Tenente Ary Rauen",
        "district": "Jardim Santa Mena",
        "city": "Guarulhos",
        "uf": "SP",
        "phone": "47985472635",
        "email": "update@leandro47.com"
    }
}
```

## Delete a client

### Request

`DELETE /client/:cpf`

    localhost:8080/client/31240727232

### Response

```json
{
    "code": 200,
    "message": "Client deleted",
    "data": []
}
```


## Try to delete same client again

### Request

`DELETE /client/:cpf`

    localhost:8080/client/31240727232

### Response

```json
{
    "code": 404,
    "message": "CPF not found",
    "data": []
}
```
#  Command Line Usage

Insert a client using line of command, to do this just follow the steps below.

## Usage

Navigate to the public folder.

```bash
cd php-text-1/public
```

Run this command.

```bash
php index.php client_insert
```

Fill in the fields.

```bash
What is your CPF?: 38826620776
What is your first name?: Karol
What is your last name?: Chaver
What is your CEP?: 01001000
What is your phone number?: 11988453645
What is your email?: karol@domain.com
```
## Response

```bash
Code : 201
Message : Created

+----+------------+-----------+-------------+----------+-------------+----------+-----------+----+-------------+------------------+
| ID | First Name | Last Name | CPF         | CEP      | Street      | District | City      | UF | Phone       | Email            |
+----+------------+-----------+-------------+----------+-------------+----------+-----------+----+-------------+------------------+
| 23 | Karol      | Chaver    | 38826620776 | 01001000 | Praça da Sé | Sé       | São Paulo | SP | 11988453645 | karol@domain.com |
+----+------------+-----------+-------------+----------+-------------+----------+-----------+----+-------------+------------------+

```

## License
[MIT](https://choosealicense.com/licenses/mit/)