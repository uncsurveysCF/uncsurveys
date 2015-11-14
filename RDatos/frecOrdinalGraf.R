# frecOrdinalGraf.R : Grafico de bloques por escala ordinal

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste('SELECT O.Texto from opcionespreguntas O INNER JOIN respuestaspreguntas R ON O.idOpcion = R.idOpcion where O.idPregunta = ',idP,sep='')
datos <- dbGetQuery(con, sql)
a <- table(datos$Texto)
nom <- paste('../Datos/img/graBloq',idP,'.png',sep='')
png(file=nom)
barplot(a,col = rainbow(nrow(a)))
dev.off()
dbDisconnect(con)