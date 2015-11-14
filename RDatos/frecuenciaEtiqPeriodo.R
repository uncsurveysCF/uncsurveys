# freceunciaEtiquetas.R : Distribucion de Frecuencia

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
idPeriodo <- args[2]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste("SELECT CONCAT(O.idOpcion,' - ',O.Texto,'##') AS Texto, (SELECT COUNT(*) FROM respuestaspreguntas R INNER JOIN respuestas E ON R.idRespuesta = E.idRespuesta WHERE R.idOpcion = O.idOpcion AND E.idPeriodo = ", idPeriodo," ) AS Cantidad from opcionespreguntas O where O.idPregunta = ",idP,sep='')
dbGetQuery(con, sql) -> datos
a <- table(datos$Texto)
tot <- sum(datos$Cantidad)
r <- datos$Cantidad / tot
old = options(digits=4) 
r <- r * 100
datos$Texto
dbDisconnect(con)