from z3 import *
import sys
import hashlib

key = [BitVec("k" + str(i), 32) for i in range(8)]

def is_num(x):
    return And(x >= 0, x <= 9)

def is_md5_magic(x):
    md5 = hashlib.md5('a' + x + 'a').hexdigest()
    return md5[:2] == '0e' and all([c in '0123456789' for c in md5[2:]])

def model_to_string(key, model):
    return ''.join(str(model[k].as_long()) for k in key)

s = Solver()

for i in key:
    s.add(is_num(i))
s.add(key[3] == key[5])
s.add(key[5] == key[7])
s.add(key[0] + key[2] == key[3])
s.add(key[0] * key[1] == 30)
s.add(key[2] + key[6] == key[1])


# z3 trick, try all solutions (hopefully not infinite)
solutionCnt = 0
while s.check() == sat:
    model = s.model()
    s.add(Or(
        key[0] != model[key[0]],
        key[1] != model[key[1]],
        key[2] != model[key[2]],
        key[3] != model[key[3]],
        key[4] != model[key[4]],
        key[5] != model[key[5]],
        key[6] != model[key[6]],
        key[7] != model[key[7]]))
    stringified = model_to_string(key, model)
    if is_md5_magic(stringified):
        print("The final solution should be: %s" % stringified)
        print("Let's hope it's the only one...")

    solutionCnt += 1

print("%d solutions found by z3" % solutionCnt)
