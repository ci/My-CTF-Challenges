import hashlib
import sys

i = 0
while i < 1e9:
    i += 1
    if hashlib.md5(str(i)).hexdigest().startswith(sys.argv[1]):
        print i
        exit()
