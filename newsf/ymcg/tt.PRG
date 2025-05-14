LOCATE FOR '-' $ l2
DO WHILE NOT EOF()
  l3=strt(l2,'-','')
  l20=ALLTRIM(l2)
  RENAME (l20) TO (l3)
  CONTINUE
 ENDDO
 