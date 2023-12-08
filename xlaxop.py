import re

def alphaOrd(n):
    return n-((n-65)//26)*26

def colAlphaInc1(s, carry=1):
    st=s[-1]
    sh=s[:-1]
    n=ord(st)+carry
    carry=(n-65)//26
    result=chr(alphaOrd(n))
    if sh=='' and carry==1:
        return 'A'+result
    elif sh=='' and carry==0:
        return result
    else:
        return colAlphaInc1(sh, carry)+result

def colAlphaInc(s, inc=1):
    obj = s
    for i in range(inc):
        obj=colAlphaInc1(obj, carry=1)
    return obj

def colInc(s, inc=1):
    m=re.match(r'^([A-Z]+)(\d+)$', s)
    return colAlphaInc(m.group(1), inc)+m.group(2)

def rowInc(s, inc=1):
    m=re.match(r'^([A-Z]+)(\d+)$', s)
    return m.group(1)+str(int(m.group(2))+inc)

if __name__=='__main__':
    xlax = ['H9', 'ABZ11', 'Z99']
    for s in xlax:
        #print(rowInc(s), colInc(s))
        print(rowInc(s,5), colInc(s,5))
