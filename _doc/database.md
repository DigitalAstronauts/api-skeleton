# Database setup

Setup for development purpose.

## Development database

Name of default development database is `micomare_api`. Create it on your development database server.

## Create user and grant rights

```sql
CREATE USER 'micomare_api'@'%' IDENTIFIED BY 'mic0M4r3_4PI';
GRANT ALL PRIVILEGES ON micomare_api.* TO 'micomare_api'@'%';
```
