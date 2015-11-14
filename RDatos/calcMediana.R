# calcMediana.R : Calcular mediana de las preguntas con texto

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste('SELECT RespuestaTexto FROM respuestaspreguntas WHERE idPregunta = ',idP,sep='')
dbGetQuery(con, sql) -> datos
datos <- datos$RespuestaTexto
mediana <- median(datos)
mediana
dbDisconnect(con)