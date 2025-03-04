# Voucher Fácil API

## Schedules

- Todo dia às 08:00 é verificado se tem voucher para disparar e-mail e SMS para usuário
- Todo dia às 02:00 e 14:00 é gerado os backups do banco de dados
- Todo dia às 01:00 é limpado os backups antigos do banco de dados

## Comandos 

- Sincronizar cidades_promocoes
php artisan sync:cidade_promocao

- Gerar **path** e **path_com_uf** da tabela **cidades**
php artisan gerapath:cidades

- Corrige paths das fotos
php artisan fotos:corrige_path
