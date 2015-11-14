# calcMediana.R : Calcular mediana de las preguntas con texto

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
idPeriodo <- args[2]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste('SELECT O.Texto,O.Orden FROM opcionespreguntas O INNER JOIN respuestaspreguntas R ON O.idOpcion = R.idOpcion INNER JOIN respuestas E ON R.idRespuesta = E.idRespuesta WHERE E.idPeriodo = ',idPeriodo,' AND O.idPregunta = ',idP,sep='')
dbGetQuery(con, sql) -> datos
textos <- datos$Texto
datos <- datos$Orden
valores <- datos[order(datos)]
mediana <- if((length(valores)%%2) != 0){textos[((length(valores)/2)+1)]} else textos[(length(valores)/2)]
mediana
dbDisconnect(con)