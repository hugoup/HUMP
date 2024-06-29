# hump Dumper

Local dump-tool.

### Extra
Adds trace and all globals to the dump.

### Docker-support
Sure, just make sure to add the following extra_hosts to your `docker-compose.yml`:
```yaml
services:
  php:
    image: php:8.2-apache
    ports:
      - 80:80
    volumes:
      - ../clients/PHP/:/var/www/html/
    extra_hosts:
      - "host.docker.internal:host-gateway"
```

### Theme-support.
![Dark](screenshots/dark.png)
![Light](screenshots/light.png)


