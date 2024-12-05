# Projeto Laravel para a Convenia

Este projeto é um teste para a Convenia, implementando APIs de autenticação e gerenciamento de funcionários. As rotas disponíveis incluem autenticação de usuários e CRUD completo para funcionários, com suporte à importação de dados via CSV.

## Pré-requisitos

Antes de começar, certifique-se de ter as seguintes ferramentas instaladas:

-   **Docker**: Laravel Sail utiliza o Docker para criar um ambiente de desenvolvimento local.
-   **Docker Compose**: A ferramenta para definir e rodar aplicações Docker multi-containers.
-   **Composer**: Usado para gerenciar dependências do PHP.

## Instalação

### Passo 1: Clonar o repositório

Clone o repositório do projeto para sua máquina local:

```bash
git clone https://github.com/gabuael/convenia-test
cd convenia-test
```

### Passo 2: Instalar as dependências do Composer

No diretório raiz do projeto, rode o comando abaixo para instalar as dependências do PHP:

```bash
composer install
```

### Passo 3: Configurar o ambiente

Copie o arquivo `.env.example` para `.env`:

```bash
cp .env.example .env
```

Abra o arquivo `.env` e configure as variáveis conforme necessário, especialmente as relacionadas ao banco de dados.

### Passo 4: Iniciar o Laravel Sail

Use o Laravel Sail para iniciar o ambiente de desenvolvimento. Caso você ainda não tenha o Sail configurado, pode rodar o seguinte comando para instalar:

```bash
composer require laravel/sail --dev
```

Para rodar o projeto com o Sail, execute:

```bash
./vendor/bin/sail up
```

Isso vai iniciar os containers Docker necessários para o Laravel.

### Passo 5: Rodar as migrações e o seeder

Agora que o Sail está rodando, execute as migrações e o seeder para popular o banco de dados:

```bash
./vendor/bin/sail artisan migrate --seed
```

Isso criará as tabelas e preencherá o banco de dados com dados de exemplo, incluindo usuários, se necessário.

---

## Endpoints da API

### 1. **Login**

-   **URL**: `/login`
-   **Método**: `POST`
-   **Descrição**: Realiza o login de um usuário.
-   **Parâmetros**:
    -   `email` (string): O e-mail do usuário.
    -   `password` (string): A senha do usuário.
-   **Resposta**:
    -   `token`: O token de autenticação.

### 2. **Gerenciamento de Funcionários (Protegido por Autenticação)**

Todas as rotas abaixo requerem um token de autenticação válido no cabeçalho `Authorization: Bearer {token}`.

#### 2.1 **Criar Funcionário**

-   **URL**: `/employee`
-   **Método**: `POST`
-   **Descrição**: Cria um novo funcionário.
-   **Parâmetros**:
    -   `name` (string): Nome do funcionário.
    -   `email` (string): E-mail do funcionário.
    -   `cpf` (string): CPF do funcionário.
    -   `city` (string): Cidade do funcionário.
    -   `state` (string): Estado do funcionário.
    -   `manager_id` (integer): ID do gerente.

#### 2.2 **Atualizar Funcionário**

-   **URL**: `/employee/{employee}`
-   **Método**: `PUT`
-   **Descrição**: Atualiza as informações de um funcionário.
-   **Parâmetros**:
    -   `employee` (integer): ID do funcionário a ser atualizado.
    -   Os parâmetros de atualização seguem o mesmo formato de criação.

#### 2.3 **Listar Funcionários**

-   **URL**: `/employee`
-   **Método**: `GET`
-   **Descrição**: Lista todos os funcionários.

#### 2.4 **Excluir Funcionário**

-   **URL**: `/employee/{employee}`
-   **Método**: `DELETE`
-   **Descrição**: Exclui um funcionário.
-   **Parâmetros**:
    -   `employee` (integer): ID do funcionário a ser excluído.

#### 2.5 **Importar Funcionários via CSV**

-   **URL**: `/employee/importCsv`
-   **Método**: `POST`
-   **Descrição**: Permite a importação de funcionários em massa via um arquivo CSV.
-   **Parâmetros**:
    -   `file` (file): Arquivo CSV contendo os dados dos funcionários.
-   **Resposta**:
    -   Retorna o status de sucesso ou erro.

> **Atenção:** O processo de importação de funcionários via CSV é executado em uma **fila**. Isso significa que o processamento da importação não será feito imediatamente. Você precisa rodar o **worker da fila** para que a importação seja processada corretamente.

---

## Como Rodar a Fila no Laravel Sail

Para processar as filas no Laravel Sail, siga os passos abaixo:

### **Rodar o Worker de Fila**

Para processar as filas, você precisa rodar o worker. Em Laravel Sail, você pode fazer isso executando o seguinte comando:

```bash
./vendor/bin/sail artisan queue:work
```

Esse comando vai iniciar o worker da fila e ele começará a processar as jobs que estiverem na fila. **Esse processo é necessário para que o endpoint de importação de funcionários via CSV funcione corretamente**.

---

## Testes

### Rodar os testes

Os testes podem ser executados usando o comando abaixo, que utiliza o **Pest**:

```bash
./vendor/bin/pest
```

Se você estiver utilizando o **Laravel Sail** e deseja rodar os testes dentro do container, utilize:

```bash
./vendor/bin/sail artisan test
```

---

## Licença

Este projeto é licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para mais detalhes.
