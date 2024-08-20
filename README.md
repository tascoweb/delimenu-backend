# Delimenu Backend

## Descrição

**Delimenu** é um sistema para calcular o preço de custo de produtos vendidos em pequenos restaurantes. Ele permite a criação de receitas, definição de insumos e cálculo automático do custo de produção, além de oferecer um sistema de planos e recursos customizáveis.

## Tecnologias Utilizadas

- **PHP** 8
- **Laravel** 11
- **Docker** (Laravel Sail)
- **MySQL** 8
- **Redis** para cache

## Funcionalidades (MVP - Em Desenvolvimento)

- Cadastro e gerenciamento de insumos e receitas.
- Cálculo automático do preço de custo com base nos insumos.
- Suporte a múltiplos planos de assinatura com recursos específicos.
- Sistema de recursos ativados por usuário e plano de empresa.
- Suporte multitenancy com Laravel.
- Autenticação com Laravel Sanctum.

## Instalação e Configuração

### Pré-requisitos

- Docker instalado na máquina.
- Composer instalado.

### Passos para Instalação

1. **Clone o repositório:**

   ```bash
   git clone https://github.com/tascoweb/delimenu-backend.git
   cd delimenu-backend
    ```
   
2. **Instale as dependências do projeto:**

   ```bash
   composer install
   ```
3. **Copie o arquivo .env.example para .env:**

   ```bash
   cp .env.example .env
   ```

4. **Suba os containers Docker:**

   ```bash
    ./vendor/bin/sail up -d
    ```

5. **Gere a chave da aplicação:**
    
   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

6. **Execute as migrações do banco de dados:**

   ```bash
    ./vendor/bin/sail artisan migrate
    ```

7. **Execute os seeders para popular o banco de dados:**
    
   ```bash
    ./vendor/bin/sail artisan db:seed
    ```

8. **Acesse a aplicação:**
    
   A aplicação estará disponível em http://localhost.

## Testes

Para rodar os testes, execute o comando abaixo:

```bash
./vendor/bin/sail test
```

## Como Contribuir
1. Fork o repositório.
2. Crie uma branch para sua feature (git checkout -b feature/nova-feature).
3. Commit suas alterações (git commit -m 'Adiciona nova feature').
4. Faça um push para a branch (git push origin feature/nova-feature).
5. Abra um Pull Request.

