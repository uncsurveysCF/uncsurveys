# calcVarianza.R : Calcular varianza para escalas intervalo y Razon

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste("SELECT RespuestaTexto FROM respuestaspreguntas WHERE RespuestaTexto <> '' AND idPregunta = ",idP,sep='')
dbGetQuery(con, sql) -> datos
datos <- as.numeric(datos$RespuestaTexto)
v <- var(datos)
vs <- round(v, digits=2) 
vs
dbDisconnect(con)