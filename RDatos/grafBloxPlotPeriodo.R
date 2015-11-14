# grafBloxPlot.R : Grafico de cajas

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
idPeriodo <- args[2]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste('SELECT R.RespuestaTexto FROM respuestaspreguntas R INNER JOIN respuestas E ON R.idRespuesta = E.idRespuesta WHERE E.idPeriodo = ',idPeriodo,' AND R.idPregunta = ',idP,sep='')
dbGetQuery(con, sql) -> datos
datos <- as.numeric(datos$RespuestaTexto)
nom <- paste('../Datos/img/graBloxPlot',idP,idPeriodo,'.png',sep='')
png(file=nom)
boxplot(datos,col=7)
dev.off()
dbDisconnect(con)