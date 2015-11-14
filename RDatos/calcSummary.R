# calcSummary.R : Calcular medidas de tendencia central

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste("SELECT RespuestaTexto FROM respuestaspreguntas WHERE RespuestaTexto <> '' AND idPregunta = ",idP,sep='')
dbGetQuery(con, sql) -> datos
datos <- as.numeric(datos$RespuestaTexto)
summary(datos)
dbDisconnect(con)