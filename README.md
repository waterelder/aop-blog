Aop Blog
=======

AOP demo

### Setup
```
git clone https://github.com/waterelder/aop-blog.git
bin/setup
```

### Docker
```
$ docker swarm init   #If you have not done this before
$ docker build -t aop-blog .
$ docker stack deploy -c docker-swarm.yml aop-blog   #Or you can do it in old fasion way: $docker compose -f docker-swarm.yml up -d
```
Check [http://127.0.0.1:8097](127.0.0.1:8097)