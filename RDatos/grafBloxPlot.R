# grafBloxPlot.R : Grafico de cajas

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste('SELECT RespuestaTexto FROM respuestaspreguntas WHERE idPregunta = ',idP,sep='')
dbGetQuery(con, sql) -> datos
datos <- as.numeric(datos$RespuestaTexto)
nom <- paste('../Datos/img/graBloxPlot',idP,'.png',sep='')
png(file=nom)
boxplot(datos,col=7)
dev.off()
dbDisconnect(con)