# freceuncia.R : Distribucion de Frecuencia

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste("SELECT CONCAT(O.Texto,'##') AS Texto, (SELECT COUNT(*) FROM respuestaspreguntas R WHERE R.idOpcion = O.idOpcion) AS Cantidad from opcionespreguntas O where O.idPregunta = ",idP,sep='')
dbGetQuery(con, sql) -> datos
a <- table(datos$Texto)
tot <- sum(datos$Cantidad)
r <- datos$Cantidad / tot
old = options(digits=2) 
r <- r * 100
#datos$Texto
datos$Cantidad
r
dbDisconnect(con)