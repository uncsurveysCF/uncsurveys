# calcVarianza.R : Calcular varianza para escalas intervalo y Razon

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
idPeriodo <- args[2]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste('SELECT R.RespuestaTexto FROM respuestaspreguntas R INNER JOIN respuestas E ON R.idRespuestas = E.idRespuesta WHERE E.idPeriodo = ',idPeriodo,' R.idPregunta = ',idP,sep='')
dbGetQuery(con, sql) -> datos
datos <- as.numeric(datos$RespuestaTexto)
v <- var(datos)
vs <- round(v, digits=2) 
vs
dbDisconnect(con)