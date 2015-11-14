# calcQuartiesPeriodo.R : Calcular quartiles de las preguntas con escala ordinal

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
idPeriodo <- args[2]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste('SELECT O.Texto,O.Orden from opcionespreguntas O INNER JOIN respuestaspreguntas R ON O.idOpcion = R.idOpcion INNER JOIN respuestas E ON R.idRespuesta = E.idRespuesta WHERE E.idPeriodo = ',idPeriodo,' AND O.idPregunta = ',idP,sep='')
dbGetQuery(con, sql) -> datos
mod <- quantile(datos$Orden, c(0.25,0.75), type = 1)
mod
dbDisconnect(con)