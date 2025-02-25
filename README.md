# **🚀 Sistema de login com PHP puro 🚀**

![PHP](https://img.shields.io/badge/PHP-8.2-blue?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-blue?style=for-the-badge&logo=mysql)
![Docker](https://img.shields.io/badge/Docker-✔-blue?style=for-the-badge&logo=docker)


---


### Comandos para funcionamento
> [!IMPORTANT]
> A unica ferramenta que o usuário deve ter em sua máquina para o funcionamento desse projeto é o docker.


##### No seu terminal linux ou wsl digite
```bash
    cd docker
    docker compose up
```
 Na pasta docker crie um arquivo chamado .env e cole tudo que estiver dentro do .env.example, caso queira mudar as  variáveis mude as informações também no arquivo Database.php.

---
### Rotas


#### <span style="color: #87ceeb;">GET ('/')</span>

#### <span style="color: #84fa84;">POST ('/users/create')</span>

#### <span style="color: #84fa84;">POST ('/users/login')</span>
#### <span style="color: #87ceeb;">GET('/users/fetch')</span>
#### <span style="color: #87ceeb;">GET('/db/table')</span>
#### <span style="color: #87ceeb;">GET ('/db/table/delete')</span>
#### <span style="color: #e5f28c ;">PUT('/users/update')</span>
#### <span style="color: #a52a2a;">DELETE('/users/delete')</span>

---
