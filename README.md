# Uso Básico

## Yii2-Advanced-APIs

Este repositório contém um conjunto de APIs construídas com Yii2 Advanced.

### Instruções de Uso:

1. **Construir as imagens:**
   ```bash
   docker-compose build
   ```
2. **Iniciar Conteiners em segundo plano:**
   ```bash
   docker-compose up -d
   ```
3. **Acessar pasta WEB do projeto:**
   ```bash
   docker-compose exec web bash
   ```
4. **Rodar as Migrations do Yii2:**
   ```bash
   php yii migrate
   ```
5. **Criar usuário via linha de comando:**
   ```bash
   php yii create-user/create <email> <password> <username>
   ```
   *utilizar o e-mail/senha para login. Substituir parâmetros <*> pelo valor desejado ex.: <br>
   php yii create-user/create teste@email.com Teste123 Luis

6. **Utilizar Collection do POSTMAN:**
   Importar a Collection no Postman para teste das APIs de autenticação, listagem e cadastro.
   A Collection já possui uma variável global para salvar o token da autenticação para uso nas demais rotas.